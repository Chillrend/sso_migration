import KcAdminClient from '@keycloak/keycloak-admin-client'
import * as dotenv from 'dotenv';
import groups from './groups.json' assert {type: "json"}
import {Groups} from "@keycloak/keycloak-admin-client/lib/resources/groups";

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

const groupObject = groups.groups

for (let i = 0; i < groupObject.length; i++) {

}

const createKcGroupRecursively = (group, kcClient, parentName) => {

}
