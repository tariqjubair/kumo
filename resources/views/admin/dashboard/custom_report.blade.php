@extends('layouts.dashboard')

@section('header_style')
<style>
    
</style>
@endsection

@section('content')

<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Custom Report</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h3>Generate Report:</h3>
            </div>
            <div class="card-body">
                <form action="" method="GET" class="row">
                    @csrf
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Start Date:</label>
                            <input type="datetime-local" name="start_dt" class="form-control" value="{{$start_dt}}">
                            @error('start_dt')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">End Date:</label>
                            <input type="datetime-local" name="end_dt" class="form-control" value="{{$end_dt}}">
                            @error('end_dt')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <button type="submit" class="btn btn-primary">Generate</button>
                        <a href="{{route('custom.report')}}" class="btn btn-secondary ml-2">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="row">
            <div class="col-sm-6 col-xl-6">
                <div class="widget-stat card bg-success">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="mr-3">
                                <i class="fad fa-box-check"></i>
                            </span>
                            <div class="media-body text-white text-right">
                                <p class="mb-1">Orders Received</p>
                                <h3 class="text-white">{{$custom_orders}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="mr-3">
                                <i class="fad fa-truck-container"></i>
                            </span>
                            <div class="media-body text-white text-right">
                                <p class="mb-1">Orders Delivered</p>
                                <h3 class="text-white">{{$custom_delivery}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-6">
                <div class="widget-stat card bg-secondary">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="mr-3">
                                <i class="fad fa-envelope-open-dollar"></i>
                            </span>
                            <div class="media-body text-white text-right">
                                <p class="mb-1">Sales Amount</p>
                                <h3 class="text-white">{{number_format($custom_sales)}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-6">
                <div class="widget-stat card" style="background: rgb(179, 15, 28)">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="mr-3" style="background: rgba(255, 255, 255, 0.25); color: #fff">
                                <i class="fad fa-window-close"></i>
                            </span>
                            <div class="media-body text-white text-right">
                                <p class="mb-1">Order Cancelled</p>
                                <h3 class="text-white">{{$custom_cancel}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

{{-- === Customer & Products === --}}
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h3>Products Sold:</h3>
                <h4>Total: {{count($order_product)}}</h4>
            </div>
            {{-- {{$order_product}} --}}
            <div class="card-body">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="product_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Product:</th>
                            <th data-priority="4">Qty Sold:</th>
                            <th data-priority="2">Current Inv:</th>
                        </tr>   
                    </thead>
                    <tbody>
                        @foreach ($order_product as $key=>$product)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>
                                <span class="text-primary">{{$product->relto_product->product_name}}</span><br>
                                Color: {{$product->relto_color->color_name}}; Size: {{$product->relto_size->size}}
                            </td>
                            <td style="text-align: center">
                                {{$product->sum}}
                            </td>
                            <td style="text-align: center">
                                @php
                                    $inv_qty = App\Models\Inventory::where('product_id', $product->product_id)
                                    ->where('color', $product->color_id)
                                    ->where('size', $product->size_id)
                                    ->first()->quantity;
                                @endphp

                                {{$inv_qty}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h3>PO Customers:</h3>
                <h4>Total: {{count($order_cust)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="cust_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Name:</th>
                            <th data-priority="4">Email/Phone:</th>
                            <th data-priority="2">Total Sale:</th>
                        </tr>   
                    </thead>
                    <tbody>
                        @foreach ($order_cust as $key=>$cust)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>
                                {{-- {{$cust->customer_id}} --}}
                                @if ($cust->relto_custinfo->status == 0)
                                    <del>{{$cust->relto_custinfo->name}}</del>
                                @else
                                    <span class="text-primary">{{$cust->relto_custinfo->name}}</span>
                                @endif
                            </td>
                            <td>
                                {{$cust->relto_custinfo->email}}<br>
                                {{$cust->relto_custinfo->code ?$cust->relto_custinfo->code.'-' :''}} {{$cust->relto_custinfo->mobile ?$cust->relto_custinfo->mobile :''}}
                            </td>
                            <td>
                                @php
                                    $same_cust_order = App\Models\OrderTab::whereBetween('created_at', [$start_dt, $end_dt])->where('customer_id', $cust->customer_id)->where('order_status', '!=', 6) ->count();
                                    $same_cust_sale = App\Models\OrderTab::whereBetween('created_at', [$start_dt, $end_dt])->where('customer_id', $cust->customer_id)->where('order_status', '!=', 6) ->sum('gtotal');
                                @endphp

                                {{number_format($same_cust_sale)}} ({{$same_cust_order}})
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- === Order List === --}}
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Custom List of Orders: <a href="{{route('export.custom_orders', [
                    'start_dt' => $start_dt,
                    'end_dt' => $end_dt,
                ])}}" class="btn btn-success btn-xxs shadow ml-3">Download</a></h3>
                <h4>Total: {{count($order_all)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col table-hover" cellspacing="0" width="100%" id="order_table">
                    <thead>
                        <tr>
                            <th>Sr:</th>
                            <th>Date:</th>
                            <th data-priority="1">Order ID:</th>
                            <th>Name:</th>
                            <th>Email:</th>
                            <th>Payment In:</th>
                            <th>Total:</th>
                            <th data-priority="3">Status:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_all as $sl=>$order)
                            <tr style="background: white">
                                <td style="text-align:center">{{$sl+1}}</td>
                                <td>{{$order->created_at->isoFormat('DD-MMM-YY')}}</td>
                                <td>{{$order->order_id}}</td>
                                <td>{{$order->relto_custinfo->name}}</td>
                                <td>{{$order->relto_custinfo->email}}</td>
                                <td>
                                    @if ($order->payment_method == 1)
                                        {{'Cash'}}
                                    @elseif ($order->payment_method == 2)
                                        {{'SSL Commerce'}}
                                    @elseif ($order->payment_method == 3)
                                        {{'Stripe'}}
                                    @endif
                                </td>
                                <td>{{number_format($order->total)}} &#2547;</td>
                                <td>
                                    @if ($order->order_status == 1)
                                        <span class="badge badge-outline-dark">{{'Order Placed'}}</span>
                                    @elseif ($order->order_status == 2)
                                        <span class="badge badge-success">{{'Confirmed'}}</span>
                                    @elseif ($order->order_status == 3)
                                        <span class="badge badge-warning">{{'Processing'}}</span>
                                    @elseif ($order->order_status == 4)
                                        <span class="badge badge-secondary">{{'Ready to Deliver'}}</span>
                                    @elseif ($order->order_status == 5)
                                        <span class="badge badge-primary">{{'Delivered'}}</span>
                                    @elseif ($order->order_status == 6)
                                        <span class="badge badge-danger">{{'Canceled'}}</span>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                            <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('order.info', $order->id)}}">View Order</a>

                                            <form action="{{route('order_status.update')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$order->order_id}}">
                                                @if ($order->order_status == 1 )
                                                    <button class="dropdown-item" name="status" value="2" id="conf_btn">Confirm</button>
                                                    <button class="dropdown-item" name="status" value="6" id="canc_btn">Cancel</button>
                                                @elseif ($order->order_status != 1 && $order->order_status != 6)
                                                    <button class="dropdown-item" name="status" value="3">Processing</button>
                                                    <button class="dropdown-item" name="status" value="4">Ready to Deliver</button>
                                                    <button class="dropdown-item" name="status" value="5">Delivered</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection




@section('footer_script')

{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#order_table').DataTable({
            responsive: true,
        });
		$('#cust_table').DataTable({
            responsive: true,
        });
		$('#product_table').DataTable({
            responsive: true,
        });
	} );
</script>

{{-- === Dash preloader on Submit === --}}
<script>
    $(document).ready(function () {
        $("#conf_btn").click(function () {
            $("#dash_loader").show();
        });
        $("#canc_btn").click(function () {
            $("#dash_loader").show();
        });
    });
</script>
@endsection
