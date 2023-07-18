@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order List</a></li>
    </ol>
</div>

@can('order_view')
    
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>{{@$_GET['gen'] ?'Selected Orders' :'Orders All'}}: 
                    @can('download_order_list')
                    @if (@$_GET['gen'])
                        <a href="{{route('export.selected_order', [
                            'start_dt' => @$_GET['start'],
                            'end_dt' => @$_GET['end'],
                            'pay' => @$_GET['pay'],
                            'status' => @$_GET['status'],
                        ])}}" class="btn btn-success btn-xxs shadow ml-3">Download</a>
                    @else
                        <a href="{{route('export.order')}}" class="btn btn-success btn-xxs shadow ml-3">Download</a>
                    @endif
                    @endcan
                </h3>
                <h4>Total: {{count($order_info)}}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-3">
                        <div class="item_div mb-4">
                            <label class="form-lable">Start Date:</label>
                            <input type="datetime-local" name="start_dt" class="form-control start_dt" value="{{@$_GET['start'] ?@$_GET['start'] :$start_dt}}">
                            @error('start_dt')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="item_div mb-4">
                            <label class="form-lable">End Date:</label>
                            <input type="datetime-local" name="end_dt" class="form-control end_dt" value="{{@$_GET['end'] ?@$_GET['end'] :$end_dt}}">
                            @error('end_dt')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="item_div mb-4">
                            <label class="form-lable">Payment Type:</label>
                            <select name="pay_type" class="form-control pay_type">
                                <option value="">--Select--</option>
                                <option {{@$_GET['pay'] == 1 ?'selected' :''}} value="1">Cash Payment</option>
                                <option {{@$_GET['pay'] == 2 ?'selected' :''}} value="2">SSLCommerz Payment</option>
                                <option {{@$_GET['pay'] == 3 ?'selected' :''}} value="3">Stripe Payment</option>
                            </select>
                            @error('pay_type')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="item_div mb-4">
                            <label class="form-lable">Order Status:</label>
                            <select name="status" class="form-control status">
                                <option value="">--Select--</option>
                                <option {{@$_GET['status'] == 1 ?'selected' :''}} value="1">Order Placed</option>
                                <option {{@$_GET['status'] == 2 ?'selected' :''}} value="2">Order Confirmed</option>
                                <option {{@$_GET['status'] == 3 ?'selected' :''}} value="3">Order Processing</option>
                                <option {{@$_GET['status'] == 4 ?'selected' :''}} value="4">Order Ready</option>
                                <option {{@$_GET['status'] == 5 ?'selected' :''}} value="5">Order Delivered</option>
                                <option {{@$_GET['status'] == 6 ?'selected' :''}} value="6">Order Cancelled</option>
                            </select>
                            @error('status')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12 text-center">
                        <button type="button" class="btn btn-primary order_btn mr-1" style="width: 120px">Search</button>
                        <a href="{{route('order_list')}}" class="btn btn-secondary ml-1" style="width: 120px">Reset</a>
                    </div>
                </div>

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
                        @foreach ($order_info as $sl=>$order)
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

                                            @can('update_order')
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
                                            @endcan
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

{{-- === Filter Orders === --}}
<script>
    $('.order_btn').click(function(){
        var start_dt = $('.start_dt').val();
        var end_dt = $('.end_dt').val();
        var pay_type = $('.pay_type').val();
        var status = $('.status').val();
        // var cate_id = $(this).val();
        // var brand_id = $('input[class="brand_box"]:checked').val();
        // var min_price = $('.min_price').val();
        // var max_price = $('.max_price').val();
        // var sorting = $('.sorting').val();
        // var showing = $('.showing').val();

        // var search_link = "" + "?inp=" + master_inp + "&cate=" + cate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&sort=" + sorting + "&show=" + showing;
        // window.location.href = search_link;


        var search_link = "{{route('order_list')}}" + "?gen=" + 'gen' + "&start=" + start_dt + "&end=" + end_dt + "&pay=" + pay_type + "&status=" + status;
        window.location.href = search_link;

        
    });
</script>
@endsection