@extends('layouts.dashboard')

@section('header_style')
<style>
    .item {
        color: #555555
    }
</style>
@endsection

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Sales Report: Last 7 Days</a></li>
    </ol>
</div>

{{-- === Weekly Target === --}}
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-success mr-md-4 mr-3">
                        <i class="fad fa-box-check text-success" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Orders in 7 Days</p>
                        <span class="title text-black font-w600">{{$weekly_orders}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-success" style="width: {{$weekly_target->order ?$weekly_orders/$weekly_target->order * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-success"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-secondary  mr-md-4 mr-3">
                        <i class="fad fa-envelope-open-dollar text-secondary" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Sales in 7 Days</p>
                        <span class="title text-black font-w600">{{number_format($weekly_sales)}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-secondary" style="width: {{$weekly_target->sales ?$weekly_sales/$weekly_target->sales * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-secondary"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-danger mr-md-4 mr-3">
                        <i class="fas fa-user-friends text-danger" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Visitors in 7 Days</p>
                        <span class="title text-black font-w600">250</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-danger" style="width: 90%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-danger"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-primary  mr-md-4 mr-3">
                        <i class="fad fa-truck-container text-primary" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Delivery in 7 Days</p>
                        <span class="title text-black font-w600">{{$weekly_delivery}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-primary" style="width: {{$weekly_target->delivery ?$weekly_delivery/$weekly_target->delivery * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-primary"></div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-sm-12 col-xl-8">
        <div>
            <canvas id="weekly_sales"></canvas>
        </div>
        <div class="item text-center mt-4">
            <span class="text-danger">Sales in 7 Days</span>
        </div>
    </div>
    <div class="col-8 m-auto pt-3 col-sm-8 m-sm-auto pt-sm-5 col-xl-4 pt-xl-0">
        <div>
            <canvas id="weekly_orders"></canvas>
        </div>
        <div class="item text-center mt-4">
            <span class="text-danger">Orders in 7 Days</span>
        </div>
    </div>
</div>

{{-- === Order Counter === --}}
<div class="page-titles mt-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order Counter: All-Time</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-info">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="fad fa-exclamation-triangle"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Unattended Orders</p>
                        <h3 class="text-white">{{$order_unattended}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-success">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="fad fa-box-check"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Orders Received</p>
                        <h3 class="text-white">{{$order_confirmed}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-danger">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="fad fa-times-square"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Orders Cancelled</p>
                        <h3 class="text-white">{{$order_cancelled}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-primary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="fad fa-truck-container"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Orders Delivered</p>
                        <h3 class="text-white">{{$order_delivered}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-warning">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="fad fa-box-open"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Orders Over a Week</p>
                        <h3 class="text-white">{{$order_over_week}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: #FF2400">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-truck-loading"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Not Delivered in Month</p>
                        <h3 class="text-white">{{$order_over_month}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-secondary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="fad fa-envelope-open-dollar"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Total Sales</p>
                        <h3 class="text-white">{{number_format((float)$sales_total/100000, 1, '.', '')}} Lac</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: #36454F">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-newspaper"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Newsletter Sent</p>
                        <h3 class="text-white">{{$promo_mail}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- === Today's Order === --}}
<div class="page-titles mt-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order Summary: Today ({{Carbon\carbon::now()->format('d-M-y')}})</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-success mr-md-4 mr-3">
                        <i class="fad fa-box-check text-success" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Today's Orders</p>
                        <span class="title text-black font-w600">{{$today_orders}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-success" style="width: {{$daily_target->order ?$today_orders/$daily_target->order * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-success"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-secondary  mr-md-4 mr-3">
                        <i class="fad fa-envelope-open-dollar text-secondary" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Today's Sales</p>
                        <span class="title text-black font-w600">{{number_format($today_sales)}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-secondary" style="width: {{$daily_target->sales ?$today_sales/$daily_target->sales * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-secondary"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-danger mr-md-4 mr-3">
                        <i class="fas fa-user-friends text-danger" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Today's Visitors</p>
                        <span class="title text-black font-w600">250</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-danger" style="width: 90%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-danger"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-primary  mr-md-4 mr-3">
                        <i class="fad fa-truck-container text-primary" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Today's Delivery</p>
                        <span class="title text-black font-w600">{{$today_delivery}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-primary" style="width: {{$daily_target->delivery ?$today_delivery/$daily_target->delivery * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-primary"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-warning">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="far fa-user-cog"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Order Processing</p>
                        <h3 class="text-white">{{$today_order_processing}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: #008000">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-conveyor-belt-alt"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Order Ready</p>
                        <h3 class="text-white">{{$today_order_ready}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: rgb(179, 15, 28)">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-window-close"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Order Cancelled</p>
                        <h3 class="text-white">{{$today_order_cancelled}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: #800080">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fas fa-bags-shopping"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Products Sold</p>
                        <h3 class="text-white">{{$today_product_sold}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- === Monthly Orders === --}}
<div class="page-titles mt-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Monthly Progress:
                ({{Carbon\carbon::now()->format('M-y')}})</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-success mr-md-4 mr-3">
                        <i class="fad fa-box-check text-success" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Orders in {{Carbon\carbon::today()->format('M')}}</p>
                        <span class="title text-black font-w600">{{$monthly_orders}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-success" style="width: {{$monthly_target->order ?$monthly_orders/$monthly_target->order * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-success"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-secondary  mr-md-4 mr-3">
                        <i class="fad fa-envelope-open-dollar text-secondary" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Sales in {{Carbon\carbon::today()->format('M')}}</p>
                        <span class="title text-black font-w600">{{number_format($monthly_sales)}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-secondary" style="width: {{$monthly_target->sales ?$monthly_sales/$monthly_target->sales * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-secondary"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-danger mr-md-4 mr-3">
                        <i class="fas fa-user-friends text-danger" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Visitors in {{Carbon\carbon::today()->format('M')}}</p>
                        <span class="title text-black font-w600">250</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-danger" style="width: 90%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-danger"></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card avtivity-card">
            <div class="card-body">
                <div class="media align-items-center">
                    <span class="activity-icon bgl-primary  mr-md-4 mr-3">
                        <i class="fad fa-truck-container text-primary" style="font-size: 35px; line-height: 80px"></i>
                    </span>
                    <div class="media-body">
                        <p class="fs-14 mb-2">Delivery in {{Carbon\carbon::today()->format('M')}}</p>
                        <span class="title text-black font-w600">{{$monthly_delivery}}</span>
                    </div>
                </div>
                <div class="progress" style="height:5px;">
                    <div class="progress-bar bg-primary" style="width: {{$monthly_target->delivery ?$monthly_delivery/$monthly_target->delivery * 100 :0}}%; height:5px;" role="progressbar">
                        <span class="sr-only">42% Complete</span>
                    </div>
                </div>
            </div>
            <div class="effect bg-primary"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: rgb(179, 15, 28)">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-window-close"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Order Cancelled in {{Carbon\carbon::now()->format('M')}}</p>
                        <h3 class="text-white">{{$monthly_order_cancelled}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: #36454F">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-newspaper"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Newsletter Sent in {{Carbon\carbon::now()->format('M')}}</p>
                        <h3 class="text-white">{{$monthly_promo_mail}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: #800080">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fas fa-bags-shopping"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Products Sold in {{Carbon\carbon::now()->format('M')}}</p>
                        <h3 class="text-white">{{$monthly_product_sold}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card" style="background: rgb(255, 108, 10)">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                        <i class="fad fa-inventory"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Inventory Updated in {{Carbon\carbon::now()->format('M')}}</p>
                        <h3 class="text-white">{{$monthly_inv_upd}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-sm-12 col-xl-8">
        <div>
            <canvas id="week_sale_diff"></canvas>
        </div>
        <div class="item text-center mt-4">
            <span class="text-danger">Weekly Sales in Current Month ({{Carbon\carbon::now()->format('M-y')}})</span>
        </div>
    </div>
    <div class="col-8 m-auto pt-3 col-sm-8 m-sm-auto pt-sm-5 col-xl-4 pt-xl-0">
        <div>
            <canvas id="week_sale_total"></canvas>
        </div>
        <div class="item text-center mt-4">
            <span class="text-danger">Weekly Orders in Current Month ({{Carbon\carbon::now()->format('M-y')}})</span>
        </div>
    </div>
</div>

{{-- === Yearly Orders Chart === --}}
<div class="page-titles mt-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Yearly Breakdown: from Last Month ({{Carbon\carbon::now()->submonth(1)->format('M-y')}})</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-sm-12 col-xl-8">
        <div>
            <canvas id="yearly_sales"></canvas>
        </div>
        <div class="item text-center mt-4">
            <span class="text-danger">Monthly Sales: Up to Last Month</span>
        </div>
    </div>
    <div class="col-8 m-auto pt-3 col-sm-8 m-sm-auto pt-sm-5 col-xl-4 pt-xl-0">
        <div>
            <canvas id="yearly_orders"></canvas>
        </div>
        <div class="item text-center mt-4">
            <span class="text-danger">Monthly Orders: Up to Last Month</span>
        </div>
    </div>
</div>
@endsection



@section('footer_script')

{{-- === Weekly Sales === --}}
<script>
    const weekly_sales = document.getElementById('weekly_sales');
    new Chart(weekly_sales, {
        type: 'bar',
        data: {
            labels: ['{{$d7}}', '{{$d6}}', '{{$d5}}', '{{$d4}}', '{{$d3}}', '{{$d2}}', 'Today'],
            datasets: [
                {
                    label: 'Sales',
                    data: [{{$d7_sales}}, {{$d6_sales}}, {{$d5_sales}}, {{$d4_sales}}, {{$d3_sales}}, {{$d2_sales}}, {{$d1_sales}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(3, 3, 231, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgba(3, 3, 231)',
                        'rgb(153, 102, 255)',
                    ],
                    borderWidth: 1
                },
            ]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });
</script>

{{-- === Weekly Orders === --}}
<script>
    const weekly_orders = document.getElementById('weekly_orders');
    new Chart(weekly_orders, {
        type: 'doughnut',
        data: {
            labels: ['{{$d7}}', '{{$d6}}', '{{$d5}}', '{{$d4}}', '{{$d3}}', '{{$d2}}', 'Today'],
            datasets: [
                {
                    label: 'Orders',
                    data: [{{$d7_order}}, {{$d6_order}}, {{$d5_order}}, {{$d4_order}}, {{$d3_order}}, {{$d2_order}}, {{$d1_order}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(3, 3, 231, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

{{-- === Monthly Sales === --}}
<script>
    const week_sale_diff = document.getElementById('week_sale_diff');
    new Chart(week_sale_diff, {
        type: 'line',
        data: {
            labels: ['Weekday 1', 'Weekday 2', 'Weekday 3', 'Weekday 4', 'Weekday 5', 'Weekday 6', 'Weekday 7'
            ],
            datasets: [
                {
                    label: 'Week 01',
                    data: [{{$md1_sales}}, {{$md2_sales}}, {{$md3_sales}}, {{$md4_sales}}, {{$md5_sales}}, {{$md6_sales}}, {{$md7_sales}}],
                    borderColor: [
                        'rgba(255, 99, 132, 0.8)',
                    ],
                    borderWidth: 3,
                    tension: 0.3,
                },
                {
                    label: 'Week 02',
                    data: [{{$md8_sales}}, {{$md9_sales}}, {{$md10_sales}}, {{$md11_sales}}, {{$md12_sales}}, {{$md13_sales}}, {{$md14_sales}}],
                    borderColor: [
                        'rgba(255, 159, 64, 0.8)',
                    ],
                    borderWidth: 3,
                    tension: 0.3,
                },
                {
                    label: 'Week 03',
                    data: [{{$md15_sales}}, {{$md16_sales}}, {{$md17_sales}}, {{$md18_sales}}, {{$md19_sales}}, {{$md20_sales}}, {{$md21_sales}}],
                    borderColor: [
                        'rgba(255, 205, 86, 0.8)',
                    ],
                    borderWidth: 3,
                    tension: 0.3,
                },
                {
                    label: 'Week 04',
                    data: [{{$md22_sales}}, {{$md23_sales}}, {{$md24_sales}}, {{$md25_sales}}, {{$md26_sales}}, {{$md27_sales}}, {{$md28_sales}}],
                    borderColor: [
                        'rgba(75, 192, 192, 0.8)',
                    ],
                    borderWidth: 3,
                    tension: 0.3,
                },
                {
                    label: 'Week 05',
                    data: [{{$md29_sales}}, {{$md30_sales}}, {{$md31_sales}}, 0, 0, 0, 0],
                    borderColor: [
                        'rgba(54, 162, 235, 0.8)',
                    ],
                    borderWidth: 3,
                    tension: 0.3,
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

{{-- === Monthly Orders === --}}
<script>
    const week_sale_total = document.getElementById('week_sale_total');
    new Chart(week_sale_total, {
        type: 'pie',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
            datasets: [
                {
                    label: 'Orders',
                    data: [{{$w1_order}}, {{$w2_order}}, {{$w3_order}}, {{$w4_order}}, {{$w5_order}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                    ],
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

{{-- === Yearly Sales === --}}
<script>
    const yearly_sales = document.getElementById('yearly_sales');
    new Chart(yearly_sales, {
        type: 'bar',
        data: {
            labels: ['{{$m12}}', '{{$m11}}', '{{$m10}}', '{{$m9}}', '{{$m8}}', '{{$m7}}', '{{$m6}}', '{{$m5}}', '{{$m4}}', '{{$m3}}',
                '{{$m2}}', '{{$m1}}'],
            datasets: [
                {
                    label: 'Sales:',
                    data: [{{$m12_sales}}, {{$m11_sales}}, {{$m10_sales}}, {{$m9_sales}}, {{$m8_sales}}, {{$m7_sales}}, {{$m6_sales}}, {{$m5_sales}}, {{$m4_sales}}, {{$m3_sales}}, {{$m2_sales}}, {{$m1_sales}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                    ],
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

{{-- === Yearly Orders === --}}
<script>
    const yearly_orders = document.getElementById('yearly_orders');
    new Chart(yearly_orders, {
        type: 'polarArea',
        data: {
            labels: ['{{$m12}}', '{{$m11}}', '{{$m10}}', '{{$m9}}', '{{$m8}}', '{{$m7}}', '{{$m6}}', '{{$m5}}', '{{$m4}}', '{{$m3}}',
                '{{$m2}}', '{{$m1}}'],
            datasets: [
                {
                    label: 'Orders',
                    data: [{{$m12_order}}, {{$m11_order}}, {{$m10_order}}, {{$m9_order}}, {{$m8_order}}, {{$m7_order}}, {{$m6_order}}, {{$m5_order}}, {{$m4_order}}, {{$m3_order}}, {{$m2_order}}, {{$m1_order}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
