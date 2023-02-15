const files = require('./base_group');
const base_group = files();

const format = require('string-format');

const fs = require('fs');
const csvToObj = require('csv-to-js-parser').csvToObj;

const data = fs.readFileSync('jurusan_unit.csv').toString();

const KeycloakAdminClient = require("@keycloak/keycloak-admin-client");
const kcClient = new KeycloakAdminClient();

let org_units = csvToObj(data);

let mahasiswa_groups = base_group.groups[0];
let alumni_groups = base_group.groups[1];
let dosen_groups = base_group.groups[2];
let staf_groups = base_group.groups[3];
let pimpinan_groups = base_group.groups[4];
let tamu_groups = base_group.groups[5];
let admin_groups = base_group.groups[6];
org_units.forEach((unit) => {
    // Mahasiswa, Dosen, dan Jurusan
    if(unit.jurusan === "TRUE"){
        ["Mahasiswa", "Dosen", "Alumni"].forEach((types) => {
            let jurusan = {
                name: unit.name_long,
                path: "/".concat(types).concat("/").concat(unit.name_long),
                attributes: {
                    description: format(unit.description, types),
                    version: "1.0",
                    short_unit_name: unit.name_short,
                    unit_name: unit.name_long
                },
            }

            switch (types) {
                case "Mahasiswa":
                    mahasiswa_groups.sub_groups.push(jurusan);
                    break;
                case "Dosen":
                    dosen_groups.sub_groups.push(jurusan);
                    break;
                case "Alumni":
                    alumni_groups.sub_groups.push(jurusan);
                    break;
            }

        });
    }else if(unit.parents === "Pimpinan"){
        let unit_pimpinan = {
            name: unit.name_long,
            path: pimpinan_groups.path.concat("/").concat(unit.name_long),
            attributes: {
                description: unit.description,
                version: "1.0",
                short_unit_name: unit.name_short,
                unit_name: unit.name_long
            },
        }
        pimpinan_groups.sub_groups.push(unit_pimpinan);
    }else if(unit.parents === "Staf"){
        let staf = {
            name: unit.name_long,
            path: staf_groups.path.concat("/").concat(unit.name_long),
            attributes: {
                description: unit.description,
                version: "1.0",
                short_unit_name: unit.name_short,
                unit_name: unit.name_long
            },
        }
        staf_groups.sub_groups.push(staf);
    }



})

const organization = [
    mahasiswa_groups,
    dosen_groups,
    alumni_groups,
    pimpinan_groups,
    dosen_groups,
    tamu_groups,
    admin_groups
]
kcClient.setConfig({
    realmName: "dev-sso"
})

(async() => {
    await kcClient.auth({
        username: "#",
        password: "#",
        grantType: "password",
        clientId: "admin-cli"
    })

    const users = await kcClient.users.find();
    console.log(JSON.stringify(users));
})
