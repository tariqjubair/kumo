@extends('layouts.master')



@section('header_css')
<style>
.coupon-card{
    background: linear-gradient(135deg, #7158fe, #9d4de6);
    color: #fff;
    text-align: center;
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 10px 0 rgba(0,0,0,0.15);
    position: relative;
    min-height: 300px;
    transition: .5s;
    margin-bottom: 30px;
}
.coupon-card:hover {
    box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.521);
}
.logo_ext{
    width: 80px;
    border-radius: 5px;
    margin-bottom: 18px;
    background: #fff;
    padding: 8px;
}
.coupon-card h3{
    font-size: 20px;
    font-weight: 400;
    line-height: 26px;
    width: 160px;
    margin: 0 auto;
    height: 125px;

}
.coupon-card p{
    font-size: 15px;

}
.coupon-row{
    display: flex;
    align-items: center;
    margin: 15px auto;
    width: fit-content;

}
input.cpnCode{
    border: 1px dashed #fff;
    padding: 8px 0;
    width: 125px;
    border-right: 0;
    text-transform: uppercase;
    background: transparent;
    text-align: center;
    color: white;
    font-family: 'poppins', sans-serif;
}
.cpnBtn{
    border: 1px solid #fff;
    background: rgba(0, 0, 0, 0.63);
    padding: 8px 0;
    color: whitesmoke;
    cursor: pointer;
    width: 75px;
    /* font-family: 'poppins', sans-serif; */
    
}
.circle1, .circle2{
    background: #f0fff3;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);

}
.circle1{
    left: -25px;
}
.circle2{
    right: -25px;
}
.btn {
    font-weight: 400;
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
                        <li class="breadcrumb-item active" aria-current="page">Coupons</li>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Discount Vouchers</h2>
                    <h3 class="ft-bold pt-3">Active Coupons</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach ($coupon_all as $coupon)
                @if ($coupon->validity >= Carbon\carbon::now())
                    @php
                        $color1 = App\Models\CoupType::where('id', $coupon->type)->first()->color;
                    @endphp
                        
                    <div class="col-xl-3 col-sm-6">
                        <div class="coupon-card" style="background: {{$coupon->type == 2 ?'linear-gradient(135deg, #7158fe, #9d4de6)' :'linear-gradient(135deg, #FCE77E, #FA6166)'}};">
                            <img src="{{asset('assets/img/logo_lg.png')}}" class="logo_ext">
                            @if ($coupon->type == 2)
                                <h3><span> Fixed {{number_format($coupon->discount)}} &#2547;</span><br>flat off on {{$coupon->subcata ?'selective items' :'all items'}} in
                                {{$coupon->min_total ?' Min '.number_format($coupon->min_total).' purchase' :'any amount!'}}</h3>
                            @else
                                <h3>{{$coupon->discount.'%'}} off upto <br> {{number_format($coupon->least_disc)}} - {{number_format($coupon->most_disc)}} &#2547; on {{$coupon->subcata ?'selective items' :'all items'}} in {{$coupon->min_total ?' Min '.number_format($coupon->min_total).' purchase' :'any amount!'}}</h3>
                            @endif
                            <div class="coupon-row">
                                <input type="text" id="item_{{$coupon->coupon_name}}" class="cpnCode" value="{{$coupon->coupon_name}}">
                                <button class="cpnBtn" onclick="copyToClipboard('item_{{$coupon->coupon_name}}')">Copy</button>
                            </div>
                            <p class="mb-0">Valid Till: {{date('d-M-y', strtotime($coupon->validity))}}</p>
                            <div class="circle1"></div>
                            <div class="circle2"></div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        
    </div>
</section>
@endsection



@section('footer_script')

{{-- === Copy to Clipboard === --}}
<script>
    function copyToClipboard(id) {
        document.getElementById(id).select();
        document.execCommand('copy');
    }

    $('.cpnBtn').click(function(){
        $(this).html("Copied!")
    })
</script>
@endsection