<?php

namespace App\Support;

use Fschmtt\Keycloak\Keycloak;
use Keycloak\Admin\KeycloakClient;

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

    public static function getKeycloakInstanceWaleed(): KeycloakClient {
        return KeycloakClient::factory([
            'grant_type' => 'password',
            'realm' => config('app.keycloak_realms'),
            'username' => config('app.keycloak_username'),
            'password' => config('app.keycloak_password'),
            'baseUri' => config('app.keycloak_base_url')
        ]);
    }


}
