<?php

namespace App\Http\Controllers;

use App\Models\OrderTab;
use Illuminate\Http\Request;

class OrderCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function order_list(){
        $order_all = OrderTab::orderByDesc('id')->get();

        return view('admin.order.order_list', [
            'order_all' => $order_all,
        ]);
    }

    function order_status_update(Request $request){
        $order_id = $request->order_id;

        OrderTab::where('order_id', $order_id)->update([
            'order_status' => $request->status,
        ]);
        return back();
    }
}
