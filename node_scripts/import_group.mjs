import KcAdminClient from '@keycloak/keycloak-admin-client';
import * as dotenv from 'dotenv';
import groups from './groups.json' assert {type: "json"}

dotenv.config({path: '../.env'});

const kcAdminClient = new KcAdminClient()

kcAdminClient.setConfig({
    baseUrl: process.env.KC_BASE_URL
})

await kcAdminClient.auth({
    username: process.env.KC_USERNAME,
    password: process.env.KC_PASSWORD,
    clientId: process.env.KC_CLIENT_ID,
    grantType: 'password'
})

kcAdminClient.setConfig({
    realmName: process.env.KC_REALMS
})

const testing = await kcAdminClient.users.count();
console.log(groups)
