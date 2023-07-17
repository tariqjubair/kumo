<?php

namespace App\Http\Controllers;

use App\Models\DashTarget;
use App\Models\Inventory;
use App\Models\OrdereditemsTab;
use App\Models\OrderTab;
use App\Models\PromoCounter;
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
        $m12 = Carbon::today()->subMonth(12)->format('M-y');
        $m11 = Carbon::today()->subMonth(11)->format('M-y');
        $m10 = Carbon::today()->subMonth(10)->format('M-y');
        $m9 = Carbon::today()->subMonth(9)->format('M-y');
        $m8 = Carbon::today()->subMonth(8)->format('M-y');
        $m7 = Carbon::today()->subMonth(7)->format('M-y');
        $m6 = Carbon::today()->subMonth(6)->format('M-y');
        $m5 = Carbon::today()->subMonth(5)->format('M-y');
        $m4 = Carbon::today()->subMonth(4)->format('M-y');
        $m3 = Carbon::today()->subMonth(3)->format('M-y');
        $m2 = Carbon::today()->subMonth(2)->format('M-y');
        $m1 = Carbon::today()->subMonth(1)->format('M-y');

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
	
        // === Counter ===
        $order_unattended = OrderTab::where('order_status', 1)->count();
        $order_confirmed = OrderTab::where('order_status', '!=', 6)->count();
        $order_cancelled = OrderTab::where('order_status', 6)->count();
        $order_delivered = OrderTab::where('order_status', 5)->count();
        $order_over_week = OrderTab::where('created_at', '<', Carbon::today()->subDays(6))->whereBetween('order_status', [2, 4])->count();
        $order_over_month = OrderTab::where('created_at', '<', Carbon::today()->subMonth(1))->whereBetween('order_status', [2, 4])->count();
        $sales_total = OrderTab::where('order_status', '!=', 6)->sum('gtotal');
        $promo_mail = PromoCounter::all()->count();

        // === Today ===
        $today_orders = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->count();
        $today_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $today_delivery = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 5)->count();
        $today_order_processing = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 3)->count();
        $today_order_ready = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 4)->count();
        $today_order_cancelled = OrderTab::where('updated_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->where('order_status', 6)->count();
        $today_product_sold = OrdereditemsTab::where('created_at', 'like', '%' . Carbon::today()->format('Y-m-d') . '%')->get()->unique('product_id')->count();

        // === Monthly ===
        $monthly_orders = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->where('order_status', '!=', 6)->count();
        $monthly_sales = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->where('order_status', '!=', 6)
        ->sum('gtotal');
        $monthly_delivery = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->where('order_status', 5)->count();
        $monthly_order_cancelled = OrderTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->where('order_status', 6)->count();
        $monthly_promo_mail = PromoCounter::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->count();
        $monthly_product_sold = OrdereditemsTab::where('created_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->get()->unique('product_id')->count();
        $monthly_inv_upd = Inventory::where('updated_at', '>', Carbon::today()->subMonth(1)->endOfMonth())->count();
        $w1_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->startOfMonth(),
            Carbon::today()->startOfMonth()->addDay(6),
        ])->where('order_status', '!=', 6)->count();
        $w2_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->startOfMonth()->addDay(7),
            Carbon::today()->startOfMonth()->addDay(13),
        ])->where('order_status', '!=', 6)->count();
        $w3_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->startOfMonth()->addDay(14),
            Carbon::today()->startOfMonth()->addDay(20),
        ])->where('order_status', '!=', 6)->count();
        $w4_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->startOfMonth()->addDay(21),
            Carbon::today()->startOfMonth()->addDay(27),
        ])->where('order_status', '!=', 6)->count();
        $w5_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->startOfMonth()->addDay(28),
            Carbon::today()->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $md1_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md2_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(1)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md3_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(2)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md4_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(3)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md5_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(4)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md6_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(5)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md7_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(6)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md8_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(7)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md9_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(8)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md10_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(9)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md11_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(10)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md12_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(11)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md13_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(12)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md14_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(13)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md15_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(14)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md16_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(15)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md17_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(16)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md18_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(17)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md19_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(18)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md20_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(19)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md21_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(20)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md22_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(21)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md23_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(22)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md24_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(23)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md25_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(24)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md26_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(25)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md27_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(26)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md28_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(27)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md29_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(28)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md30_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(29)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');
        $md31_sales = OrderTab::where('created_at', 'like', '%' . Carbon::today()->startOfMonth()->addDay(30)->format('Y-m-d') . '%')->where('order_status', '!=', 6)->sum('gtotal');

        // === Yearly ===
        $m12_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(12)->startOfMonth(),
            Carbon::today()->subMonth(12)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m11_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(11)->startOfMonth(),
            Carbon::today()->subMonth(11)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m10_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(10)->startOfMonth(),
            Carbon::today()->subMonth(10)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m9_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(9)->startOfMonth(),
            Carbon::today()->subMonth(9)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m8_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(8)->startOfMonth(),
            Carbon::today()->subMonth(8)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m7_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(7)->startOfMonth(),
            Carbon::today()->subMonth(7)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m6_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(6)->startOfMonth(),
            Carbon::today()->subMonth(6)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m5_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(5)->startOfMonth(),
            Carbon::today()->subMonth(5)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m4_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(4)->startOfMonth(),
            Carbon::today()->subMonth(4)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m3_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(3)->startOfMonth(),
            Carbon::today()->subMonth(3)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m2_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(2)->startOfMonth(),
            Carbon::today()->subMonth(2)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m1_order = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(1)->startOfMonth(),
            Carbon::today()->subMonth(1)->endOfMonth(),
        ])->where('order_status', '!=', 6)->count();
        $m12_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(12)->startOfMonth(),
            Carbon::today()->subMonth(12)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m11_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(11)->startOfMonth(),
            Carbon::today()->subMonth(11)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m10_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(10)->startOfMonth(),
            Carbon::today()->subMonth(10)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m9_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(9)->startOfMonth(),
            Carbon::today()->subMonth(9)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m8_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(8)->startOfMonth(),
            Carbon::today()->subMonth(8)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m7_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(7)->startOfMonth(),
            Carbon::today()->subMonth(7)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m6_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(6)->startOfMonth(),
            Carbon::today()->subMonth(6)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m5_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(5)->startOfMonth(),
            Carbon::today()->subMonth(5)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m4_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(4)->startOfMonth(),
            Carbon::today()->subMonth(4)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m3_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(3)->startOfMonth(),
            Carbon::today()->subMonth(3)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m2_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(2)->startOfMonth(),
            Carbon::today()->subMonth(2)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');
        $m1_sales = OrderTab::whereBetween('created_at', [
            Carbon::today()->subMonth(1)->startOfMonth(),
            Carbon::today()->subMonth(1)->endOfMonth(),
        ])->where('order_status', '!=', 6)->sum('gtotal');

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
            'm12' => $m12,
            'm11' => $m11,
            'm10' => $m10,
            'm9' => $m9,
            'm8' => $m8,
            'm7' => $m7,
            'm6' => $m6,
            'm5' => $m5,
            'm4' => $m4,
            'm3' => $m3,
            'm2' => $m2,
            'm1' => $m1,

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

            'order_unattended' => $order_unattended,
            'order_confirmed' => $order_confirmed,
            'order_cancelled' => $order_cancelled,
            'order_delivered' => $order_delivered,
            'order_over_week' => $order_over_week,
            'order_over_month' => $order_over_month,
            'sales_total' => $sales_total,
            'promo_mail' => $promo_mail,

            'today_orders' => $today_orders,
            'today_sales' => $today_sales,
            'today_delivery' => $today_delivery,
            'today_order_processing' => $today_order_processing,
            'today_order_ready' => $today_order_ready,
            'today_order_cancelled' => $today_order_cancelled,
            'today_product_sold' => $today_product_sold,

            'monthly_orders' => $monthly_orders,
            'monthly_sales' => $monthly_sales,
            'monthly_delivery' => $monthly_delivery,
            'monthly_order_cancelled' => $monthly_order_cancelled,
            'monthly_promo_mail' => $monthly_promo_mail,
            'monthly_product_sold' => $monthly_product_sold,
            'monthly_inv_upd' => $monthly_inv_upd,
            'w1_order' => $w1_order,
            'w2_order' => $w2_order,
            'w3_order' => $w3_order,
            'w4_order' => $w4_order,
            'w5_order' => $w5_order,
            'md1_sales' => $md1_sales,
            'md2_sales' => $md2_sales,
            'md3_sales' => $md3_sales,
            'md4_sales' => $md4_sales,
            'md5_sales' => $md5_sales,
            'md6_sales' => $md6_sales,
            'md7_sales' => $md7_sales,
            'md8_sales' => $md8_sales,
            'md9_sales' => $md9_sales,
            'md10_sales' => $md10_sales,
            'md11_sales' => $md11_sales,
            'md12_sales' => $md12_sales,
            'md13_sales' => $md13_sales,
            'md14_sales' => $md14_sales,
            'md15_sales' => $md15_sales,
            'md16_sales' => $md16_sales,
            'md17_sales' => $md17_sales,
            'md18_sales' => $md18_sales,
            'md19_sales' => $md19_sales,
            'md20_sales' => $md20_sales,
            'md21_sales' => $md21_sales,
            'md22_sales' => $md22_sales,
            'md23_sales' => $md23_sales,
            'md24_sales' => $md24_sales,
            'md25_sales' => $md25_sales,
            'md26_sales' => $md26_sales,
            'md27_sales' => $md27_sales,
            'md28_sales' => $md28_sales,
            'md29_sales' => $md29_sales,
            'md30_sales' => $md30_sales,
            'md31_sales' => $md31_sales,

            'm12_order'=> $m12_order,
            'm11_order'=> $m11_order,
            'm10_order'=> $m10_order,
            'm9_order'=> $m9_order,
            'm8_order'=> $m8_order,
            'm7_order'=> $m7_order,
            'm6_order'=> $m6_order,
            'm5_order'=> $m5_order,
            'm4_order'=> $m4_order,
            'm3_order'=> $m3_order,
            'm2_order'=> $m2_order,
            'm1_order'=> $m1_order,
            'm12_sales'=> $m12_sales,
            'm11_sales'=> $m11_sales,
            'm10_sales'=> $m10_sales,
            'm9_sales'=> $m9_sales,
            'm8_sales'=> $m8_sales,
            'm7_sales'=> $m7_sales,
            'm6_sales'=> $m6_sales,
            'm5_sales'=> $m5_sales,
            'm4_sales'=> $m4_sales,
            'm3_sales'=> $m3_sales,
            'm2_sales'=> $m2_sales,
            'm1_sales'=> $m1_sales,
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
