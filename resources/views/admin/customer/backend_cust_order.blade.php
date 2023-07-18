@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('cust_list')}}">Customer List</a></li>
        <li class="breadcrumb-item"><a href="{{route('order_list')}}">Order List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)"><span class="text-danger">{{$cust_name}}</span> Orders</a></li>
    </ol>
</div>

@can('customer_control')
    
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Customer Orders: <a href="{{route('export.cust_order', $cust_id)}}" class="btn btn-success btn-xxs shadow ml-3">Download</a></h3>
                <h4>Total: {{count($cust_order)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col table-hover" cellspacing="0" width="100%" id="order_table">
                    <thead>
                        <tr>
                            <th>Sr:</th>
                            <th data-priority="1">Order ID:</th>
                            <th data-priority="4">Date:</th>
                            <th>Total:</th>
                            <th>Payment In:</th>
                            <th data-priority="3">Status:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cust_order as $sl=>$order)
                            <tr style="background: white">
                                <td style="text-align:center">{{$sl+1}}</td>
                                <td>{{$order->order_id}}</td>
                                <td>{{$order->created_at->isoFormat('DD-MMM-YY')}}</td>
                                <td>{{number_format($order->total)}} &#2547;</td>
                                <td>
                                    @if ($order->payment_method == 1)
                                        {{'Cash on Delivery'}}
                                    @elseif ($order->payment_method == 2)
                                        {{'SSL Commerce'}}
                                    @elseif ($order->payment_method == 3)
                                        {{'Stripe'}}
                                    @endif
                                </td>
                                
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
                                        <span class="badge badge-danger">{{'Cancelled'}}</span>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                            <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('order.info', $order->id)}}">View Order</a>

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

@else
<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text  font-weight-bold">403</h1>
                        <h4><i class="fa fa-times-circle text-danger"></i> Forbidden Error!</h4>
                        <p>You do not have permission to view this resource.</p>
						<div>
                            <a class="btn btn-primary" href="{{route('home')}}">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endcan
@endsection




@section('footer_script')

{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#order_table').DataTable({
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