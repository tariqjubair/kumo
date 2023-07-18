@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('order_list')}}">Order List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">
            @if ($order_tab->order_status == 1)
                <span class="text-info">Order Placed</span>
            @elseif ($order_tab->order_status == 2)
                <span class="text-success">Order Confirmed</span>
            @elseif ($order_tab->order_status == 3)
                <span class="text-warning">Order Processing</span>
            @elseif ($order_tab->order_status == 4)
                <span class="text-secondary">Order Ready</span>
            @elseif ($order_tab->order_status == 5)
                <span class="text-primary">Order Delivered</span>
            @else
                <span class="text-danger">Order Cancelled</span>
            @endif
            </a></li>
    </ol>
</div>

@can('order_view')
    
<div class="row">

    {{-- === Ordered Items === --}}
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3>Order ID: {{$order_id}}</h3>

                @can('update_order')
                @if ($order_tab->order_status == 1)
                    <form action="{{route('order_status.update')}}" method="POST" id="status_form">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$order_id}}">
                        <button class="btn btn-outline-success btn-xs mr-2 status_btn" name="status" value="2" id="conf_btn">Confirm</button>
                        <button class="btn btn-outline-danger btn-xs status_btn" name="status" value="6" id="canc_btn">Cancel</button>
                    </form>
                @elseif ($order_tab->order_status != 1 && $order_tab->order_status != 6) 
                    <a href="{{route('order.inv', substr($order_id, 1))}}" target="_blank" class="btn btn-outline-primary btn-xs">Get Invoice</a>
                @endif
                @endcan
                <h4>Total: {{$ordered_items->count()}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="order_item_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Image:</th>
                            <th data-priority="4">Product Info:</th>
                            <th data-priority="3">Qty:</th>
                            <th data-priority="2">Price:</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($ordered_items as $key=>$item)
                        <tr style="background: white">
                            <td>{{$key+1}}</td>
                            <td>
                                <div class="item_div d-inline-block border">
                                    <a href="{{route('product.inventory', $item->product_id)}}"><img src="{{asset('uploads/product/preview')}}/{{$item->relto_product->preview}}" width="100" class="img-fluid" alt=""></a>
                                </div>
                            </td>
                            <td>
                                <h5 class="text-primary">{{$item->relto_product->product_name}}</h5>
                                Size: {{$item->relto_size->size}}<br>
                                Color: {{$item->relto_color->color_name}}<br>
                                Price: {{number_format($item->price)}} &#2547;
                            </td>
                            <td style="text-align: left"><span style="font-size: 24px">x {{$item->quantity}}</span></td>
                            <td>
                                Total:<br> {{number_format($item->price * $item->quantity)}} &#2547;
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-4">

        {{-- === Billing === --}}
        <div class="card">
            <div class="card-header">
                <h3>Billing:</h3>
                <h4>{{$order_tab->created_at->format('d-M-y h:i A')}}</h4>
            </div>
            <div class="card-body">
                <div class="item mb-3">
                    @if ($order_tab->relto_custinfo->prof_pic)
                        <img src="{{asset('uploads/customer')}}/{{$order_tab->relto_custinfo->prof_pic}}" class="img-fluid circle" style="border-radius: 50px" width="100" alt="Customer" />
                    @else
                        <img src="{{asset('assets/img/customer.png')}}" class="img-fluid circle" style="border-radius: 50px" width="100" alt="Customer" />
                    @endif
                </div>
                <h5><span class="text-danger">Customer Name:</span> {{$order_tab->relto_custinfo->name}}</h5>
                <h5><span class="text-danger">Email:</span> {{$order_tab->relto_custinfo->email}}</h5>
                <h5><span class="text-danger">Phone:</span> {{$order_tab->relto_custinfo->code ?$order_tab->relto_custinfo->code :''}}
                    {{$order_tab->relto_custinfo->mobile ?$order_tab->relto_custinfo->mobile :''}}</h5>
                
                <h5><span class="text-danger">Delivery Address:</span></h5>
                <h5>{{$billing_tab->first()->name}}</h5>
                <h5>Email: {{$billing_tab->first()->email}}</h5>
                <h5>Phone: {{$billing_tab->first()->mobile}}</h5>
                <h5>Company: {{$billing_tab->first()->company}}</h5>
                <h5>Address: {{$billing_tab->first()->address}}</h5>
                <h5>City: {{$billing_tab->first()->relto_city->name}}</h5>
                <h5>Country: {{$billing_tab->first()->relto_country->name}}</h5>
                <h5>Zip: {{$billing_tab->first()->zip}}</h5>
                <br>

                <h5><span class="text-danger">Sub-Total:</span> {{number_format($order_tab->total)}} &#2547;</h5>
                <h5><span class="text-danger">Discount:</span> {{number_format($order_tab->discount)}} &#2547;</h5>
                <h5><span class="text-danger">Charges:</span> {{number_format($order_tab->charge)}} &#2547;</h5>
                <h5><span class="text-danger">Grand Total:</span> {{number_format($order_tab->gtotal)}} &#2547;</h5>
                <h5>
                    <span class="text-danger">Payment Method:</span> 
                    @if ($order_tab->payment_method == 1)
                        Cash On Delivery
                    @elseif ($order_tab->payment_method == 2)
                        SSLCommerz
                    @else
                        Stripe
                    @endif
                </h5>
                <br>

                
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
		$('#order_item_table').DataTable({
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