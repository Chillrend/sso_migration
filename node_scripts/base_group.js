module.exports = function generateGroupObjects () {
    return groups;
}
const groups = {
    groups: [
        {
            name: "Mahasiswa",
            path: "/Mahasiswa",
            attributes: {
                description: ["Group Untuk Akun Mahasiswa"],
                version: ["1.0"],
                short_unit_name: ["Mhsw"],
                unit_name: ["Mahasiswa"]
            },
            subGroups: []
        },
        {
            name: "Alumni",
            path: "/Alumni",
            attributes: {
                description: ["Group Untuk Akun Alumni"],
                version: ["1.0"],
                short_unit_name: ["Alumni"],
                unit_name: ["Alumni"]
            },
            subGroups: []
        },
        {
            name: "Dosen",
            path: "/Dosen",
            attributes: {
                description: ["Group Untuk Akun Dosen"],
                version: ["1.0"],
                short_unit_name: ["Dosen"],
                unit_name: ["Dosen"]
            },
            subGroups: []
        },
        {
            name: "Staf",
            path: "/Staf",
            attributes: {
                description: ["Group Untuk Akun Staf"],
                version: ["1.0"],
                short_unit_name: ["Staf"],
                unit_name: ["Staf"]
            },
            subGroups: []
        },
        {
            name: "Pimpinan",
            path: "/Pimpinan",
            attributes: {
                description: ["Group Untuk Akun Pimpinan dan Staff nya"],
                version: ["1.0"],
                short_unit_name: ["Pimpinan"],
                unit_name: ["Pimpinan"]
            },
            subGroups: []
        },
        {
            name: "Tamu",
            path: "/Tamu",
            attributes: {
                description: ["Group Untuk Tamu"],
                version: ["1.0"],
                short_unit_name: ["Tamu"],
                unit_name: ["Tamu"]
            }
        },
        {
            name: "Administrator",
            path: "/Administrator",
            attributes: {
                description: ["Group Untuk Akun Administrator Unit TI Politeknik Negeri Jakarta"],
                version: ["1.0"],
                short_unit_name: ["Admin"],
                unit_name: ["Admin"]
            }
        },
    ]
};
