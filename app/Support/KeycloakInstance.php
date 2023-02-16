<?php

namespace App\Support;

use Fschmtt\Keycloak\Keycloak;

class KeycloakInstance
{
    public static function getKeycloakInstance(): Keycloak
    {
        return new Keycloak(
            baseUrl: config('app.keycloak_base_url'),
            username: config('app.keycloak_username'),
            password: config('app.keycloak_password')
        );
    }


}
