<?php

namespace App\Http\Controllers;

use App\Models\DashTarget;
use App\Models\Inventory;
use App\Models\OrdereditemsTab;
use App\Models\OrderTab;
use Carbon\Carbon;
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
        // === Common ===
        $daily_target = DashTarget::where('target', 'daily')->first();
        $weekly_target = DashTarget::where('target', 'weekly')->first();
        $monthly_target = DashTarget::where('target', 'monthly')->first();
        $d7 = Carbon::today()->subDays(6)->format('D');
        $d6 = Carbon::today()->subDays(5)->format('D');
        $d5 = Carbon::today()->subDays(4)->format('D');
        $d4 = Carbon::today()->subDays(3)->format('D');
        $d3 = Carbon::today()->subDays(2)->format('D');
        $d2 = Carbon::today()->subDays(1)->format('D');
        $d1 = Carbon::today()->format('D');

        // === Weekly ===
        $weekly_orders = OrderTab::where('created_at', '>=', Carbon::today()->subDays(6))->where('order_status', '!=', 6)->count();
        $weekly_sales = OrderTab::where('created_at', '>=', Carbon::today()->subDays(6))->where('order_status', '!=', 6)->sum('gtotal');
        $weekly_delivery = OrderTab::where('updated_at', '>=', Carbon::today()->subDays(6))->where('order_status', 5)->count();
        $d7_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(6)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d6_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(5)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d5_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(4)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d4_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(3)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d3_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(2)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d2_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(1)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d1_order = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $d7_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(6)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $d6_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(5)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $d5_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(4)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $d4_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(3)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $d3_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(2)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $d2_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->subDays(1)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $d1_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
	
        // === Today ===
        $today_orders = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $today_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $today_delivery = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 5)->count();
        $today_unattended = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 1)->count();
        $today_order_processing = OrderTab::where('order_status', 3)->count();
        $today_order_ready = OrderTab::where('order_status', 4)->count();
        $today_order_cancelled = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 6)->count();
        $today_product_sold = OrdereditemsTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->get()->unique('product_id')->count();
        $today_inv_upd = Inventory::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->count();

        // === Monthly ===
        $monthly_orders = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->count();
        $monthly_sales = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->sum('gtotal');
        $monthly_delivery = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->where('order_status', 5)->count();



        $monthly_order_placed = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->count();
        $monthly_order_processing = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 3)->count();
        $monthly_order_ready = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 4)->count();
        $monthly_order_cancelled = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 6)->count();
        $monthly_product_sold = OrdereditemsTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->get()->unique('product_id')->count();
        $monthly_inv_upd = Inventory::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->count();


        return view('admin.dashboard.home', [
            'daily_target' => $daily_target,
            'weekly_target' => $weekly_target,
            'monthly_target' => $monthly_target,
            'd7' => $d7,
            'd6' => $d6,
            'd5' => $d5,
            'd4' => $d4,
            'd3' => $d3,
            'd2' => $d2,
            'd1' => $d1,

            'weekly_orders' => $weekly_orders,
            'weekly_sales' => $weekly_sales,
            'weekly_delivery' => $weekly_delivery,
            'd7_order' => $d7_order,
            'd6_order' => $d6_order,
            'd5_order' => $d5_order,
            'd4_order' => $d4_order,
            'd3_order' => $d3_order,
            'd2_order' => $d2_order,
            'd1_order' => $d1_order,
            'd7_sales' => $d7_sales,
            'd6_sales' => $d6_sales,
            'd5_sales' => $d5_sales,
            'd4_sales' => $d4_sales,
            'd3_sales' => $d3_sales,
            'd2_sales' => $d2_sales,
            'd1_sales' => $d1_sales,

            'today_orders' => $today_orders,
            'today_sales' => $today_sales,
            'today_delivery' => $today_delivery,
            'today_unattended' => $today_unattended,
            'today_order_processing' => $today_order_processing,
            'today_order_ready' => $today_order_ready,
            'today_order_cancelled' => $today_order_cancelled,
            'today_product_sold' => $today_product_sold,
            'today_inv_upd' => $today_inv_upd,
        ]);
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
        $daily_target = DashTarget::where('target', 'daily')->first();
        $weekly_target = DashTarget::where('target', 'weekly')->first();
        $monthly_target = DashTarget::where('target', 'monthly')->first();
        return view('admin.dashboard.target_setting', [
            'daily_target' => $daily_target,
            'weekly_target' => $weekly_target,
            'monthly_target' => $monthly_target,
        ]);
    }




    function daily_target_update(Request $request){
        DashTarget::where('target', 'daily')->update([
            'order' => $request->daily_order,
            'sales' => str_replace(",","", $request->daily_sales),
            'visitor' => $request->daily_visitor,
            'delivery' => $request->daily_delivery,
        ]);
        return back()->with('job_upd', 'Daily Targets Updated!');
    }

    function weekly_target_update(Request $request){
        DashTarget::where('target', 'weekly')->update([
            'order' => $request->weekly_order,
            'sales' => str_replace(",","", $request->weekly_sales),
            'visitor' => $request->weekly_visitor,
            'delivery' => $request->weekly_delivery,
        ]);
        return back()->with('job_upd', 'Weekly Targets Updated!');
    }

    function monthly_target_update(Request $request){
        DashTarget::where('target', 'monthly')->update([
            'order' => $request->monthly_order,
            'sales' => str_replace(",","", $request->monthly_sales),
            'visitor' => $request->monthly_visitor,
            'delivery' => $request->monthly_delivery,
        ]);
        return back()->with('job_upd', 'Monthly Targets Updated!');
    }
}
