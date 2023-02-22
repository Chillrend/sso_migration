import KcAdminClient from '@keycloak/keycloak-admin-client'
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


const groupObject = groups.groups

for (let i = 0; i < groupObject.length; i++) {
    const group = groupObject[i];

    try{
        const kcGroups = await kcAdminClient.groups.find();
        const found = kcGroups.find(elements => elements.name === group.name);
        if(found){
            console.info("Found group in KC: " + found.name + " using ID instead of creating a new group");
        }else{
            console.info("Creating new group: " + group.name);
        }

        let kcGroup = found ? found : await kcAdminClient.groups.create(group);

        if(group.hasOwnProperty("subGroups") && !!group.subGroups){
            let subGroups = group.subGroups;
            console.info("Group " + group.name + " has " + subGroups.length + " subGroup(s), Creating it now...")
            for (let j = 0; j < subGroups.length; j++) {
                let subGroup = subGroups[j];
                const kcSubGroup = await kcAdminClient.groups.setOrCreateChild({id: kcGroup.id}, subGroup);
                console.info("Created subGroup " + subGroup.name + `(${kcSubGroup.id})` + " from Group: " + group.name);
            }
        }

    }catch (e) {
        console.log(e)
    }

}
