<?php

namespace App\Http\Controllers;

use App\Support\KeycloakInstance;
use Fschmtt\Keycloak\Resource\Groups;
use Fschmtt\Keycloak\Keycloak;
use Fschmtt\Keycloak\Resource\Realms;
use Illuminate\Http\Request;

class checkController extends Controller
{
    private $keycloak;
    private $realm;

    public function __construct()
    {
        $this->keycloak = KeycloakInstance::getKeycloakInstance();
        $this->realm = 'dev-sso';
    }

    public function check()
    {
        $keycloak = $this->keycloak;

        dd($keycloak->serverInfo()->get());

        return response()->json($keycloak->serverInfo());
    }

    public function getAllGroups()
    {
        $groups = $this->keycloak->groups()->all($this->realm);
        // dd($groups->add());
        return response()->json($groups);
    }

    public function getAllUsers()
    {
        $realm = 'dev-sso';
        $users = $this->keycloak->users()->all($this->realm);
        dd($users);
    }

    public function getUser()
    {
        dd($this->keycloak->users()->get($this->realm, "e83e31bc-d545-4742-8296-21146ca720d3"));
    }

    public function getGroup()
    {
        dd($this->keycloak->groups()->get($this->realm, "5deda925-8c70-45b0-964e-348ed90a229f"));
    }
}
