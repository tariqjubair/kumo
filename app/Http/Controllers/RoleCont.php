<?php

namespace App\Http\Controllers;

use App\Models\PermGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function perm_store(){
        return view('admin.role.perm_store');
    }

    function perm_edit(){
        return view('admin.role.edit_perm');
    }

    function role_store(){
        return view('admin.role.role_store');
    }



    // === Insert Perm_Group ===
    function perm_group_insert(Request $request){
        $request->validate([
            'perm_group' => 'required',
        ]);

        PermGroup::insert([
            'group_name' => $request->perm_group,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('job_upd', 'New Permission-Group Created!');
    }
}
