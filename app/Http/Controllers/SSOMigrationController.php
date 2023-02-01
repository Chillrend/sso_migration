<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SSOMigrationController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * returns the first step form view
     */
    public function render(){
        return view('migration_form');
    }

}
