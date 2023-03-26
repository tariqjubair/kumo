@extends('layouts.master')



@section('header_css')
<style>
    a.btn_love {
        opacity: 0;
        visibility: hidden;
        border: 1px solid #DFDFDF;
        transition: .3s;
    }
    a.btn_love:hover {
        background: black;
    }
    a.btn_love:hover i {
        color: #DFDFDF;
    }
    .product_grid:hover .btn_love {
        opacity: 1;
        visibility: visible;
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
                        <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
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
                            <li><a href="{{route('customer.order')}}"><i class="lni lni-shopping-basket mr-2"></i>My Orders</a></li>
                            <li><a href="{{route('customer.wishlist')}}"  class="active"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{route('customer.profile')}}"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{route('customer.logout')}}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            {{-- === Wish List === --}}
            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <!-- row -->
                <div class="row align-items-center">
                
                    <!-- Single -->
                    @forelse (App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->get() as $wish)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="product_grid card">
                                @php
                                    $product_info = App\Models\Product_list::find($wish->product_id);
                                @endphp

                                @if ($product_info->discount != 0)
                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                    <div class="badge bg-danger text-white position-absolute ft-regular ab-right text-upper">-{{$product_info->discount}}%</div>
                                @endif

                                <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                <a class="btn btn_love position-absolute ab-right theme-cl" href="{{route('wishlist.remove', $wish->id)}}"><i class="fas fa-times"></i></a> 
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $wish->relto_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$wish->relto_product->preview}}" alt="Product Preview"></a>
                                    </div>
                                </div>
                                <div class="card-footers pt-3 pb-2 px-2 bg-white d-flex align-items-start justify-content-center" style="border-top: 1px solid #DFDFDF">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{route('product.details', $wish->relto_product->slug)}}">{{$wish->relto_product->product_name}}</a></h5>
                                            <div class="elis_rty"><span class="ft-bold fs-md text-dark">{{number_format($wish->relto_product->after_disc)}} &#2547;</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <img src="{{asset('assets/img/no_wish.png')}}" class="w-100" alt="No Wishlist">
                        <a class="btn btn-primary m-auto" href="#">Start Shopping</a>
                    @endforelse
                </div>
                <!-- row -->
                @if (App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->first())
                    <a href="{{route('wishlist.remove_all')}}" class="btn btn-primary">Remove All</a>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->
@endsection