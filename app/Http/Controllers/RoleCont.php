<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PermGroup;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $roles_all = Role::orderBy('name')->get();
        $perm_group_all = PermGroup::orderBy('group_name')->get();
        $perm_all = Permission::orderBy('name')->get();
        $user_all = User::orderBy('name')->get();

        return view('admin.role.role_store', [
            'roles_all' => $roles_all,
            'perm_group_all' => $perm_group_all,
            'perm_all' => $perm_all,
            'user_all' => $user_all,
        ]);
    }

    function users_role(){
        $roles_all = Role::orderBy('name')->get();
        $users_all = User::orderBy('name')->get();

        // === () ===
        $user_with_roles = User::has('roles')->orderBy('name')->get();

        foreach($users_all as $sl=>$user){
            if (DB::table('model_has_roles')->where('model_id', $user->id)->exists()){
                $role_users[] = $user->id;
            }
        }

        return view('admin.role.role_users', [
            'roles_all' => $roles_all,
            'users_all' => $users_all,
            'role_users' => $role_users,
            'user_with_roles' => $user_with_roles,
        ]);
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

    // === Insert Role ===
    function insert_role(Request $request){
        $request->validate([
            'role_name' => 'required|max:255|unique:roles,name',
            'perm_id' => 'required',
        ], [
            'perm_id.required' => 'No Permissions Selected!' 
        ]);
        
        $role = Role::create([
            'name' => Str::title($request->role_name),
        ]);

        $role->givePermissionTo($request->perm_id);
        return back()->with('job_upd', 'New Role Added!');
    }

    // === Delete Role ===
    function delete_role($role_id){
        Role::find($role_id)->delete();
        DB::table('role_has_permissions')->where('role_id', $role_id)->delete();
        DB::table('model_has_roles')->where('role_id', $role_id)->delete();
        return back()->with('del', 'Role Removed Successfully!');
    }

    // === Edit Role ===
    function edit_role($role_id){
        $role_info = Role::find($role_id);
        $perm_group_all = PermGroup::orderBy('group_name')->get();
        $perm_all = Permission::orderBy('name')->get();

        return view('admin.role.edit_role', [
            'role_info' => $role_info,
            'perm_group_all' => $perm_group_all,
            'perm_all' => $perm_all,
        ]);
    }

    // === Assign Role ===
    function role_assign(Request $request){
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::find($request->user_id);
        $user->syncRoles($request->role_id);
        return back()->with('job_upd', 'Role assigned to User!');
    }

    // === User Role Edit ===
    function user_role_edit($user_id){
        $user_info = User::find($user_id);
        $roles_all = Role::orderBy('name')->get();
        $perm_all = Permission::orderBy('name')->orderBy('group_id')->get();

        return view('admin.role.user_role_edit', [
            'user_info' => $user_info,
            'roles_all' => $roles_all,
            'perm_all' => $perm_all,
        ]);
    }

    // === Remove Role ===
    function user_role_remove($user_id){
        $user = User::find($user_id);
        DB::table('model_has_permissions')->where('model_id', $user_id)->delete();
        DB::table('model_has_roles')->where('model_id', $user_id)->delete();
        return back()->with('del', 'Role Removed from User!');
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
            $perm_all = Permission::all();
            $old_perm_name = Permission::find($perm_id)->name;
            $perm_name = $request->perm_name[$sl];
            
            if($perm_name != $old_perm_name){
                if($perm_name == ''){
                    return back()->with([
                        'error' => 'Invalid Permission Name!',
                        'err_id' => $perm_id,
                        'err_val' => $perm_name,
                        ])->withInput();
                    }

                    if(DB::table('permissions')->where('name', $perm_name)->exists()){
                    return back()->with([
                        'error' => 'Permission already exists!',
                        'err_id' => $perm_id,
                        'err_val' => $perm_name,
                        ])->withInput();
                    }
                }

                Permission::find($perm_id)->update([
                'name' => $request->perm_name[$sl],
            ]);
        }
        
        return back()->with('job_upd', 'Permissions Updated!');
    }





    // === Role Update ===
    function role_update(Request $request){
        $request->validate([
            'perm_id' => 'required',
        ], [
            'perm_id.required' => 'No Permissions Selected!' 
        ]);

        $old_role_name = Role::find($request->role_id)->name;
        $role_name = $request->role_name;
        
        if($role_name != $old_role_name){
            $request->validate([
                'role_name' => 'required|max:255|unique:roles,name',
            ]);
        }

        Role::find($request->role_id)->update([
            'name' => Str::title($request->role_name),
        ]);

        $role = Role::find($request->role_id);
        $role->syncPermissions($request->perm_id);
        return back()->with('job_upd', 'Role Updated Successfully!');
    }





    // === User Role Update ===
    function user_role_update(Request $request){
        $user = User::find($request->user_id);
        $user->syncRoles($request->role_id);
        $user->syncPermissions($request->perm_id);

        return back()->with('job_upd', 'User Role Updated!');
    }
}





