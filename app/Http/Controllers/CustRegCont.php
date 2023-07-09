<?php

namespace App\Http\Controllers;

use App\Models\CustEmailVerify;
use Carbon\Carbon;
use App\Models\CustInfo;
use App\Notifications\EmailVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CustRegCont extends Controller
{
    function customer_register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:cust_infos'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $cust_info = CustInfo::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);

        $token_info = CustEmailVerify::create([
            'customer_id' => $cust_info->id,
            'token' => uniqid(),
        ]);

        Notification::send($cust_info, new EmailVerify($token_info));

        return back()->with([
            'cust_reg' => 'Verification Link Sent to Mail!',
            'cust_reg2' => 'Please Verify before Login!',
        ]);
    }

    function reg_email_verify($token){
        if(CustEmailVerify::where('token', $token)->exists()){
            $cust_info = CustEmailVerify::where('token', $token)->first();

            CustInfo::find($cust_info->customer_id)->update([
                'email_verified_at' => Carbon::now(),
            ]);

            CustEmailVerify::where('token', $token)->delete();

            return redirect()->route('customer_login')->with([
                'reg_success' => 'Email has been verified!',
                'reg_success2' => 'Please Login to Continue.',
            ]);
        }
        else {
            return redirect()->route('customer_login')->with([
                'reg_fail' => 'Invalid Request!',
            ]);
        }
    }
}
