@extends('layouts.master')


@section('header_css')

<style>
    @media (max-width: 576.98px){
    
        .sm_dis_cart {
            margin: 0;
        }
        .sm_dis_total {
            margin-top: 80px;
        }
            
    }

    @media (max-width: 991.98px){
    
        .sm_dis_total {
            margin-top: 30px;
        }
            
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
                        <li class="breadcrumb-item"><a href="{{route('shop_page')}}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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
    
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Shopping Cart</h2>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-md-12">
                @if (session('cart_page_removed'))
                <span class="err_msg err_msg_cart_page_left bg-danger" style="visibility:visible">
                    <p>{{session('cart_page_removed')}}</p>
                </span>
                @endif

                {{-- === Billing Form === --}}
                <form action="{{route('cart.updated')}}" method="POST">
                    @csrf
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                        @php
                            $total = 0;
                        @endphp

                        @forelse ($cart_info as $cart)
                            @php
                                $stock = App\Models\Inventory::where('product_id', $cart->product_id)->where('color', $cart->color_id)->where('size', $cart->size_id)->get()->first()->quantity;
                            @endphp

                            @if ($cart->relto_product()->exists())
                                <li class="list-group-item">
                                    <div class="row align-items-center sm_dis_cart">
                                        <div class="col-3 p-0" style="border: 1px solid rgba(128, 134, 134, 0.527);">
                                            <!-- Image -->
                                            <a href="{{route('product.details', $cart->relto_product->slug)}}"><img src="{{asset('uploads/product/preview')}}/{{$cart->relto_product->preview}}" alt="Product Preview" class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center justify-content-between">
                                            <div class="cart_single_caption pl-2">
                                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{$cart->relto_product->product_name}}</h4>
                                                <p class="mb-1 lh-1"><span class="text-dark">Size: {{$cart->relto_size->size}}</span></p>
                                                <p class="mb-3 lh-1"><span class="text-dark">Color: {{$cart->relto_color->color_name}}</span></p>
                                                <h4 class="fs-md ft-medium mb-3 lh-1">BDT {{number_format($cart->relto_product->after_disc)}}</h4>
                                                
                                                <select class="mb-2 custom-select w-auto" name="qty_new[{{$cart->id}}]">
                                                    @for ($i = 1; $i <= $stock; $i++)
                                                        <option {{$i == $cart->quantity ?'selected' :''}} 
                                                            value="{{$i}}" class="opt">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="fls_last"><a href="{{route('cart.remove.page', $cart->id)}}" class="close_slide gray"><i class="ti-close"></i></a></div>
                                    </div>
                                </li>
                            @endif

                            @php
                                if($cart->relto_product()->exists()){
                                    $total += $cart->relto_product->after_disc * $cart->quantity;
                                }
                            @endphp
                            @empty
                                <h3 class="text-center">Cart Empty! Add Items Now!!</h3>
                                <img src="{{asset('assets/img/empty_cart.jpg')}}" alt="Empty Cart" width="80%" class="m-auto">
                        @endforelse
                    </ul>
                    
                    <div class="row align-items-end justify-content-center mb-10 mb-md-0">
                        
                        @if (App\Models\CartMod::where('customer_id', Auth::guard('CustLogin')->id())->get()->first() != null)
                            <div class="col-12 col-md-auto mfliud">
                                <button class="btn stretched-link borders">Update Cart</button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            {{-- === Discount Calculations === --}}
            @php
                $ftotal = $total - $discount;
            @endphp

            @if(session('cart_upd'))
                @php
                    $discount = 0;
                    $ftotal = $total;
                @endphp
            @endif
            
            <div class="col-12 col-md-12 col-lg-4 sm_dis_total">
                <div class="card mb-4 gray mfliud scr_amount">
                    <div class="card-body">
                        @if (session('cart_upd'))
                        <span class="err_msg err_msg_cart_page" style="visibility:visible">
                            <p>{{session('cart_upd')}}</p>
                        </span>
                        @endif
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">{{number_format(round($total), 2)}} &#2547;</span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Discount</span> <span class="ml-auto text-dark ft-medium">{{number_format(round($discount), 2)}} &#2547;</span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Total</span> <span class="ml-auto text-dark ft-medium">{{number_format(round($ftotal), 2)}} &#2547;</span>
                            </li>
                            <li class="list-group-item fs-sm text-center">
                                Shipping cost calculated at Checkout *
                            </li>
                        </ul>
                    </div>
                </div>

                @php
                    session([
                        'total' => $total,
                        'discount' => $discount,
                        'ftotal' => $ftotal,
                    ])
                @endphp

                <!-- Coupon -->
                {{-- {{$coupon.' | '.$discount}}<br> --}}
                {{-- {{session('total').' | '.session('discount').' | '.session('ftotal')}} --}}
                
                <form class="mb-7 mb-md-0" action="{{route('cart.store.update', Auth::guard('CustLogin')->id())}}" method="GET">
                    <label class="fs-sm ft-medium text-dark">Coupon code:</label>
                    <input type="hidden" name="total" value="{{$total}}">
                    <div class="row form-row mb-2">
                        @if ($btn == 'click')
                            @if ($discount != 0)
                                <span class="err_msg err_msg_coupon bg-success" style="visibility:visible"><p>{{$coupon}}</p></span>
                            @else
                                <span class="err_msg err_msg_coupon bg-danger" style="visibility:visible"><p>{{$coupon}}</p></span>
                            @endif
                        @endif

                        <div class="col">
                            <input class="form-control" type="text" name="coupon" placeholder="Enter coupon code*" style="height: 46px !important">
                        </div>
                        <div class="col-auto">
                            <button name="coupon_btn" class="btn btn-dark" value="click" type="submit">Apply</button>
                        </div>
                    </div>
                </form>

                {{-- === Checkout === --}}
                @if ($cart_info->first())
                    <a class="btn btn-block btn-dark mb-3 checkout" href="{{route('checkout')}}" id="checkout_btn">Proceed to Checkout ({{count($cart_info)}})</a>
                @else
                    <button class="btn btn-block btn-dark mb-3 no_cart">Proceed to Checkout (0)</button>
                @endif

                <a class="btn-link text-dark ft-medium" href="{{route('shop_page')}}">
                    <i class="ti-back-left mr-2"></i> Continue Shopping
                </a>
            </div>
            
        </div>
        
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->
@endsection

@section('footer_script')

{{-- === Avoid Looping for GET === --}}
<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>

{{-- === No Cart Added Msg === --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.no_cart').click(function(){ 
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Your Cart is Empty!',
            footer: '<a href="{{route('home_page')}}">Continue Shopping</a>'
        })
    })
</script>

{{-- === Leave Page Alert === --}}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

@if ($discount != 0)
<script>
    $(window).on("beforeunload", function() {
        return "";
    });

    $(document).ready(function() {
        $(".checkout").click(function() {
            $(window).off("beforeunload");
            return true;
        });
    });
</script>
@endif

{{-- === Checkout Btn Preloader === --}}
<script>
    $(document).ready(function () {
        $("#checkout_btn").click(function () {
            $("#loader").show();
        });
    });
</script>

@if ($btn == 'click')
<script>
    $('html, body').animate({
        scrollTop: $('.scr_amount').offset().top -200
    }, 'slow');
</script>
@endif
@endsection

