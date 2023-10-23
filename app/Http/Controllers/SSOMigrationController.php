<?php

namespace App\Http\Controllers;

use App\Http\Object\SSOPNJUser;
use App\Models\MigrationUser;
use App\Support\KeycloakInstance;
use DateTime;
use Fschmtt\Keycloak\Collection\GroupCollection;
use Fschmtt\Keycloak\Representation\Group;
use Fschmtt\Keycloak\Representation\User;
use Fschmtt\Keycloak\Type\Map;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use TypeError;

class SSOMigrationController extends Controller
{

    protected $client;
    protected $realm;

    public function __construct()
    {
        $this->client = KeycloakInstance::getKeycloakInstance();
        $this->realm = 'dev-sso';
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * returns the first step form view
     */
    public function render()
    {

        $users = MigrationUser::take(10)->get();
        $newUsers = Collection::empty();

        foreach ($users as $user) {
            $newUser = new SSOPNJUser($user);
            $newUsers->add($newUser);
        }

        return view('migration_form');
    }

    public function verifyUser(Request $request)
    {
        // dd($request->all());
        $user = MigrationUser::where([
            ["username", $request->oldUsername],
            ["password", md5($request->oldPassword)]
        ])->first();
        // dd($user, strlen($user->username));

        switch ($user->jabatan) {
            case 'Mahasiswa':
                $data = SSOMigrationController::dataMhsw($user);
                $representation_user = $data['user'];
                break;
            case 'Dosen':
                $representation_user = SSOMigrationController::dataDosen($user);
                break;
            case 'Staf':
                $representation_user = SSOMigrationController::dataStaf($user);
                break;
            default:
                # code...
                break;
        }

        try {

            $import = $this->client->users()->create($this->realm, $representation_user);
            dd($import);
        } catch (ClientException $error) {

            if ($user->jabatan === "Mahasiswa") {
                SSOMigrationController::newSubGroup($data);
            }
        }
    }

    function dataMhsw($user)
    {
        //First and Last Name
        $parts = explode(' ', $user->nama);
        $firstName = $parts[0];
        $lastName = implode(' ', array_slice($parts, 1));

        //Mahasiswa or Alumni
        $expire_date = DateTime::createFromFormat('Y-m-d', $user->expire_date);
        if ($expire_date->format('Y-m-d') <= now()->format('Y-m-d')) {
            $groups = "Alumni" . '/' . $user->jurusan;
        } else {
            $angkatan = '20' . str(substr($user->username, 0, 2));
            $groups = 'Mahasiswa/' . $user->jurusan . '/' . $angkatan;
        }

        $representation_user = new User(
            id: $user->username,
            email: $user->email_pnj,
            emailVerified: true,
            enabled: true,
            firstName: $firstName,
            lastName: $lastName,
            username: $user->username,
            groups: [$groups],
        );

        return [
            'user' => $representation_user,
            'jurusan' => $user->jurusan,
            'angkatan' => $angkatan,
        ];
    }

    function newSubGroup($data)
    {
        $jurusan = $data['jurusan'];
        $angkatan = $data['angkatan'];

        //Get All Mahasiswa Group
        $group_mhsw =  $this->client->groups()->get($this->realm, "294cbbe6-c7f0-458c-bc82-efc57ff901a1");
        $mhsw = json_decode(json_encode($group_mhsw));

        //Get Id based on jurusan
        $subGroups = $mhsw->subGroups;

        for ($i = 0; $i < count($subGroups); $i++) {
            if (strpos($subGroups[$i]->name, $jurusan) !== false) {
                $id_jurusan = $subGroups[$i]->id;
                $index_jurusan =  $i;
            }
        }
        // dd($id_jurusan);

        //Get Jurusan
        $group_mhsw =  $this->client->groups()->get($this->realm, $id_jurusan);
        $newGroup = new Group(
            attributes: new Map(
                [
                    "unit_name" => [$angkatan],
                    "description" => ["Akun Mahasiswa untuk Jurusan " . $jurusan . " Angkatan " . $angkatan],
                    "version" => ["1.0"],
                    "short_unit_name" => ["TM-2019"],
                ]
            ),
            clientRoles: new Map(),
            name: $angkatan,
            path: "/Mahasiswa/" . $jurusan . "/" . $angkatan,
            subGroups: new GroupCollection(),
        );
        $group_mhsw->subGroups->add($newGroup);
        // dd($group_mhsw);

        $update = $this->client->groups()->update($this->realm, $id_jurusan, $group_mhsw);
        dd($update, $group_mhsw, $this->client->groups()->get($this->realm, $id_jurusan));

        // $group_mhsw =  $this->client->groups()->get($this->realm, "294cbbe6-c7f0-458c-bc82-efc57ff901a1");
        // $group_mhsw->subGroups->add($newGroup);
        // $update = $this->client->groups()->update($this->realm, "294cbbe6-c7f0-458c-bc82-efc57ff901a1", $group_mhsw);
        // dd($update, $group_mhsw, $this->client->groups()->get($this->realm, "294cbbe6-c7f0-458c-bc82-efc57ff901a1"));
    }

    function checkAngkatan($nim, $jurusan)
    {
        $angkatan = '20' . str(substr($nim, 0, 2));
        $path = 'Mahasiswa/' . $jurusan . '/' . $angkatan;

        // //Ambil data Mahasiswa
        // $mhsw =  $this->client->groups()->get($this->realm, "294cbbe6-c7f0-458c-bc82-efc57ff901a1");

        // //Cari Jurusan
        // $subGroups = $mhsw->subGroups;
        // dd(
        //     array_filter($subGroups, function ($group) use ($jurusan) {
        //         return $group->name == $jurusan;
        //     })
        // );

        $group = new Group(
            name: $angkatan,
        );
        // dd($group);
        $this->client->groups()->create($this->realm, $group);
        return $path;
    }

    function dataDosen($user)
    {
        //First and Last Name
        $parts = explode(' ', $user->nama);
        $firstName = $parts[0];
        $lastName = implode(' ', array_slice($parts, 1));
        $representation_user = new User(
            id: $user->username,
            email: $user->email_pnj,
            emailVerified: true,
            enabled: true,
            firstName: $firstName,
            lastName: $lastName,
            username: $user->username,
            groups: ['/Dosen/' + $user->jurusan],
        );
        return $representation_user;
    }

    function dataStaf($user)
    {
        //First and Last Name
        $parts = explode(' ', $user->nama);
        $firstName = $parts[0];
        $lastName = implode(' ', array_slice($parts, 1));

        $representation_user = new User(
            id: $user->username,
            email: $user->email_pnj,
            emailVerified: true,
            enabled: true,
            firstName: $firstName,
            lastName: $lastName,
            username: $user->username,
            groups: ['/Staf/Data Migrasi'],
        );
        return $representation_user;
    }
}
