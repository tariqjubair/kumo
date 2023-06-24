@extends('layouts.master')



@section('header_css')
<style>
    .size_part .form-option-label {
    height: auto;
    }

    .clear_box {
        justify-content: end;
    }

    .filter_wraps {
        justify-content: end;
    }

    .filter_wraps a {
        height: 37px !important;
        width: 100px;
    }

    @media(min-width: 768px) and (max-width: 991.98px){
        
        .filter_wraps {
            justify-content: start;
        }
            
    }

    @media (max-width: 1199.98px){
        
        .clear_box {
            justify-content: start;
            margin-top: 5px;
            margin-bottom: 5px !important;
        }
            
    }
</style>
@endsection



@section('content')
<!-- ======================= Shop Style 1 ======================== -->
<section class="bg-cover" style="background:url({{asset('assets/img/banner-2.png')}}) no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-5 mt-3 mb-3">
                    <h1 class="ft-medium mb-3" id={{@$_GET['chk'] ?'crump' :''}}>Shop</h1>
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
            
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 p-xl-0">
                <div class="search-sidebar sm-sidebar border">
                    <div class="search-sidebar-body">

                        <!-- Price -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                <div class="row">
                                    <div class="col-lg-6 col-6 pr-1">
                                        <div class="form-group pl-3">
                                            <input type="number" class="form-control min_price" placeholder="Min" value="{{@$_GET['min'] ?$_GET['min'] :''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6 pl-1">
                                        <div class="form-group pr-3">
                                            <input type="number" class="form-control max_price" placeholder="Max" value="{{@$_GET['max'] ?$_GET['max'] :''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group px-3">
                                            <button type="submit" class="btn form-control price_box">Submit</button>
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
                                                <select class="custom-select simple cate_box" name="show">
                                                    <option value=""> -- Select --</option>
                                                    @foreach ($cate_all as $cate)
                                                        <option {{@$_GET['cate'] == $cate->id ?'selected' :''}} value="{{$cate->id}}">{{$cate->cata_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-Categories -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#Subcategories" data-toggle="collapse" aria-expanded="false" role="button">Sub-Categories</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="Subcategories" data-parent="#subcategories">
                                <div class="side-list no-border">
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">

                                                @if (@$_GET['cate'] && @$_GET['cate'] != '' && @$_GET['cate'] != 'undefined')
                                                    <ul class="no-ul-list">
                                                        @foreach ($subcate_all->where('cata_id', @$_GET['cate']) as $subcate)
                                                            @php
                                                                $subcate_products = App\models\Product_list::where('subcata_id', $subcate->id)->count();
                                                            @endphp

                                                            <li>
                                                                <input {{@$_GET['subcate'] == $subcate->id ?'checked' :''}} id="subcate{{$subcate->id}}" class="checkbox-custom subcate_box" name="subcate" type="radio" value="{{$subcate->id}}">
                                                                <label for="subcate{{$subcate->id}}" class="checkbox-custom-label">{{$subcate->sub_cata_name}}<span>{{$subcate_products}}</span></label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <select class="custom-select simple cate_box" name="show">
                                                        <option> -- -- Select Category -- -- </option>
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colors -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#colors" data-toggle="collapse" class="{{@$_GET['subcate'] && @$_GET['subcate'] != '' && @$_GET['subcate'] != 'undefined' || @$_GET['col'] && @$_GET['col'] != '' && @$_GET['col'] != 'undefined' ?'' :'collapsed'}}" aria-expanded="false" role="button">Colors</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse {{@$_GET['subcate'] && @$_GET['subcate'] != '' && @$_GET['subcate'] != 'undefined' || @$_GET['col'] && @$_GET['col'] != '' && @$_GET['col'] != 'undefined' ?'show' :''}}" id="colors" data-parent="#colors">
                                <div class="side-list no-border">
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left">

                                                @if (@$_GET['subcate'] && @$_GET['subcate'] != '' && @$_GET['subcate'] != 'undefined')
                                                    @php
                                                        $store = '';
                                                    @endphp

                                                    @foreach ($color_all as $sl=>$color)
                                                        @php
                                                            $cate_products = App\Models\Product_list::where('subcata_id', @$_GET['subcate'])->get();
                                                        @endphp

                                                        @foreach ($cate_products as $key=>$item)
                                                            @php
                                                                $color_check = App\Models\Inventory::where('product_id', $item->id)->where('color', $color->id);
                                                            @endphp

                                                            @if ($color_check->first() && $store != $color->id)
                                                                {{-- {{$sl.'|'.$key}}=>{{$color->id}} --}}
                                                                <div class="form-check form-option form-check-inline mb-1">
                                                                    <input {{@$_GET['col'] == $color->id ?'checked' :''}}
                                                                    class="form-check-input color_box" type="radio" name="color" id="whitea{{$color->id}}" value="{{$color->id}}">
                                                                    <label class="form-option-label rounded-circle" for="whitea{{$color->id}}" title="{{$color->color_name}}"><span class="form-option-color rounded-circle" style="background: {{$color->color_code}}"></span></label>
                                                                </div>

                                                                @php
                                                                    $store = $color->id;
                                                                @endphp
                                                                {{-- {{$store}} --}}
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    @foreach ($color_all as $color)
                                                        <div class="form-check form-option form-check-inline mb-1">
                                                            <input {{@$_GET['col'] == $color->id ?'checked' :''}}
                                                            class="form-check-input color_box" type="radio" name="color" id="whitea{{$color->id}}" value="{{$color->id}}">
                                                            <label class="form-option-label rounded-circle" for="whitea{{$color->id}}" title="{{$color->color_name}}"><span class="form-option-color rounded-circle" style="background: {{$color->color_code}}"></span></label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sizes -->
                        <div class="single_search_boxed size_part">
                            <div class="widget-boxed-header">
                                <h4><a href="#size" data-toggle="collapse" class="{{(@$_GET['subcate'] && @$_GET['subcate'] != '' && @$_GET['subcate'] != 'undefined') || (@$_GET['siz'] && @$_GET['siz'] != '' && @$_GET['siz'] != 'undefined') ?'' :'collapsed'}}" aria-expanded="false" role="button">Size</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse {{@$_GET['subcate'] && @$_GET['subcate'] != '' && @$_GET['subcate'] != 'undefined' || @$_GET['siz'] && @$_GET['siz'] != '' && @$_GET['siz'] != 'undefined' ?'show' :''}}" id="size" data-parent="#size">
                                <div class="side-list no-border">
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left pb-0 pt-2">

                                                @if (@$_GET['subcate'] && @$_GET['subcate'] != '' && @$_GET['subcate'] != 'undefined')
                                                    @php
                                                        $store = '';
                                                    @endphp

                                                    @foreach ($size_all as $sl=>$size)
                                                        @php
                                                            $cate_products = App\Models\Product_list::where('subcata_id', @$_GET['subcate'])->get();
                                                        @endphp

                                                        @foreach ($cate_products as $key=>$item)
                                                            @php
                                                                $size_check = App\Models\Inventory::where('product_id', $item->id)->where('size', $size->id);
                                                            @endphp

                                                            @if ($size_check->first() && $store != $size->id)
                                                                {{-- {{$sl.'|'.$key}}=>{{$color->id}} --}}
                                                                <div class="form-check form-option form-check-inline mb-2">
                                                                    <input {{@$_GET['siz'] == $size->id ?'checked' :''}}
                                                                    class="form-check-input size_box" type="radio" name="size" id="siz{{$size->id}}" value="{{$size->id}}">
                                                                    <label class="form-option-label" for="siz{{$size->id}}">{{$size->size}}</label>
                                                                </div>

                                                                @php
                                                                    $store = $size->id;
                                                                @endphp
                                                                {{-- {{$store}} --}}
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @else
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
                                                                    <input {{@$_GET['siz'] == $size->id ?'checked' :''}}
                                                                    class="form-check-input size_box" type="radio" name="size" id="siz{{$size->id}}" value="{{$size->id}}">
                                                                    <label class="form-option-label" for="siz{{$size->id}}">{{$size->size}}</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endif
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
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    @foreach ($brand_all as $brand)
                                                        @php
                                                            $brand_products = App\models\Product_list::where('brand', $brand->brand)->count();
                                                        @endphp

                                                        <li>
                                                            <input {{@$_GET['brand'] == $brand->brand ?'checked' :''}}
                                                            id="brand{{$brand->id}}" class="checkbox-custom brand_box" name="brands" type="radio" value="{{$brand->brand}}">
                                                            <label for="brand{{$brand->id}}" class="checkbox-custom-label">{{$brand->brand}}<span>{{$brand_products}}</span></label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-8 col-md-6 col-sm-12">

                {{-- === Search Top === --}}
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border mb-3 mfliud">
                            <div class="row align-items-center py-2 m-0">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                    <h6 class="mb-0" style="padding: 8px 0 8px 0;">Items Found: <span style="font-weight: 600">{{$store_items->total()}}</span></h6>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple show_box" name="show">
                                                <option {{@$_GET['show'] == 1 ?'selected' :''}} value="1">Showing ( 9 )</option>
                                                <option {{@$_GET['show'] == 2 ?'selected' :''}} value="2">Showing ( 20 )</option>
                                                <option {{@$_GET['show'] == 3 ?'selected' :''}} value="3">Showing ( 50 )</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple sort_box">
                                              <option {{@$_GET['sort'] == 1 ?'selected' :''}} value="1">Default Sorting (Latest)</option>
                                              <option {{@$_GET['sort'] == 2 ?'selected' :''}} value="2">Sort by Name: A-Z</option>
                                              <option {{@$_GET['sort'] == 3 ?'selected' :''}} value="3">Sory by Name: Z-A</option>
                                              <option {{@$_GET['sort'] == 4 ?'selected' :''}} value="4">Sort by price: Low price</option>
                                              <option {{@$_GET['sort'] == 5 ?'selected' :''}} value="5">Sort by price: High price</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-12 col-md-4 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center m-start clear_box">
                                        <div class="single_fitres br-right">
                                            <a href="{{route('shop_page')}}" class="btn btn-block custom-height bg-dark">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- === Product Items === --}}
                <div class="row align-items-center rows-products">
                    @forelse ($store_items as $product)
                        <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                            <div class="product_grid card">
                                @if ($product->discount != 0)
                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                    <div class="badge bg-danger text-white position-absolute ft-regular ab-right text-upper">-{{$product->discount}}%</div>
                                @endif
        
                                {{-- === New Arrival === --}}
                                @foreach (App\Models\Inventory::where('product_id', $product->id)->get() as $inv_upd)
                                    @if($inv_upd->created_at != null && Carbon\carbon::now()->diffInDays($inv_upd->created_at) < 30)
                                        <div class="badge text-white position-absolute ft-regular ab-right text-upper" style="top: 62%; background: rgba(0, 0, 0, 0.5); border: 1px solid whitesmoke">New Arrival!</div>
                                    @endif
                                @endforeach
        
                                {{-- === Out of Stock === --}}
                                @php
                                    $total_qty = 0;
                                @endphp
        
                                @foreach (App\Models\Inventory::where('product_id', $product->id)->get() as $inv_upd)
                                    @php
                                        $total_qty += $inv_upd->quantity;
                                    @endphp
                                @endforeach
                                
                                @if($total_qty == 0)
                                    <div class="badge position-absolute ft-regular ab-right text-upper" style="top: 62%; background: rgba(255, 0, 0, 0.8); border: 1px solid whitesmoke">Out of Stock!</div>
                                @endif
        
                                {{-- === Wish Button === --}}
                                <form action="" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
        
                                    @if (App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $product->id)->count() >= 1)
                                        <a class="wish_btn_home_clk position-absolute ft-regular ab-left text-upper" style="top: 60%; background: rgba(0, 0, 0, 0.5); border: none" href="{{route('wishlist.remove.btn', $product->id)}}" ><i class="fas fa-heart clicked"></i></a>
                                    @else
                                        <button class="wish_btn_home position-absolute ft-regular ab-left text-upper" style="top: 60%; background: rgba(0, 0, 0, 0.5); border: none" formaction="{{route('wishlist.store')}}" ><i class="fas fa-heart"></i></button>
                                    @endif
                                </form>
        
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $product->slug)}}"><img class="card-img-top" style="object-fit: scale-down;" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt="Product Preview"></a>
                                    </div>
                                </div>
                                <div class="card-footer p-2 bg-white d-flex align-items-start justify-content-between">
                                    <div class="text-left">
                                        <div class="text-left">
                                            @php
                                                $avg_star = App\Models\OrdereditemsTab::where('product_id', $product->id)->avg('star');
                                            @endphp
        
                                            <div class="elso_titl"><span class="small">{{$product->relto_cata->cata_name}}</span></div>
                                            <h5 class="fs-md mb-0 lh-1 mb-1"><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h5>
                                            <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                                @for ($i = 1; $i <= $avg_star; $i ++)
                                                    <i class="fas fa-star filled"></i>
        
                                                    @if ($avg_star - $i < 1 && $avg_star - $i > 0)
                                                        <i class="fad fa-star-half" style="--fa-secondary-opacity: 1.0; --fa-primary-color: #FF9800; --fa-secondary-color: #D6DDE6;"></i>
                                                    @endif
                                                @endfor
        
                                                @for ($i = 1; $i <= 5-$avg_star; $i ++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
        
                                                <span class="small">({{App\Models\OrdereditemsTab::where('product_id', $product->id)->whereNotNull('review')->count()}})</span>
                                            </div>
                                            @if ($product->discount != 0)
                                                <span class="ft-medium text-muted line-through fs-md mr-2">{{$product->price}}</span>
                                                <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->after_disc)}}&#2547;</span>
                                            @else
                                                <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->price)}}&#2547;</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="item_div text-center">
                                <img src="{{asset('assets/img/no_product_found.gif')}}" width="50%" alt="No Product Found">
                                <h4 style="text-align: center; font-weight: 400; padding: 30px;">'Oops! Item not found!'</h4>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{$store_items->withQueryString()->links()}}
            </div>
        </div>
    </div>
</section>
<!-- ======================= All Product List ======================== -->
@endsection



@section('footer_script')
    
{{-- === Master Search === --}}
<script>
    $('.cate_box').change(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = '';
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = '';
        var size_id = '';
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.subcate_box').click(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = $('input[name="color"]:checked').val();
        var size_id = $('input[name="size"]:checked').val();
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.brand_box').click(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = $('input[name="color"]:checked').val();
        var size_id = $('input[name="size"]:checked').val();
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.color_box').click(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = $('input[name="color"]:checked').val();
        var size_id = '';
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.size_box').click(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = '';
        var size_id = $('input[name="size"]:checked').val();
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.show_box').change(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = $('input[name="color"]:checked').val();
        var size_id = $('input[name="size"]:checked').val();
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.sort_box').change(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = $('input[name="color"]:checked').val();
        var size_id = $('input[name="size"]:checked').val();
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });

    $('.price_box').click(function(){
        var master_inp = $('#master_inp').val();
        var cate_id = $('.cate_box').val();
        var subcate_id = $('input[name="subcate"]:checked').val();
        var brand_id = $('input[name="brands"]:checked').val();
        var min_price = $('.min_price').val();
        var max_price = $('.max_price').val();
        var color_id = $('input[name="color"]:checked').val();
        var size_id = $('input[name="size"]:checked').val();
        var sort = $('.sort_box').val();
        var show = $('.show_box').val();

        var search_link = "{{route('shop_page')}}" + "?inp=" + master_inp + "&cate=" + cate_id + "&subcate=" + subcate_id + "&brand=" + brand_id + "&min=" + min_price + "&max=" + max_price + "&col=" + color_id + "&siz=" + size_id + "&sort=" + sort + "&show=" + show + "&chk=" + 'qry';
        window.location.href = search_link;
    });
</script>

{{-- === Scroll while Query string === --}}
<script>
    $(document).ready(function () {
        $('html, body').animate({
            scrollTop: $('#crump').offset().top
        }, 'fast');
    });
</script>
@endsection