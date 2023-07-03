<?php

namespace App\Http\Controllers;

use App\Mail\OrderCancelled;
use App\Mail\OrderConfirmed as MailOrderConfirmed;
use App\Models\BillingTab;
use App\Models\CustInfo;
use App\Models\OrdereditemsTab;
use App\Models\OrderTab;
use App\Models\User;
use App\Notifications\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function order_list(){
        $order_all = OrderTab::orderByDesc('id')->get();
        $order_count = OrderTab::all()->count();

        return view('admin.order.order_list', [
            'order_all' => $order_all,
            'order_count' => $order_count,
        ]);
    }

    function order_status_update(Request $request){
        $order_id = $request->order_id;
        $billing_info = BillingTab::where('order_id', $order_id)->first();
        $billing_email = $billing_info->email;
        $cust_id = BillingTab::where('order_id', $order_id)->first()->customer_id;
        $cust_email = CustInfo::find($cust_id)->email;

        OrderTab::where('order_id', $order_id)->update([
            'order_status' => $request->status,
        ]);

        if($request->status == 2){
            if($billing_email == $cust_email){
                Mail::to($billing_email)->send(new MailOrderConfirmed($billing_info));
            }
            else {
                Mail::to($billing_email)
                ->cc($cust_email)
                ->send(new MailOrderConfirmed($billing_info));
            }
        }

        if($request->status == 6){
            if($billing_email == $cust_email){
                Mail::to($billing_email)->send(new OrderCancelled($billing_info));
            }
            else {
                Mail::to($billing_email)
                ->cc($cust_email)
                ->send(new OrderCancelled($billing_info));
            }

            // === Subtract Inventory ===
            // Inventory::where('product_id', $cart->product_id)->where('color', $cart->color_id)->where('size', $cart->size_id)->decrement('quantity', $cart->quantity);
        }

        return back()->with([
            'job_upd' => 'Order-Status Updated!'
        ]);
    }

    // function user_order_pulse(Request $request){
    //     $user = User::find(Auth::id());
    //     if($user->order_chk == 1){
    //         $user->update([
    //             'order_chk' => 0,
    //         ]);
    //     }
    // }

    function order_info($order_id){
        $order_tab = OrderTab::find($order_id);
        $order_id = $order_tab->order_id;
        $ordered_items = OrdereditemsTab::where('order_id', $order_id)->get();
        $billing_tab = BillingTab::where('order_id', $order_id)->get();

        return view('admin.order.order', [
            'order_id' => $order_id,
            'order_tab' => $order_tab,
            'ordered_items' => $ordered_items,
            'billing_tab' => $billing_tab,
        ]);
    }
}
