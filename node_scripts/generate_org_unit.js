import {groups as base_group} from "./base_group";

const fs = require('fs');
const csvToObj = require('csv-to-js-parser').csvToObj;

const data = fs.readFileSync('jurusan_unit.csv').toString();

let org_units = csvToObj(data);

let mahasiswa_groups = base_group.groups[0];
let alumni_groups = base_group.groups[1];
let dosen_groups = base_group.groups[2];
let staf_groups = base_group.groups[3];
let pimpinan_groups = base_group.groups[4];
org_units.forEach((unit) => {
    // Mahasiswa
    if(unit.jurusan === "TRUE"){
        let jurusan = {
            name: unit.name,
            attributes: {
                description: (unit.description, "Mahasiswa"),
                version: "1.0",
                short_unit_name: unit.short_unit_name,
                unit_name: unit.short_unit_name
            },
        }

        mahasiswa_groups.sub_groups.push(jurusan);
    }
})



console.log(JSON.stringify(mahasiswa_groups));
