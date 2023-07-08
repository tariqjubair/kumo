<?php

namespace App\Http\Controllers;

use App\Models\CustInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginCont extends Controller
{
    // === GitHub Login ===
    function github_redirect(){
        return Socialite::driver('github')->redirect();
    }

    function github_callback(){
        $user = Socialite::driver('github')->user();
        // return $user->getName();
        // return $user->getEmail();

        if(CustInfo::where('email', $user->getEmail())->doesntExist()){
            CustInfo::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('@Kumo#123@'),
                'created_at' => Carbon::now(),
            ]);
        }

        if(Auth::guard('CustLogin')->attempt(['email' => $user->getEmail(), 'password' => '@Kumo#123@'])){
            $full_name = $user->getName();
            $name = explode(' ', $full_name)[0];

            return redirect()->route('home_page')->with([
                'user_login' => 'Welcome '.$name.' !',
                'full_name' => $full_name,
            ]);
        }
        else {
            return redirect()->route('customer_login')->with([
                'login_fail' => 'Profile with same Email already Exists!',
            ]);
        }
    }





    // === Google Login ===
    function google_redirect(){
        return Socialite::driver('google')->redirect();
    }

    function google_callback(){
        $user = Socialite::driver('google')->user();

        if(CustInfo::where('email', $user->getEmail())->doesntExist()){
            CustInfo::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('@Kumo#123@'),
                'created_at' => Carbon::now(),
            ]);
        }

        if(Auth::guard('CustLogin')->attempt(['email' => $user->getEmail(), 'password' => '@Kumo#123@'])){
            $full_name = $user->getName();
            $name = explode(' ', $full_name)[0];

            return redirect()->route('home_page')->with([
                'user_login' => 'Welcome '.$name.' !',
                'full_name' => $full_name,
            ]);
        }
        else {
            return redirect()->route('customer_login')->with([
                'login_fail' => 'Profile with same Email already Exists!',
            ]);
        }
    }




    // === Facebook Login ===
    function facebook_redirect(){
        return Socialite::driver('facebook')->redirect();
    }

    function facebook_callback(){
        $user = Socialite::driver('facebook')->user();

        if(CustInfo::where('email', $user->getEmail())->doesntExist()){
            CustInfo::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('@Kumo#123@'),
                'created_at' => Carbon::now(),
            ]);
        }

        if(Auth::guard('CustLogin')->attempt(['email' => $user->getEmail(), 'password' => '@Kumo#123@'])){
            $full_name = $user->getName();
            $name = explode(' ', $full_name)[0];

            return redirect()->route('home_page')->with([
                'user_login' => 'Welcome '.$name.' !',
                'full_name' => $full_name,
            ]);
        }
		else {
            return redirect()->route('customer_login')->with([
                'login_fail' => 'Profile with same Email already Exists!',
            ]);
        }
    }




    // === Twitter Login ===
    function twitter_redirect(){
        return Socialite::driver('twitter')->redirect();
    }

    function twitter_callback(){
        $user = Socialite::driver('twitter')->user();

        if(CustInfo::where('email', $user->getEmail())->doesntExist()){
            CustInfo::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('@Kumo#123@'),
                'created_at' => Carbon::now(),
            ]);
        }

        if(Auth::guard('CustLogin')->attempt(['email' => $user->getEmail(), 'password' => '@Kumo#123@'])){
            $full_name = $user->getName();
            $name = explode(' ', $full_name)[0];

            return redirect()->route('home_page')->with([
                'user_login' => 'Welcome '.$name.' !',
                'full_name' => $full_name,
            ]);
        }
		else {
            return redirect()->route('customer_login')->with([
                'login_fail' => 'Profile with same Email already Exists!',
            ]);
        }
    }






}
