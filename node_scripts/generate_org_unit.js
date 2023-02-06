
const fs = require('fs');
const csvToObj = require('csv-to-js-parser').csvToObj;

const data = fs.readFileSync('jurusan_unit.csv').toString();

let jurusan = csvToObj(data);

console.log(JSON.stringify(jurusan));
