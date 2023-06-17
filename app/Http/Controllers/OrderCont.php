<?php

namespace App\Http\Controllers;

use App\Models\BillingTab;
use App\Models\OrdereditemsTab;
use App\Models\OrderTab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        OrderTab::where('order_id', $order_id)->update([
            'order_status' => $request->status,
        ]);
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
