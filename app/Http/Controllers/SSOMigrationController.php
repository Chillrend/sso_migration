<?php

namespace App\Http\Controllers;

use App\Http\Object\SSOPNJUser;
use App\Models\MigrationUser;
use App\Support\KeycloakInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SSOMigrationController extends Controller
{

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
        $user = MigrationUser::where("username", $request->oldUsername)
            ->where("password", md5($request->oldPassword))->first();
        dd($user);
    }

    public function check()
    {
        $client = KeycloakInstance::getKeycloakInstance();

        dd($client->serverInfo()->get());

        return response()->json($client->serverInfo());
    }
}
