@extends('layouts.master')



@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home_page')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
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
                    <h2 class="off_title">General Questions</h2>
                    <h3 class="ft-bold pt-3">Common FAQ's</h3>
                </div>
            </div>
        </div>

        <div class="item mt-3">
            <div class="row">
                @foreach ($faq_all as $faq)
                    <div class="col-xl-6 mb-4">
                        <div class="part">
                            <h6 class="mb-3 text-primary"><i class="far fa-paper-plane text-primary pe-2"></i> {{$faq->question}}</h6>
                            <p>
                                {{$faq->answer}}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

