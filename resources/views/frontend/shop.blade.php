@extends('layouts.master')



@section('content')
<!-- ======================= Shop Style 1 ======================== -->
<section class="bg-cover" style="background:url({{asset('assets/img/banner-2.png')}}) no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-5 mt-3 mb-3">
                    <h1 class="ft-medium mb-3">Shop</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Shop Style 1 ======================== -->


<!-- ======================= Filter Wrap Style 1 ======================== -->
<section class="py-3 br-bottom br-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home_page')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shop Page</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ============================= Filter Wrap ============================== -->


<!-- ======================= All Product List ======================== -->
<section class="middle">
    <div class="container">
        <div class="row">
            
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
                <div class="search-sidebar sm-sidebar border">
                    <div class="search-sidebar-body">

                        <!-- Price -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                <div class="row">
                                    <div class="col-lg-6 pr-1">
                                        <div class="form-group pl-3">
                                            <input type="number" class="form-control" placeholder="Min">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pl-1">
                                        <div class="form-group pr-3">
                                            <input type="number" class="form-control" placeholder="Max">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group px-3">
                                            <button type="submit" class="btn form-control">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#Categories" data-toggle="collapse" aria-expanded="false" role="button">Categories</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="Categories" data-parent="#Categories">
                                <div class="side-list no-border">
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    @foreach ($cate_all as $cate)
                                                        @php
                                                            $cate_products = App\models\Product_list::where('cata_id', $cate->id)->count();
                                                        @endphp

                                                        <li>
                                                            <input id="category{{$cate->id}}" class="checkbox-custom" name="category" type="radio">
                                                            <label for="category{{$cate->id}}" class="checkbox-custom-label">{{$cate->cata_name}}<span>{{$cate_products}}</span></label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Brands Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    <li>
                                                        <input id="brands1" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands1" class="checkbox-custom-label">Sumsung<span>142</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands2" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands2" class="checkbox-custom-label">Apple<span>652</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands3" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands3" class="checkbox-custom-label">Nike<span>232</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands4" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands4" class="checkbox-custom-label">Reebok<span>192</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands5" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands5" class="checkbox-custom-label">Hawai<span>265</span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colors -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Colors</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                                <div class="side-list no-border">
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left">
                                                @foreach ($color_all as $color)
                                                    <div class="form-check form-option form-check-inline mb-1">
                                                        <input class="form-check-input" type="radio" name="colora8" id="whitea{{$color->id}}" value="{{$color->id}}">
                                                        <label class="form-option-label rounded-circle" for="whitea{{$color->id}}" style="background: {{$color->color_code}}" title="{{$color->color_name}}"><span class="form-option-color rounded-circle"></span></label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sizes -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Size</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left pb-0 pt-2">
                                                @foreach ($size_type as $type)
                                                    @if ($type->size_type == 'General')
                                                        @php
                                                            $size_items = App\models\Size::where('size_type', $type->size_type)->get()
                                                        @endphp
                                                    @else
                                                        @php
                                                            $size_items = App\models\Size::where('size_type', $type->size_type)->orderBy('size')->get()
                                                        @endphp
                                                    @endif
                                                    
                                                    @foreach ($size_items as  $size)
                                                        @php
                                                            $size_avail = App\Models\Inventory::where('size', $size->id)
                                                        @endphp

                                                        @if ($size_avail->exists())
                                                            <div class="form-check form-option form-check-inline mb-2">
                                                                <input class="form-check-input" type="radio" name="sizes" id="siz{{$size->id}}">
                                                                <label class="form-option-label" for="siz{{$size->id}}">{{$size->size}}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border mb-3 mfliud">
                            <div class="row align-items-center py-2 m-0">
                                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                                    <h6 class="mb-0">Searched Products Found</h6>
                                </div>
                                
                                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple">
                                              <option value="1" selected="">Default Sorting</option>
                                              <option value="2">Sort by price: Low price</option>
                                              <option value="3">Sort by price: Hight price</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- row -->
                <div class="row align-items-center rows-products">
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/12.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Formal Men Lowers</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$129</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/13.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Half Running Suit</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$99</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-warning text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/14.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Half Fancy Lady Dress</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$150</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/1.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Half Running Set</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$220</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/2.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Formal Men Lowers</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$50</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/3.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Half Running Suit</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$120</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-warning text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/4.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Half Fancy Lady Dress</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$199</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/5.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Flix Flox Jeans</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$150</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-danger text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html"><img class="card-img-top" src="{{asset('assets/img/product/6.jpg')}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">
                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">Fancy Salwar Suits</a></h5>
                                    <div class="elis_rty"><span class="ft-bold text-dark fs-sm">$235</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- row -->
            </div>
        </div>
    </div>
</section>
<!-- ======================= All Product List ======================== -->
@endsection



@section('footer_script')
    
{{-- === Master Search === --}}
<script>
    $('#master_search').click(function(){
        var master_inp = $('#master_inp').val();
        // var cate_id = $('input[class="cate_box"]:checked').attr('value');
        // var brand_id = $('input[class="brand_box"]:checked').attr('value');
        // var min_price = $('.min_price').val();
        // var max_price = $('.max_price').val();
        // var sorting = $('.sorting').val();
        // var showing = $('.showing').val();

        // var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&sort=" + sorting + "&show=" + showing;
        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp;
        window.location.href = search_link;
    });
</script>
@endsection