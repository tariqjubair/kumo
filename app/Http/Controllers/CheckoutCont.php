<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\cartMod;
use App\Models\Country;
use App\Models\OrderTab;
use App\Mail\InvoiceMail;
use App\Models\Inventory;
use App\Models\BillingTab;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrdereditemsTab;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutCont extends Controller
{
    // Checkout Page ===
    function checkout(){
        if(!Auth::guard('CustLogin')->check()){
            return redirect()->route('customer_login')->with('cart_login', 'Please Login/Register to use Cart/Checkout');
        }

        $cart_info = cartMod::where('customer_id', Auth::guard('CustLogin')->id())->get();
        $countries = Country::all();
        $cities = City::all();

        return view('frontend.checkout', [
            'cart_info' => $cart_info,
            'countries' => $countries,
            'cities' => $cities,
        ]);
    }

    // Ajax: Get City ===
    function get_city(Request $request){
        $sel_city = City::where('country_id', $request->country_id)->get();

        $str = '<option value="">-- Select City --</option>';
        foreach ($sel_city as $city){
            $str .= "<option value='$city->id'>$city->name</option>";
        }
        echo $str;
    }

    // Ajax: Get Code ===
    function get_code(Request $request){
        $sel_code = Country::find($request->country_id)->phonecode;
        $str = "<option value='$sel_code'>$sel_code</option>";
        echo $str;
    }

    // Insert: Billing ===
    function billing_details(Request $request){
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required',
            'mobile' => 'required',
            'code' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',

            'delivery_charge' => 'required',
            'payment_method' => 'required',
        ], [
            'code' => 'Code Blank!'
        ]);

        $name = $request->name;
        $gtotal = $request->ftotal + $request->delivery_charge;
        $mobile = $request->code.$request->mobile;

        $city = City::find($request->city)->name;
        $city_sp = Str::upper(substr("$city", 0, 3));
        $order_id = '#'.$city_sp.'-'.random_int(100000, 999999);

        session([
            'order_info' => $request->all(),
            'name' => $name,
            'gtotal' => $gtotal,
            'mobile' => $mobile,
            'order_id' => $order_id,
        ]);
        

        // === Payment Gateway ===
        if($request->payment_method == 2){
            return redirect()->route('ssl.pay');
        }
        elseif($request->payment_method == 3){
            return redirect()->route('stripe');
        }

        return redirect()->route('order.complete')->with([
            'order_conf' => $order_id,
        ]);
    }

    // === Order Complete ===
    function order_complete(){
        if(!session('order_info')){
            return redirect()->route('home_page');
        }
        else {
            $order_info = session('order_info');
            $name = session('name');
            $gtotal = session('gtotal');
            $mobile = session('mobile');
            $order_id = session('order_id');
            
            $cart_info = cartMod::where('customer_id', Auth::guard('CustLogin')->id())->get();


            // === Order Table ===
            OrderTab::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('CustLogin')->id(),
                'total' => $order_info['subtotal'],
                'discount' => $order_info['discount'],
                'charge' => $order_info['delivery_charge'],
                'gtotal' => $gtotal,
                'payment_method' => $order_info['payment_method'],
                'created_at' => Carbon::now(),
            ]);

            // === Billing Table ===
            BillingTab::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('CustLogin')->id(),
                'name' => $order_info['name'],
                'email' => $order_info['email'],
                'company' => $order_info['company'],
                'mobile' => $mobile,
                'address' => $order_info['address'],
                'country' => $order_info['country'],
                'city' => $order_info['city'],
                'zip' => $order_info['zip'],
                'note' => $order_info['note'],
                'created_at' => Carbon::now(),
            ]);

            // === Ordered Items Table ===
            foreach($cart_info as $cart){
                OrdereditemsTab::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('CustLogin')->id(),
                    'product_id' => $cart->product_id,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->relto_product->after_disc,
                ]);

                // === Subtract Inventory ===
                // Inventory::where('product_id', $cart->product_id)->where('color', $cart->color_id)->where('size', $cart->size_id)->decrement('quantity', $cart->quantity);
            }

            // === Delete Cart ===
            // cartMod::where('customer_id', Auth::guard('CustLogin')->id())->delete();

            // === Order Invoice View (Temp) ===
            Session([
                'order_id_inv' => $order_id,
            ]);
            
            // === Send Mail ===
            Mail::to($order_info['email'])->send(new InvoiceMail($order_id));

            // === SMS API ===
            // $url = "http://bulksmsbd.net/api/smsapi";
            // $api_key = "yKJN2zqa39nfLpEMRFV2";
            // $senderid = "8809612443872";
            // $number = "$mobile";
            // $message = "Dear ".$name.", Your Order ".$order_id." is Placed. Total Bill: ".$gtotal." Tk. Thanks for Shopping with Kumo E-store.";
            
            // $data = [
            //     "api_key" => $api_key,
            //     "senderid" => $senderid,
            //     "number" => $number,
            //     "message" => $message
            // ];
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // return $response;

            // === Delete Order Session ===
            session::pull('order_info');
            session::pull('name');
            session::pull('gtotal');
            session::pull('mobile');
            session::pull('order_id');
            session::pull('order_id_inv');

            return view('frontend.order_complete');
        }
    }

    // === Order Failed ===
    function order_failed(){
        return view('frontend.order_failed');
    }
}
