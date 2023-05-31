<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleCont extends Controller
{
    function perm_store(){
        return view('admin.role.perm_store');
    }

    function perm_edit(){
        return view('admin.role.edit_perm');
    }

    function role_store(){
        return view('admin.role.role_store');
    }
}
