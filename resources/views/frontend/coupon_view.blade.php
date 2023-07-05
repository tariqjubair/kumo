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
}
.logo_ext{
    width: 60px;
    border-radius: 5px;
    margin-bottom: 18px;
    background: #fff;
}
.coupon-card h3{
    font-size: 20px;
    font-weight: 400;
    line-height: 26px;
    width: 150px;
    margin: 0 auto;

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
#cpnCode{
    border: 1px dashed #fff;
    padding: 8px 18px;
    border-right: 0;

}
#cpnBtn{
    border: 1px solid #fff;
    background: #fff;
    padding: 8px 0;
    color: #7158fe;
    cursor: pointer;
    width: 75px;
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
            @foreach ($coupon_all as $coupon)
            @php
                $color1 = App\Models\CoupType::where('id', $coupon->type)->first()->color;
                $color2 = '#7158fe';
            @endphp
                
            <div class="col-xl-3">
                <div class="coupon-card">
                    <img src="{{asset('assets/img/logo_lg.png')}}" class="logo_ext">
                    <h3>20% flat off on all rides <br>using HDFC Card</h3>
                    <div class="coupon-row">
                        <span id="cpnCode">STEALDEAL20</span>
                        <span id="cpnBtn" class="{{$coupon->type == 2 ?'text-danger' :''}}">Copy</span>
                    </div>
                    <p class="mb-0">Valid Till: 20Dec, 2021</p>
                    <div class="circle1"></div>
                    <div class="circle2"></div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</section>
@endsection



@section('footer_script')
<script>
    var cpnBtn = document.getElementById("cpnBtn");
    var cpnCode = document.getElementById("cpnCode");

    cpnBtn.onclick = function(){
        navigator.clipboard.writeText(cpnCode.innerHTML);
        cpnBtn.innerHTML ="COPIED";
        setTimeout(function(){
            cpnBtn.innerHTML="COPY";
        }, 3000);
    }
</script>
@endsection