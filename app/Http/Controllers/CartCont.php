<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\cartMod;
use App\Models\Subcategory;
use App\Models\WishTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CartCont extends Controller
{
    // === Add Cart ===
    function add_cart(Request $request){
        if(Auth::guard('CustLogin')->check()){
            $request->validate([
                'prod_color' => 'required',
                'prod_size' => 'required',
                'quantity' => 'required',
            ], [
                'prod_color' => 'Please Select One Color!',
                'prod_size' => 'Please Select One Available Size!!',
                'quantity' => 'This Size currently Out of Stock!',
            ]);

            $dupli_cart = cartMod::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->prod_color)->where('size_id', $request->prod_size);


            if($dupli_cart->exists()){
                $dupli_cart->increment('quantity', $request->quantity);
                return back()->with('cart_added', 'Item(s) Added to Cart!');
            }
            else {
                cartMod::insert([
                    'customer_id' => Auth::guard('CustLogin')->id(),
                    'product_id' => $request->product_id,
                    'color_id' => $request->prod_color,
                    'size_id' => $request->prod_size,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now(),
                ]);
                return back()->with('cart_added', 'Item(s) Added to Cart!');
            }
        }
        else {
            return redirect()->route('customer_login')->with('cart_login', 'Please Login/Register to use Cart');
        }
    }

    // === Remove Cart [Master] ===
    function remove_cart($card_id){
        cartMod::find($card_id)->delete();
        return back()->with('cart_removed', 'Item Removed from Cart');
    }

    // === Remove All Cart ===
    function remove_all_cart(){
        cartMod::where('customer_id', Auth::guard('CustLogin')->id())->delete();
        return back()->with('cart_removed', 'All items Removed from Cart');
    }

    // === Add Wishlist ===
    function add_wishlist(Request $request){
        if(Auth::guard('CustLogin')->check()){
            $dupli_cart = WishTable::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->prod_color)->where('size_id', $request->prod_size);

            if($dupli_cart->exists()){
                $dupli_cart->increment('quantity', $request->quantity);
                return back()->with('wish_added', 'Item(s) Added to Wishlist!');
            }
            else {
                WishTable::insert([
                    'customer_id' => Auth::guard('CustLogin')->id(),
                    'product_id' => $request->product_id,
                    'color_id' => $request->prod_color,
                    'size_id' => $request->prod_size,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now(),
                ]);
                return back()->with('wish_added', 'Item(s) Added to Wishlist!');
            }
        }
        else {
            return redirect()->route('customer_login')->with('cart_login', 'Please Login/Register to use Cart');
        }
    }

    // === Remove Wishlist ===
    function remove_wishlist($wish_id){
        WishTable::find($wish_id)->delete();
        return back()->with('wish_removed', 'Item Removed from Wishlist!');
    }

    // === Remove Btn_Wishlist ===
    function remove_btn_wishlist($product_id){
        $test = WishTable::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $product_id)->delete();
        return back()->with('wish_removed', 'Item(s) Removed from Wishlist!');
    }

    // === Remove All Wishlist ===
    function remove_all_wishlist(){
        WishTable::where('customer_id', Auth::guard('CustLogin')->id())->delete();
        return back()->with('wish_removed', 'Item(s) Removed from Wishlist!');
    }

    // === Cart Page ===
    function cart_store_update(Request $request){
        if(Auth::guard('CustLogin')->check()){
            $cart_info = cartMod::where('customer_id', Auth::guard('CustLogin')->id())->get();

            $coupon_info = Coupon::where('coupon_name', $request->coupon)->get()->first();
            $coupon = null;
            $discount = null;
            $min_total = null;
            $least_disc = null;
            $most_disc = null;
            $btn = $request->coupon_btn;


            if($request->coupon != null){
                if(Coupon::where('coupon_name', $request->coupon)->exists()){
                    if($coupon_info->validity > carbon::now()->isoFormat('YYYY-MM-DD')){
                        if($coupon_info->min_total != null){
                            $min_total = $coupon_info->min_total;
                        }
                        if($coupon_info->least_disc != null){
                            $least_disc = $coupon_info->least_disc;
                        }
                        if($coupon_info->most_disc != null){
                            $most_disc = $coupon_info->most_disc;
                        }

                        if($request->total >= $min_total){

                            // === Percent-Off ===
                            if($coupon_info->type == 1){
                                
                                $discount = $request->total * ($coupon_info->discount/100);
                                $coupon = 'Discount: '.$coupon_info->discount.'% ('.$least_disc.' - '.$most_disc.' Tk.)';
                                
                                if($discount > $most_disc){
                                    $discount = $most_disc;
                                }
                                else if($discount < $least_disc){
                                    $discount = $least_disc;
                                }
                            }

                            // === Solid ===
                            else if($coupon_info->type == 2){
                                $coupon = 'Coupon Applied: '.$coupon_info->discount.' Tk.';
                                $discount = $coupon_info->discount;
                            }

                            // === Category ===
                            else if($coupon_info->type == 10){
                                $sub_list = explode(",", $coupon_info->subcata);
                                $coupon = 'Invalid Cart Item';

                                foreach ($sub_list as $sub){
                                    foreach ($cart_info as $cart){
                                        if($cart->relto_product->subcata_id == $sub){
                                            $discount += $cart->relto_product->after_disc * ($coupon_info->discount/100) * $cart->quantity;
                                            $coupon = 'Discount: '.$coupon_info->discount.'% ('.$least_disc.' - '.$most_disc.' Tk.)';
                                            
                                            if($most_disc != null && $discount > $most_disc){
                                                $discount = $most_disc;
                                            }
                                            else if($least_disc != null && $discount < $least_disc){
                                                $discount = $least_disc;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            $discount = 0;
                            $coupon = 'Purchase minimum'. $min_total;
                        }
                    }
                    else{
                        $discount = 0;
                        $coupon = 'Coupon Validity Expired!';
                    }
                }
                else{
                    $discount = 0;
                    $coupon = 'Invalid Coupon!';
                }
            }
            else{
                $discount = 0;
                $coupon = 'No Coupon Applied!';
            }

            return view('frontend.cart', [
                'cart_info' => $cart_info,
                'coupon' => $coupon,
                'discount' => $discount,
                'btn' => $btn,
            ]);
        }
        else {
            return redirect()->route('customer_login');
        }
    }

    // === Cart Updated New===
    function cart_updated(Request $request){
        foreach($request->qty_new as $cart_id=>$qty_new){

            cartMod::find($cart_id)->update([
                'quantity' => $qty_new,
            ]);
        }
        return back()->with('cart_upd', 'Cart Updated Successfully!');
    }

    // === Remove Cart from Cart-Page ===
    function remove_cart_page($card_id){
        cartMod::find($card_id)->delete();
        return back()->with('cart_page_removed', 'Item Removed from Cart');
    }




}
