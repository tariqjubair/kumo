<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleCont extends Controller
{
    function perm_store(){
        return view('admin.role.perm_store');
    }
}
