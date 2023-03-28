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
                        <li class="breadcrumb-item active" aria-current="page">Complete Failed</li>
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
                <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-danger text-danger mx-auto mb-4 success_icon"><i class="fas fa-times-octagon"></i></div>

                <!-- Heading -->
                <h2 class="mb-2 ft-bold">Your Order Has Been Failed!</h2>

                <!-- Text -->
                <p class="ft-regular fs-md mb-5">Your order has been failed due to unsuccessful payment transaction. Please try checking out again.</p>

                <!-- Button -->
                <a class="btn btn-dark text-center" style="width: 130px" href="{{route('shop_page')}}">Shop Again</a>
                <a class="btn btn-dark" style="width: 130px" href="{{route('cart.store.update')}}">My Cart</a>
            </div>
        </div>
        
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->
@endsection