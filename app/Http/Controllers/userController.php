<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserNotif;
use App\Notifications\UserCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;

use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class userController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // === User-List Page ===
    function user_list(){
        $all_user = User::where('id', '!=', Auth::id())->get();
        return view('admin.user.user_list', compact('all_user'));
    }

    // === Delete User ===
    function user_del($user_id){
        User::find($user_id)-> delete();
        return back()->with('del_success', 'User Deleted Successfully!');
    }

    // === User Profile Page ===
    function profile(){
        $user_notif = UserNotif::where('email', Auth::user()->email)->where('route', 'profile')->first();
        $user_notif->update([
            'status' => 0,
        ]);

        return view('admin.user.profile');
    }


    // === User Role-Permission Page ===
    function user_role(){
        $user_info = User::find(Auth::user()->id);
        $user_notif = UserNotif::where('email', Auth::user()->email)->where('route', 'role')->get();
        
        foreach($user_notif as $role){
            $role->update([
                'status' => 0,
            ]);
        }

        return view('admin.user.role', [
            'user_info' => $user_info,
        ]);
    }


    // === User Notifications Page ===
    function user_notifications(){
        $user_notif = UserNotif::where('email', Auth::user()->email);
        $notif_count = $user_notif->count();
        $notif_all = $user_notif->get();

        return view('admin.user.notif', [
            'notif_count' => $notif_count,
            'notif_all' => $notif_all,
        ]);
    }


    // === Notification Delete ===
    function notif_delete($notif_id){
        UserNotif::find($notif_id)->delete();

        return back()->with([
            'del' => 'Notification Deleted!',
        ]);
    }


    // === Add User ===
    function add_user(){
        return view('admin.user.add_user');
    }



    function notif_route($ext_info){
        $user_name = Auth::user()->name;

        if($ext_info == 'profile'){
            return redirect()->route('user.profile')->with([
                'user_name' => $user_name,
                'msg' => 'Welcome to Kumo Dashboard! Please update your Profile.'
            ]);
        }
        if($ext_info == 'role'){
            return redirect()->route('user.role')->with([
                'user_name' => $user_name,
                'msg' => 'Congratulations on your New Role! Please review permissions assigned to you.'
            ]);
        }
    }



    // === Insert User ===
    function insert_user(Request $request){
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password'=> ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
		    'password_confirmation'=> 'required',
        ]);

        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);

        $new_user = User::where('email', $request->email)->first();
        $new_user->update([
            'status' => 2,
        ]);

        UserNotif::insert([
            'fname' => explode(' ', trim($request->name))[0],
            'email' => $request->email,
            'image' => 'user.png',
            'heading' => 'Welcome! User Created',
            'route' => 'profile',
            'status' => 1,
            'creator' => explode(' ', trim($request->creator))[0],
            'created_at' => Carbon::now(),
        ]);

        $temp_pass = $request->password;
        Notification::send($new_user, new UserCreated($new_user, $temp_pass));

        return back()->with([
            'name' => $request->name,
            'msg' => 'User Added!',
        ]);
    }




    // === User Info Update ===
    function user_info_upd(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        // if($request->email != Auth::user()->email){
        //     $request->validate([
        //         'email' => 'required|unique:users',
        //     ]);
        // }

        User::find(Auth::id())-> update([
            'name' => $request->name,
            // 'email' => $request->email,
        ]);
        return back()->with('info_upd','Your Information Updated!');
    }

    // === User Pass Update ===
    function user_pass_upd(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password'=> ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
		    'password_confirmation'=> 'required',
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password' => bcrypt($request->password),
            ]);
            return back()->with('pass_upd', 'Password Updated!');
        }
        else {
            return back()->with('old_pass_err', 'Password does not Match!');
        }
    }

    // === User Pic Update ===
    function user_pic_upd(Request $request){
        $user_info = User::find(Auth::id());

        $request->validate([
            'image' => 'required|mimes:png,jpg|max:1024',
        ]);

        if($user_info->image){
            $del_old_image = public_path('uploads/user/'.$user_info->image);
            unlink($del_old_image);
        }

        $uploaded_file = $request->image;
        $ext = $uploaded_file->getClientOriginalExtension();
        $file_name = Auth::id().'.'.$ext;
        Image::make($uploaded_file)->resize(200, 200)->save(public_path('uploads/user/'. $file_name));

        User::find(Auth::id())->update([
            'image' => $file_name,
        ]);
        return back()->with('img_upd', 'Profile Pic Updated!');
    }
}
