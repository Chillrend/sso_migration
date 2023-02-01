<?php

namespace App\Http\Object;

use Fschmtt\Keycloak\Representation\User as UserRepresentation;
use App\Models\MigrationUser;

class SSOPNJUser extends UserRepresentation
{

    public function __construct(MigrationUser $oldUser){
        $this->username = $oldUser->username;
    }

}
