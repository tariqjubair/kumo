@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('order_list')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">SSLCommerz Report</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Stripe Orders: </h3>
                <h4>Total: {{count($stripe_orders)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col table-hover" cellspacing="0" width="100%" id="order_table">
                    <thead>
                        <tr>
                            <th>Sr:</th>
                            <th data-priority="1">Order ID:</th>
                            <th>Name:</th>
                            <th>Email/Phone:</th>
                            <th data-priority="2">Total:</th>
                            <th>Date:</th>
                            <th data-priority="3">Status:</th>
                            <th>Transaction ID:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stripe_orders as $sl=>$order)

                            @php
                                $order_info = App\Models\OrderTab::where('order_id', $order->order_id)->first();
                            @endphp

                            <tr style="background: white">
                                <td style="text-align:center">{{$sl+1}}</td>
                                <td>{{$order->order_id}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->email}}<br>
                                    {{$order->phone}}</td>
                                <td>{{number_format($order->amount)}} &#2547;</td>
                                <td>{{$order_info ?$order_info->created_at->isoFormat('DD-MMM-YY') :'-'}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$order->transaction_id}}</td>
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