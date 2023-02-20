module.exports = function generateGroupObjects () {
    return groups;
}
const groups = {
    groups: [
        {
            name: "Mahasiswa",
            path: "/Mahasiswa",
            attributes: {
                descriptiones: "Group Untuk Akun Mahasiswa",
                version: "1.0",
                short_unit_name: "Mhsw",
                unit_name: "Mahasiswa"
            },
            sub_groups: []
        },
        {
            name: "Alumni",
            path: "/Alumni",
            attributes: {
                descriptiones: "Group Untuk Akun Alumni",
                version: "1.0",
                short_unit_name: "Alumni",
                unit_name: "Alumni"
            },
            sub_groups: []
        },
        {
            name: "Dosen",
            path: "/Dosen",
            attributes: {
                descriptiones: "Group Untuk Akun Dosen",
                version: "1.0",
                short_unit_name: "Dosen",
                unit_name: "Dosen"
            },
            sub_groups: []
        },
        {
            name: "Staf",
            path: "/Staf",
            attributes: {
                descriptiones: "Group Untuk Akun Staf",
                version: "1.0",
                short_unit_name: "Staf",
                unit_name: "Staf"
            },
            sub_groups: []
        },
        {
            name: "Pimpinan",
            path: "/Pimpinan",
            attributes: {
                descriptiones: "Group Untuk Akun Pimpinan dan Staff nya",
                version: "1.0",
                short_unit_name: "Pimpinan",
                unit_name: "Pimpinan"
            },
            sub_groups: []
        },
        {
            name: "Tamu",
            path: "/Tamu",
            attributes: {
                descriptiones: "Group Untuk Tamu",
                version: "1.0",
                short_unit_name: "Tamu",
                unit_name: "Tamu"
            }
        },
        {
            name: "Administrator",
            path: "/Administrator",
            attributes: {
                descriptiones: "Group Untuk Akun Administrator Unit TI Politeknik Negeri Jakarta",
                version: "1.0",
                short_unit_name: "Admin",
                unit_name: "Admin"
            }
        },
    ]
};
