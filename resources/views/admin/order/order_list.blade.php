@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order List</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Order List: <a href="{{route('export.order')}}" class="btn btn-success btn-xxs shadow ml-3">Download</a></h3>
                <h4>Total: {{$order_count}}</h4>
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
                                        {{'Cash on Delivery'}}
                                    @elseif ($order->payment_method == 2)
                                        {{'SSL Commerce'}}
                                    @elseif ($order->payment_method == 3)
                                        {{'Stripe'}}
                                    @endif
                                </td>
                                <td>{{number_format($order->total)}}</td>
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
                                                    <button class="dropdown-item" name="status" value="2">Confirm</button>
                                                    <button class="dropdown-item" name="status" value="6">Cancel</button>
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
	} );
</script>
@endsection