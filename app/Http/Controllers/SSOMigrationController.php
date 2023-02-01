<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SSOMigrationController extends Controller
{

    public function render(){
        return view('migration_form');
    }

}
