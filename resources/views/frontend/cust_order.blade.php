@extends('layouts.master')




@section('header_css')
<style>
    .order_head {
        transition: .2s;
        position: relative;
    }
    .order_head:hover {
        background: rgba(0, 0, 255, 0.08);
        border: 1px solid blue;
        cursor: pointer;
    }
    .order_head:hover .arrow i{
        color: blue
    }
    .order_head .arrow {
        position: absolute;
        top: 52%;
        left: 130px;
        transform: translateY(-50%);
    }
    .order_head .arrow i {
        font-size: 20px;
        transition: .3s
    }

    .order_list {
        display: none;
    }

    .first_loop .order_list {
        display: block;
    }
    .first_loop .no_arw {
        display: none;
    }
</style>
@endsection




@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home_page')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customer.profile')}}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Order</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Dashboard Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            {{-- === Customer Dashboard === --}}
            <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                @if (session('cust_prof_upd'))
                    <span class="err_msg err_msg_prof" style="visibility:visible; background: blue">
                    <p>{{session('cust_prof_upd')}}</p></span>
                @endif

                <div class="d-block border rounded mfliud-bot">
                    <div class="dashboard_author px-2 pt-5 pb-4">
                            <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                                @if ($cust_info->prof_pic)
                                    <img src="{{asset('uploads/customer')}}/{{$cust_info->prof_pic}}" class="img-fluid circle" width="100" alt="Customer" />
                                @else
                                    <img src="{{asset('assets/img/customer.png')}}" class="img-fluid circle" width="100" alt="Customer" />
                                @endif
                            </div>
                        <div class="dash_caption">
                            <h4 class="fs-md ft-medium mb-0 lh-1">{{$cust_info->name}}</h4>
                            @if ($cust_info->city)
                                <span class="text-muted smalls d-block pt-3">{{$cust_info->relto_city->name}}</span>
                            @else
                                <span class="text-muted smalls d-block pt-3" style="font-style: italic">(-- City --)</span>    
                            @endif
                            @if ($cust_info->country)
                                <span class="text-muted smalls d-block">{{$cust_info->relto_country->name}}</span>
                            @else
                                <span class="text-muted smalls d-block" style="font-style: italic">(-- Country --)</span>    
                            @endif
                        </div>
                    </div>
                    
                    <div class="dashboard_author">
                        <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard Navigation</h4>
                        <ul class="dahs_navbar">
                            <li><a href="{{route('customer.order')}}" class="active"><i class="lni lni-shopping-basket mr-2"></i>My Orders</a></li>
                            <li><a href="{{route('customer.wishlist')}}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{route('customer.profile')}}"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{route('customer.logout')}}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            {{-- === Order Details === --}}
            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                @forelse ($order_all as $order)
                    <div class="ord_list_wrap border mb-4 {{$loop->first ?'first_loop' :''}}">
                        <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3 order_head">
                            <div class="olh_flex">
                                <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
                                <h6 class="mb-0 ft-medium">{{$order->order_id}}</h6>
                            </div>		
                            <div class="arrow {{$loop->first ?'d-none' :''}}">
                                <i class="fad fa-angle-double-down"></i>
                            </div>		
                            <div class="arrow {{$loop->first ?'' :'d-none'}}">
                                <i class="fad fa-angle-double-up"></i>
                            </div>		
                            <div class="olh_flex">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status">
                                    @if ($order->order_status == 1)
                                        <span class="ft-medium small text-info bg-light-info rounded px-3 py-1">Order Placed</span>
                                    @elseif ($order->order_status == 2)
                                        <span class="ft-medium small text-success bg-light-success rounded px-3 py-1">Order Confirmed</span>
                                    @elseif ($order->order_status == 3)
                                        <span class="ft-medium small text-warning bg-light-warning rounded px-3 py-1">Processing</span>
                                    @elseif ($order->order_status == 4)
                                        <span class="ft-medium small rounded px-3 py-1" style="color: #A02CFA; background: #eedcfc">Ready to Deliver</span>
                                    @elseif ($order->order_status == 5)
                                        <span class="ft-medium small text-white rounded px-3 py-1" style="background: blue">Delivered</span>
                                    @elseif ($order->order_status == 6)
                                        <span class="ft-medium small text-white bg-primary rounded px-3 py-1">Canceled</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- === Product Info === --}}
                        @foreach (App\Models\OrdereditemsTab::where('customer_id', Auth::guard('CustLogin')->id())->where('order_id', $order->order_id)->get() as $ord_items)
                            <div class="ord_list_body text-left order_list">
                                <div class="row align-items-center justify-content-center m-0 py-4 br-bottom">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                        <div class="cart_single d-flex align-items-start mfliud-bot">
                                            <div class="cart_selected_single_thumb" style="border: 1px solid rgba(128, 134, 134, 0.527)">
                                                <a href="{{route('product.details', $ord_items->relto_product->slug)}}"><img src="{{asset('uploads/product/preview')}}/{{$ord_items->relto_product->preview}}" width="100" class="img-fluid rounded" alt=""></a>
                                            </div>
                                            <div class="cart_single_caption pl-3">
                                                <p class="mb-0"><span class="text-muted small">{{$ord_items->relto_product->relto_cata->cata_name}}</span></p>
                                                <h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{$ord_items->relto_product->product_name}}</h4>
                                                <p class="mb-2"><span class="text-dark medium">Size: {{$ord_items->relto_size->size}}</span>, <span class="text-dark medium">Color: {{$ord_items->relto_color->color_name}}</span></p>
                                                <h4 class="fs-sm ft-bold mb-0 lh-1">{{number_format($ord_items->price)}} &#2547;</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-12 ml-auto">
                                        <p class="mb-1 p-0"><span class="text-muted">Quantity:</span></p>
                                        <h3 class="pl-2">x {{$ord_items->quantity}}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                            <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                                <div class="olf_flex_inner"><p class="m-0 p-0"><span class="text-muted medium text-left">Order Date: {{$order->created_at->isoFormat('DD-MMM-YY')}}</span></p></div>
                                <div class="olf_inner_right"><h5 class="mb-0 fs-sm ft-bold">Total: {{number_format($order->gtotal)}} &#2547;</h5></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <img src="{{asset('assets/img/order_list.jpg')}}" class="w-80" alt="No Order">
                    <h4 class="pb-3">Your Orders would appear here!!</h4>
                    <a class="btn btn-primary m-auto" href="#">Start Shopping</a>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->
@endsection




@section('footer_script')

{{-- === Toggle Ordered Items List === --}}
<script>
    $('.order_head').click(function(){
        $(this).nextAll('.order_list').slideToggle();
        $(this).find('.arrow').toggleClass('d-none');

        $('.first_loop').toggleClass('d-block');
    });
</script>
@endsection