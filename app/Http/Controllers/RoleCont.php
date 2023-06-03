<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PermGroup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function perm_store(){
        $perm_group_all = PermGroup::orderBy('group_name')->get();
        $perm_all = Permission::orderBy('name')->get();

        return view('admin.role.perm_store', [
            'perm_group_all' => $perm_group_all,
            'perm_all' => $perm_all,
        ]);
    }

    function role_store(){
        return view('admin.role.role_store');
    }



    // === Insert Perm_Group ===
    function perm_group_insert(Request $request){
        $request->validate([
            'perm_group' => 'required|max:255|unique:perm_groups,group_name',
        ]);

        PermGroup::insert([
            'group_name' => Str::ucfirst(Str::lower($request->perm_group)),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('job_upd', 'New Group Created!');
    }

    // === Insert Permissions ===
    function perm_insert(Request $request){
        $request->validate([
            'perm_name' => 'required|max:255|unique:permissions,name',
            'group_id' => 'required',
        ]);
        
        $permission = Permission::create([
            'name' => Str::lower($request->perm_name),
            'group_id' => $request->group_id,
        ]);
        return back()->with('job_upd', 'New Permission Added!');
    }

    // === Delete Permission Group ===
    function perm_group_delete($group_id){
        PermGroup::find($group_id)->delete();
        Permission::where('group_id', $group_id)->delete();
        return back()->with('del', 'Permission Group Removed!');
    }

    // === Permission Edit ===
    function perm_group_edit($group_id){
        $group_info = PermGroup::find($group_id);
        $group_perms = Permission::where('group_id', $group_id)->orderBy('name')->get();

        return view('admin.role.edit_perm', [
            'group_info' => $group_info,
            'group_perms' => $group_perms,
        ]);
    }

    // === Permission Delete ===
    function perm_delete($perm_id){
        Permission::find($perm_id)->delete();
        return back()->with('del', 'Permission Removed!');
    }




    // === Permission Update ===
    function perm_update(Request $request){
        $old_group_name = PermGroup::find($request->group_id)->group_name;
        $group_name = $request->perm_group;

        if($group_name != $old_group_name){
            $request->validate([
                'perm_group' => 'required|max:255|unique:perm_groups,group_name',
            ]);
        }



        PermGroup::find($request->group_id)->update([
            'group_name' => Str::ucfirst(Str::lower($request->perm_group)),
        ]);

        foreach($request->perm_id as $sl=>$perm_id){
            $old_perm_name = Permission::find($perm_id)->name;
            $perm_name = $request->perm_name[$sl];

            if($perm_name != $old_perm_name){

                print_r($perm_name);
                // $request->validate([
                //     'perm_name.*' => 'required|max:255|unique:permissions,name',
                // ]);
            }

            // print_r($perm_name);

            Permission::find($perm_id)->update([
                'name' => $request->perm_name[$sl],
            ]);
        }

        // return $request->all();
        // return back();
    }
}
