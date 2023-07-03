<?php

namespace App\Http\Controllers;

use App\Models\CustInfo;
use App\Models\OrderTab;
use Illuminate\Http\Request;

class BackendCust extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function cust_list(){
        $all_cust = CustInfo::orderBy('name')->get();

        return view ('admin.customer.cust_list', [
            'all_cust' => $all_cust,
        ]);
    }

    function customer_block($cust_id){
        CustInfo::find($cust_id)->update([
            'status' => 0,
        ]);
        return back()->with('del', 'Customer Blocked!');
    }

    function customer_unblock($cust_id){
        CustInfo::find($cust_id)->update([
            'status' => 1,
        ]);
        return back()->with('job_upd', 'Customer Unblocked!');
    }

    function customer_orders($cust_id){
        $cust_name = CustInfo::find($cust_id)->name;
        $cust_order = OrderTab::where('customer_id', $cust_id)->orderBy('id', 'DESC')->get();

        return view ('admin.customer.backend_cust_order', [
            'cust_id' => $cust_id,
            'cust_name' => $cust_name,
            'cust_order' => $cust_order,
        ]);
    }
}
