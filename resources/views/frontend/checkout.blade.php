@extends('layouts.master')

@section('header_css')
<style>

    /* === Select 2 Custom === */
    .select2-container--default .select2-selection--single{
        height: 52px !important;
        padding: 10px 15px;
        padding-top: 13px;
        border-radius: 1px;
        border-color: #e5e5e5;

        font-size: 1rem;
        line-height: 1.25;
        color: #495057;
        background-color: #fff;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        font-size: 14px;
        position: absolute;
        top: 18px;
        right: 8px;
    }
    #code_view .select2-container--default .select2-selection--single{
        padding: 12px 0 8px 5px !important;
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
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
        
        <form action="{{route('billing.store')}}" method="POST" id="checkout_billing">
            @csrf
            <div class="row justify-content-between">

                {{-- === Billing Form === --}}
                <div class="col-12 col-lg-7 col-md-12">
                    <h5 class="mb-4 ft-medium">Delivery Details</h5>
                    <div class="row mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Full Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="Receipient Name" value="{{old('name') ?old('name') :Auth::guard('CustLogin')->user()->name}}">
                                @error('name')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label class="text-dark">Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email') ?old('email') :Auth::guard('CustLogin')->user()->email}}">
                                @error('email')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Company</label>
                                <input type="text" name="company" class="form-control" placeholder="Company Name (optional)" value="{{old('company')}}">
                                @error('company')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Delivery Address *</label>
                                <input type="text" name="address" class="form-control" placeholder="Address" value="{{old('address')}}">
                                @error('address')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label class="text-dark">Country *</label>
                                    <select class="custom-select select2 set_country" name="country">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option {{$country->id == old('country') ?'selected' :''}}
                                        value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label class="text-dark">City / Town *</label>

                                @if (old('country'))
                                    @php
                                        $sel_city = App\Models\City::where('country_id', old('country'))->get();
                                    @endphp

                                    <select type="text" class="custom-select select2 show_city" name="city">
                                        @foreach ($sel_city as $city)
                                            <option {{$city->id == old('city') ?'selected' :''}}
                                            value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select type="text" class="custom-select select2 show_city" name="city">
                                        <option value="">-- Select City --</option>
                                    </select>
                                @endif
                                @error('city')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4 pr-0">
                            <div class="form-group" id="code_view">
                                <label class="text-dark">Phone Code *</label>
                                <select type="text" class="custom-select select2 show_code" name="code">
                                    <option value="">-- --</option>
                                </select>
                                @error('code')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-8 col-sm-8 col-8">
                            <div class="form-group">
                                <label class="text-dark">Mobile Number *</label>
                                <input type="number" name="mobile" class="form-control" placeholder="Mobile Number" value="{{old('mobile')}}">
                                @error('mobile')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label class="text-dark">ZIP / Postcode *</label>
                                <input type="number" name="zip" class="form-control" placeholder="Zip / Postcode" value="{{old('zip')}}">
                                @error('zip')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Additional Information</label>
                                <textarea name="note" class="form-control ht-50">{{old('note')}}</textarea>
                                @error('note')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-12 col-lg-4 col-md-12">

                    {{-- === Ordered Items === --}}
                    <div class="d-block mb-3">
                        <h5 class="mb-4">Order Items ({{count($cart_info)}})</h5>
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                            
                            @foreach ($cart_info as $cart)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-3 p-0" style="border: 1px solid rgba(128, 134, 134, 0.527)">
                                            <!-- Image -->
                                            <a href="{{route('product.details', $cart->relto_product->slug)}}"><img src="{{asset('uploads/product/preview/'.$cart->relto_product->preview)}}" alt="Product Preview" class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <div class="cart_single_caption pl-2">
                                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{$cart->relto_product->product_name}}</h4>
                                                <p class="mb-1 lh-1"><span class="text-dark">Size: {{$cart->relto_size->size}}</span></p>
                                                <p class="mb-3 lh-1"><span class="text-dark">Color: {{$cart->relto_color->color_name}}</span></p>
                                                <h4 class="fs-md ft-medium mb-3 lh-1">{{number_format($cart->relto_product->after_disc)}} &#2547; * {{$cart->quantity}} </h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    {{-- === Location Charge === --}}
                    <div class="mb-4">
                        <div class="form-group err_scroll">
                            <h6>Delivery Location</h6>
                            <ul class="no-ul-list">
                                @foreach (App\Models\ChargeTab::all() as $charge)
                                    <li>
                                        <input {{$charge->charge == old('delivery_charge') ?'checked' :''}}
                                        id="charge{{$charge->id}}" class="radio-custom location" name="delivery_charge" type="radio" value="{{$charge->charge}}">
                                        <label for="charge{{$charge->id}}" class="radio-custom-label">{{$charge->location}}</label>
                                    </li>
                                @endforeach
                            </ul>
                            @error('delivery_charge')
                                <strong class="text-danger err">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>

                    {{-- === Payment Method === --}}
                    <div class="mb-4">
                        <div class="form-group err_scroll" >
                            <h6>Select Payment Method</h6>
                            <ul class="no-ul-list">

                                <li>
                                    <input {{old('payment_method') == 1 ?'checked' :''}}
                                    id="c3" class="radio-custom" name="payment_method" value="1" type="radio">
                                    <label for="c3" class="radio-custom-label">Cash on Delivery</label>
                                </li>
                                <li>
                                    <input {{old('payment_method') == 2 ?'checked' :''}}
                                    id="c4" class="radio-custom" name="payment_method" value="2" type="radio">
                                    <label for="c4" class="radio-custom-label">Pay With SSLCommerz</label>
                                </li>
                                <li>
                                    <input {{old('payment_method') == 3 ?'checked' :''}}
                                     id="c5" class="radio-custom" name="payment_method" value="3" type="radio">
                                    <label for="c5" class="radio-custom-label">Pay With Stripe</label>
                                </li>
                            </ul>
                            @error('payment_method')
                                <strong class="text-danger err">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>

                    {{-- === Breakdown === --}}
                    {{-- {{session('total').' | '.session('discount').' | '.session('ftotal')}} --}}
                    
                    <div class="card mb-4 gray">
                        <div class="card-body">
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">{{number_format(round(session('total')), 2)}} &#2547;</span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Coupon Discount ( - )</span> <span class="ml-auto text-dark ft-medium">{{number_format(round(session('discount')), 2)}} &#2547;</span>
                            </li>

                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Delivery Charge ( + )</span> <span class="ml-auto text-dark ft-medium" id="del_charge">
                                    @if (old('delivery_charge'))
                                        {{old('delivery_charge')}}
                                    @else
                                        {{number_format(round(0), 2)}} 
                                    @endif
                                    &#2547;
                                </span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Grand Total:</span> <span class="ml-auto text-dark ft-medium number" id="gtotal">
                                    @if (old('delivery_charge'))
                                        @php
                                            $ftotal = session('ftotal');
                                            $old_charge = old('delivery_charge');
                                            $old_gtotal = $ftotal + $old_charge
                                        @endphp
                                        {{number_format(round($old_gtotal), 2)}}
                                    @else
                                        {{number_format(round(session('ftotal')), 2)}} 
                                    @endif
                                    &#2547;
                                </span>
                            </li>
                            </ul>
                        </div>
                    </div>
                    
                    <input type="hidden" name="subtotal" value="{{session('total')}}">
                    <input type="hidden" name="discount" value="{{session('discount')}}">
                    <input type="hidden" name="ftotal" value="{{session('ftotal')}}">

                    <button class="btn btn-block btn-dark mb-3" id="order_btn">Place Your Order</button>
                </div>
            </div>
        </form>
        
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->
    
@endsection

@section('footer_script')

{{-- === Charge Calculation === --}}
<script>
    $('.location').click(function(){
        var charge = $(this).val();
        
        var ftotal = {{session('ftotal')}};
        var gtotal = parseInt(ftotal) + parseInt(charge)
        
        var charge_sp = $.number(charge, 2 )
        $('#del_charge').html(charge_sp + ' &#2547;');

        var gtotal_sp = $.number(gtotal, 2 );
        $('#gtotal').html(gtotal_sp + ' &#2547;');
    })
</script>

{{-- === Scroll to Error === --}}
<script>
    $('.err').show(function(){
        $(document).ready(function(){
            $("html, body").animate({ 
                scrollTop: $('.err').offset().top -400
            }, 0);
        });
    })
</script>

{{-- === Select2 Search === --}}
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('b[role="presentation"]').hide();
        $('.select2-selection__arrow').append('<i class="fad fa-sort-up"></i>');
    });
</script>

{{-- === Ajax: Get City/Code === --}}
<script>
    $('.set_country').change(function(){
        var country_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax ({
            url: '/get_city',
            type: 'POST',
            data: {'country_id': country_id},
            
            success: function(data){
                $('.show_city').html(data);
            }
        })

        $.ajax ({
            url: '/get_code',
            type: 'POST',
            data: {'country_id': country_id},
            
            success: function(data){
                $('.show_code').html(data);
            }
        })
    })
</script>

{{-- === Leave Page Alert === --}}
<script>
    $(window).on("beforeunload", function() {
        return "";
    });

    $(document).ready(function() {
        $("#checkout_billing").on("submit", function(e) {
            $(window).off("beforeunload");
            return true;
        });
        $("#del_charge").on("click", function() {
            $(window).off("beforeunload");
            return true;
        });
    });
</script>

{{-- === Order Btn Pre Load === --}}
<script>
    $(document).ready(function () {
        $("#order_btn").click(function () {
            $("#loader").show();
        });
    });
</script>
@endsection
