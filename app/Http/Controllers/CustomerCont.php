<?php

namespace App\Http\Controllers;

use App\Models\BillingTab;
use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\CustInfo;
use App\Models\OrdereditemsTab;
use App\Models\OrderTab;
use App\Models\SiteinfoTab;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rules\Password;
use PDF;


class CustomerCont extends Controller
{
    function customer_profile(){
        if(!Auth::guard('CustLogin')->check()){
            return redirect()->route('customer_login')->with('cart_login', 'Please Login/Register to view your Profile!');
        }

        $cust_info = CustInfo::find(Auth::guard('CustLogin')->id());
        return view('frontend.cust_profile', [
            'cust_info' => $cust_info,
        ]);
    }

    function customer_order(){
        if(!Auth::guard('CustLogin')->check()){
            return redirect()->route('customer_login')->with('cart_login', 'Please Login/Register to view your Profile!');
        }

        $cust_info = CustInfo::find(Auth::guard('CustLogin')->id());
        $order_all = OrderTab::latest('id')->where('customer_id', Auth::guard('CustLogin')->id())->get();

        return view('frontend.cust_order', [
            'cust_info' => $cust_info,
            'order_all' => $order_all,
        ]);
    }

    function customer_wishlist(){
        if(!Auth::guard('CustLogin')->check()){
            return redirect()->route('customer_login')->with('cart_login', 'Please Login/Register to view your Profile!');
        }

        $cust_info = CustInfo::find(Auth::guard('CustLogin')->id());
        return view('frontend.cust_wishlist', [
            'cust_info' => $cust_info,
        ]);
    }

    function prof_get_city(Request $request){
        $sel_city = City::where('country_id', $request->country_id)->get();

        $str = '<option value="">-- Select City --</option>';
        foreach ($sel_city as $city){
            $str .= "<option value='$city->id'>$city->name</option>";
        }
        echo $str;
    }

    function prof_get_code(Request $request){
        $sel_code = Country::find($request->country_id)->phonecode;
        $str = "<option value='$sel_code'>$sel_code</option>";
        echo $str;
    }

    function order_invoice($order_id){
        $order = '#'.$order_id;
        $site_info = SiteinfoTab::find(1)->first();

        $pdf = FacadePdf::loadView('invoice.inv_pdf', [
            'order_id' => $order,
            'site_info' => $site_info,
        ]);
    
        return $pdf->stream('invoice.pdf');
    }



    // === Cust_Profile Update ===
    function cust_profile_update(Request $request){
        $cust_info = CustInfo::find($request->cust_id);
        $cust_name = $cust_info->name;
        $cust_email = $cust_info->email;

        // Update Name-Email ===
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9 ]+$/u|min:3'
        ]);
        if($request->email != $cust_email){
            $request->validate([
                'email' => 'required|email:rfc|unique:cust_infos,email'
            ]);
        }
        CustInfo::find(Auth::guard('CustLogin')->id())->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update Password ===
        if($request->old_password){
            if (Hash::check($request->old_password, Auth::guard('CustLogin')->user()->password)){
                $request->validate([
                    'password'=> ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
                    'password_confirmation'=> 'required',
                ]);

                CustInfo::find(Auth::guard('CustLogin')->id())->update([
                    'password' => bcrypt($request->password),
                ]);
            }
            else {
                return back()->with([
                    'wrong_old_pass' => 'Password does not Match!',
                ]);
            }
        }

        // Update Additional Info ===
        if($request->address){
            CustInfo::find(Auth::guard('CustLogin')->id())->update([
                'address' => $request->address,
            ]);
        }
        if($request->country){
            CustInfo::find(Auth::guard('CustLogin')->id())->update([
                'country' => $request->country,
            ]);
        }
        if($request->city){
            CustInfo::find(Auth::guard('CustLogin')->id())->update([
                'city' => $request->city,
            ]);
        }
        if($request->code){
            CustInfo::find(Auth::guard('CustLogin')->id())->update([
                'code' => $request->code,
            ]);
        }
        if($request->mobile){
            CustInfo::find(Auth::guard('CustLogin')->id())->update([
                'mobile' => $request->mobile,
            ]);
        }

        // Update Image ===
        if($request->prof_pic){
            $request->validate([
                'prof_pic' => 'mimes:png,jpg|max:1024',
            ]);

            if($cust_info->prof_pic){
                $del_old_image = public_path('uploads/customer/'.$cust_info->prof_pic);
                unlink($del_old_image);
            }
    
            $upl_file = $request->prof_pic;
            $ext = $upl_file->getClientOriginalExtension();
            $file_name = Auth::guard('CustLogin')->id().'.'.$ext;
            Image::make($upl_file)->resize(200, 200)->save(public_path('uploads/customer/'. $file_name));

            CustInfo::find(Auth::guard('CustLogin')->id())->update([
                'prof_pic' => $file_name,
            ]);
        }
        
        return back()->with([
            'cust_prof_upd' => 'Profile updated Successfully!',
        ]);
    }
}
