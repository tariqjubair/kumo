<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('admin.dashboard.home');
    }

    function custom_report(){
        $order_all = [];
        $order_count = '';
        $all_cust = [];
        $sold_products = [];
        return view('admin.dashboard.custom_report', [
            'order_all' => $order_all,
            'order_count' => $order_count,
            'all_cust' => $all_cust,
            'sold_products' => $sold_products,
        ]);
    }

    function target_setting(){
        return view('admin.dashboard.target_setting');
    }
}
