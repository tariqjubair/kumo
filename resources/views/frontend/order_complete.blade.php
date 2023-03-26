@extends('layouts.master')



@section('header_css')
<style>
    .success_icon i {
        font-size: 30px !important;
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
                        <li class="breadcrumb-item"><a href="{{route('customer.order')}}">My Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Complete Order</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<section class="middle">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                <!-- Icon -->
                <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-success mx-auto mb-4 success_icon"><i class="fad fa-box-check"></i></div>

                <!-- Heading -->
                <h2 class="mb-2 ft-bold">Your Order Has Been Placed!</h2>

                <!-- Text -->
                <p class="ft-regular fs-md mb-5">Your order <span class="text-body text-success">{{session('order_conf')}}</span> has been placed successfully and being prepared for delivery. Order details are stored in your profile.</p>

                <!-- Button -->
                <a class="btn btn-dark text-center" style="width: 130px" href="{{route('shop_page')}}">Shop Again</a>
                <a class="btn btn-dark" style="width: 130px" href="{{route('customer.order')}}">My Orders</a>
            </div>
        </div>
        
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->
@endsection