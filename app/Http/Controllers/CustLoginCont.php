<?php

namespace App\Http\Controllers;

use App\Models\CustInfo;
use Illuminate\Http\Request;
use App\Models\CustPassReset;
use App\Notifications\PassReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;

class CustLoginCont extends Controller
{
    function customer_login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $verify = '';
        if(DB::table('cust_infos')->where('email', $request->username)->exists()){
            $verify = CustInfo::where('email', $request->username)->first()->email_verified_at;
        }
        else if(DB::table('cust_infos')->where('mobile', $request->username)->exists()){
            $verify = CustInfo::where('mobile', $request->username)->first()->email_verified_at;
        }
        if (!$verify){
            return back()->with([
                'need_verify' => 'Email not Verified Yet!!'
            ]);
        }

        if(Auth::guard('CustLogin')->attempt(['email' => $request->username, 'password' => $request->password])){
            $full_name = CustInfo::where('email', $request->username)->get()->first()->name;
            $name = explode(' ', $full_name)[0];

            return redirect()->route('home_page')->with([
                'user_login' => 'Welcome '.$name.' !',
                'full_name' => $full_name,
            ]);
        }
        else if(Auth::guard('CustLogin')->attempt(['mobile' => $request->username, 'password' => $request->password])){
            $full_name = CustInfo::where('mobile', $request->username)->get()->first()->name;
            $name = explode(' ', $full_name)[0];

            return redirect()->route('home_page')->with([
                'user_login' => 'Welcome '.$name.' !',
                'full_name' => $full_name,
            ]);
        }
        else {
            return back()->with([
                'login_fail' => 'Oops! Username/Password Incorrect',
            ]);
        }
    }

    function customer_logout(){
        Auth::guard('CustLogin')->logout();
        return redirect()->route('customer_login')->with([
            'cust_logout' => 'Logged Out Successfully!'
        ]);
    }




    // === Password Reset ===
    function lost_password(){
        return view('frontend.lost_password');
    }

    function email_verify(Request $request){
        $request->validate([
            'email' => 'required',
        ]);

        if(CustInfo::where('email', $request->email)->exists())
        {
            $cust_info = CustInfo::where('email', $request->email)->first();
        }
        else {
            return back()->with([
                'inv_mail' => 'Invalid Email Address!!'
            ]);
        }

        CustPassReset::where('customer_id', $cust_info->id)->delete();

        $token_info = CustPassReset::create([
            'customer_id' => $cust_info->id,
            'token' => uniqid(),
        ]);

        Notification::send($cust_info, new PassReset($token_info));

        return back()->with([
            'success_msg' => 'Password Reset Request is sent!',
            'success2' => 'Check you Email Inbox!',
        ]);
    }

    function new_password($token){
        $token_info = CustPassReset::where('token', $token)->first();

        return view('frontend.reset_password', [
            'token_info' => $token_info,
        ]);
    }

    function reset_password(Request $request){
        $request->validate([
            'password'=> ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
            'password_confirmation'=> 'required',
        ]);

        // return $request->all();

        if(CustPassReset::where('token', $request->reset_token)->exists()){
            $cust_info = CustPassReset::where('token', $request->reset_token)->first();

            if (Carbon::now()->diffInDays($cust_info->created_at) > 1){
                return back()->with([
                    'expired' => 'Reset Token is Expired!!'
                ]);
            }
        }
        else {
            return back()->with([
                'expired' => 'Reset Token is Expired!!'
            ]);
        }

        if (CustInfo::where('id', $cust_info->customer_id)->exists()){
            CustInfo::find($cust_info->customer_id)->update([
                'password' => bcrypt($request->password),
            ]);
        }
        else {
            return back()->with([
                'inv_user' => 'Invalid User!!'
            ]);
        }

        CustPassReset::where('token', $request->reset_token)->delete();
        
        return back()->with([
            'success_msg' => 'Password has been reset!!',
        ]);
    }
}
