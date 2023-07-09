@extends('layouts.master')



@section('meta')
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['desc'] }}">
@endsection



@section('header_css')
<style>
    .quick_view_slide .slick-dots {
        bottom: 0;
    }

    .star-rating i {
        font-size: 11px;
    }

    .all_rev {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80vw;
        height: 60vh;
        z-index: 999;
        padding: 20px 10px 20px 20px;
        opacity: 0;
        visibility: hidden;
        transition: .3s
    }

    .all_rev .reviews_info {
        height: 100%;
        overflow-y: scroll; 
    }

    .all_rev .close_link {
        position: absolute;
        right: 55px;
    }

    div#social-links {
        margin: 0;
        max-width: 500px;
        display: inline-block;
    }
    div#social-links ul {
        padding: 0;
    }
    div#social-links ul li {
        display: inline-block;
    }          
    div#social-links ul li a {
        padding: 6px 12px;
        /* border: 1px solid #ccc; */
        border-radius: 5px;
        margin: 5px;
        font-size: 18px;
        color: #636872;
        background-color: #f4f5f7;
    }

    @media(min-width: 992px){
    
        .all_rev {
            width: 700px !important;
            padding: 30px 25px 30px 30px !important;
        }
            
    }

    @media(max-width: 767px){
        
        .single_rev_thumb {
            width: 45px;
        }
        .single_rev_thumb img {
            width: 100%;
        }
            
    }

    @media(max-width: 991px){

        .prd_details {
            margin-top: 20px !important;
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
                        <li class="breadcrumb-item active" aria-current="page">Product Details</li>
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
                    <h2 class="off_title">Item Description</h2>
                    <h3 class="ft-bold pt-3">Product Details</h3>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-between">

            {{-- === Thumbnail Slider === --}}
            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="quick_view_slide" style="border: 1px solid rgba(128, 134, 134, 0.527)">
                    @foreach ($thumbnail as $thumb)
                        <div class="single_view_slide"><a href="" data-lightbox="roadtrip" class="d-block mb-4"><img src="{{asset('uploads/product/thumbnails')}}/{{$thumb->thumbnail}}" class="img-fluid rounded" style="object-fit: scale-down" alt="Product Thumbnails"></a></div>
                    @endforeach
                </div>
            </div>

            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="prd_details pl-3">
                    
                    <div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">{{$product_info->relto_cata->cata_name}}</span></div>
                    <div class="prt_02 mb-3">
                        <h2 class="ft-bold mb-1">{{$product_info->product_name}}</h2>
                        <div class="text-left">
                            @php
                                $avg_star = App\Models\OrdereditemsTab::where('product_id', $product_info->id)->avg('star');
                            @endphp

                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                @for ($i = 1; $i <= $avg_star; $i ++)
                                    <i class="fas fa-star filled"></i>

                                    @if ($avg_star - $i < 1 && $avg_star - $i > 0)
                                        <i class="fad fa-star-half" style="--fa-secondary-opacity: 1.0; --fa-primary-color: #FF9800; --fa-secondary-color: #D6DDE6;"></i>
                                    @endif
                                @endfor

                                @for ($i = 1; $i <= 5-$avg_star; $i ++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                
                                <span class="small">({{App\Models\OrdereditemsTab::where('product_id', $product_info->id)->whereNotNull('review')->count()}} Reviews)</span>
                            </div>
                            @if ($product_info->discount != 0)
                                <span class="ft-medium text-muted line-through fs-md mr-2">{{$product_info->price}}</span>
                                <span class="ft-bold theme-cl fs-lg mr-2">{{number_format($product_info->after_disc)}}&#2547;</span>
                            @else
                                <span class="ft-bold theme-cl fs-lg mr-2">{{number_format($product_info->price)}}&#2547;</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="prt_03 mb-4">
                        <p>{{$product_info->short_desc}}</p>
                    </div>
                    
                    <form action="{{route('cart.store')}}" method="POST">
                        @csrf
                        <input type="text" name="product_id" hidden value="{{$product_info->id}}">

                        {{-- === Product Colors === --}}
                        <div class="prt_04 mb-2">
                            <p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
                            <div class="text-left">
                                @foreach ($color_info as $color)

                                    @if ($color->color != 1)
                                        <div class="form-check form-option form-check-inline mb-1">
                                            <input {{$color->color == old('prod_color') ?'checked' :''}}
                                            class="form-check-input color_sec" type="radio" name="prod_color" id="col{{$color->color}}" 
                                            value="{{old('prod_color') != null ?old('prod_color') :$color->color}}">
                                            {{-- {{$color->color}} --}}
                                            <label class="form-option-label rounded-circle" for="col{{$color->color}}"><span class="form-option-color rounded-circle" style="background: {{$color->relto_color->color_code}}"></span></label>
                                            {{-- {{old('prod_color')}} --}}
                                        </div>
                                    @else
                                        <div class="form-check size-option form-option form-check-inline mb-2">
                                            <input class="form-check-input color_sec" type="radio" name="prod_color" value="{{$color->color}}" id="col{{$color->color}}" checked>
                                            <label class="form-option-label" for="col{{$color->color}}">N/A</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('prod_color')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        
                        {{-- === Product Size === --}}
                        <div class="prt_04 mb-4">
                            <p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
                            <div class="text-left pb-0 pt-2 size_sec">
                                @foreach ($size_info as $size)
                                    @if ($size->size != 17)
                                        <div class="form-check size-option form-option form-check-inline mb-2 sp_size_div">
                                            @php
                                                $new_size = App\Models\Inventory::where('product_id', $product_info->id)->where('color', old('prod_color'))->where('size', $size->size)->get();
                                            @endphp
                                            
                                            @if (old('prod_color'))
                                                @foreach ($new_size as $newz)
                                                    @if ($newz != null)
                                                        <input {{$newz->size == old('prod_size') ?'checked' :''}}
                                                         class="form-check-input size_inp" type="radio" 
                                                        value="{{$size->size}}" 
                                                        name="prod_size" id="siz{{$size->size}}">
                                                        {{-- {{$size->size}} --}}
                                                        <label class="form-option-label" for="siz{{$size->size}}">{{$size->relto_size->size}}</label>
                                                    @endif
                                                @endforeach
                                            @else
                                                <input class="form-check-input" type="radio" 
                                                value="{{$size->size}}" 
                                                name="prod_size" id="siz{{$size->size}}">
                                                {{-- {{$size->size}} --}}
                                                <label class="form-option-label" for="siz{{$size->size}}">{{$size->relto_size->size}}</label>
                                            @endif
                                            
                                            {{-- @foreach ($new_size as $newz)
                                                @if ($newz != null)
                                                    {{$newz->size}}
                                                @endif
                                            @endforeach --}}
                                        </div>
                                    @else
                                        <div class="form-check size-option form-option form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="prod_size" value="{{$size->size}}" id="siz{{$size->size}}" checked>
                                            <label class="form-option-label" for="siz{{$size->size}}">{{$size->relto_size->size}}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('prod_size')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                        {{-- <input type="hidden" name="qty_output" id="quantity_op"> --}}
                        
                        <div class="prt_05 mb-4">
                            <div class="form-row mb-7">

                                <!-- Quantity -->
                                <div class="col-12 col-sm-2 col-md-2 col-lg-auto">
                                    @php
                                        $sizeless = App\Models\Inventory::where('product_id', $product_info->id)->where('color', 1)->where('size', 17)->get()->first();
                                    @endphp

                                    @if ($sizeless != '')
                                        <select class="mb-2 custom-select qty_sec" name="quantity">
                                            @for ($i=1; $i <= $sizeless->quantity; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    @else
                                        <select class="mb-2 custom-select qty_sec" name="quantity">
                                            <option value=""></option>
                                        </select>
                                    @endif
                                </div>

                                <!-- Submit -->
                                <div class="col-12 col-sm-5 col-md-5 col-lg">
                                    <button type="submit" class="btn btn-block custom-height bg-dark mb-2">
                                        <i class="lni lni-shopping-basket mr-2"></i>Add to Cart 
                                    </button>
                                </div>

                                {{-- === Wish Button === --}}
                                @if(App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $product_info->id)->count() >= 1)
                                    <div class="col-12 col-sm-5 col-md-5 col-lg-auto">

                                        <!-- Remove Wishlist -->
                                        <a class="btn custom-height btn-block mb-2 text-white" 
                                        href="{{route('wishlist.remove.btn', $product_info->id)}}" 
                                        style="background: green !important" id="rem_wish">
                                            <i class="lni lni-heart mr-2"></i>Remove from Wishlist
                                        </a>
                                    </div>
                                @else
                                    <div class="col-12 col-sm-5 col-md-5 col-lg-auto">
                                        
                                        <!-- Wishlist -->
                                        <button class="btn custom-height btn-default btn-block mb-2 text-dark" 
                                        formaction="{{route('wishlist.store')}}" 
                                        style="border: 1px solid black" name="wish_btn" id="add_wish">
                                            <i class="lni lni-heart mr-2"></i>Add to Wishlist
                                        </button>
                                    </div>
                                @endif
                            </div>
                            @error('quantity')
                                <strong class="text-danger" style="font-size: 18px">{{$message}}</strong>
                            @enderror
                        </div>
                    </form>
                    
                    <div class="prt_06">
                        <p class="mb-0 d-inline-block">
                          <span class="mr-4">Share:</span>
                          {!! $shareComponent !!}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->

<!-- ======================= Product Description ======================= -->
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <!-- Description Content -->
                    <div class="tab-pane fade {{session('rev_error') ?'' :'show active'}}" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="description_info">
                            <p class="p-0 mb-2">{!!$product_info->long_desc!!}</p>
                        </div>
                    </div>
                    
                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="additionals">
                            <table class="table">
                                <tbody>
                                    <tr>
                                      <th class="ft-medium text-dark">ID</th>
                                      <td>#1253458</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">SKU</th>
                                      <td>KUM125896</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">Color</th>
                                      <td>Sky Blue</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">Size</th>
                                      <td>Xl, 42</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">Weight</th>
                                      <td>450 Gr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Reviews Content -->
                    <div class="tab-pane fade {{session('rev_error') ?'show active' :''}}" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews_info">

                            @forelse (App\Models\OrdereditemsTab::where('product_id', $product_info->id)->whereNotNull('review')->orderBy('star', 'desc')->take(3)->get() as $review)
                                <div class="single_rev d-flex align-items-start br-bottom py-3">
                                    <div class="single_rev_thumb">
                                        
                                        @if ($review->relto_cust->prof_pic)
                                            <img src="{{asset('uploads/customer')}}/{{$review->relto_cust->prof_pic}}"
                                            class="img-fluid circle" width="90" alt="Customer" />
                                        @else
                                            <img src="{{asset('assets/img/customer.png')}}" class="img-fluid circle" width="90" alt="" />
                                        @endif
                                    </div>
                                    <div class="single_rev_caption d-flex align-items-start pl-3">
                                        <div class="single_capt_left">
                                            <h5 class="fs-md ft-medium lh-1">{{$review->relto_cust->name}}</h5>
                                            <div class="single_capt_right">
                                                <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                    @for ($i = 1; $i <= $review->star; $i ++)
                                                        <i class="fas fa-star filled"></i>
                                                    @endfor
                                                    @for ($i = 1; $i <= 5-$review->star; $i ++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="small">{{$review->updated_at->isoFormat('DD-MMM-YY')}}</span>
                                            <p style="line-height: 18px; margin: 10px 0;">{{$review->review}}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="item py-5">
                                    <h6>** No Reviews Yet !!</h6>
                                </div>
                            @endforelse

                            @if (App\Models\OrdereditemsTab::where('product_id', $product_info->id)->whereNotNull('review')->count() > 3)
                                <div class="item" style="margin: 15px;">
                                    <button class="btn btn-primary rev_btn">View All</button>
                                </div>
                            @endif
                        </div>
                        
                        {{-- === Submit Review === --}}
                        @php
                            $ordered_product = App\models\OrdereditemsTab::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $product_info->id);
                        @endphp

                        @auth('CustLogin')
                            @if ($ordered_product->doesntExist())
                                <div class="alert alert-info d-flex" style="justify-content: space-between; align-items:center">
                                    <span style="font-size: 16px">Please Purchase the item to leave a Review!</span> 
                                    <a class="btn btn-primary" href="#">Go to Top</a>
                                </div>
                            @elseif ($ordered_product->whereNotNull('review')->first())
                                <div class="alert alert-success d-flex" style="justify-content: space-between; align-items:center">
                                    <span style="font-size: 16px">You have already left a Review!</span> 
                                    <a class="btn btn-primary" href="#">Go to Top</a>
                                </div>
                            @else
                                <div class="reviews_rate mt-3 {{session('rev_error') ?'err' :''}}">
                                    <form class="row" action="{{route('product.review', $product_info->id)}}" method="POST">
                                        @csrf

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <h4>Submit Your Rating:</h4>
                                        </div>
                                        
                                        {{-- === Star === --}}
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                                                <div class="srt_013">
                                                    <div class="submit-rating">
                                                    <input class="star_cls" id="star-5" type="radio" name="rating" value="5" />
                                                    <label for="star-5" title="5 stars">
                                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="star_cls" id="star-4" type="radio" name="rating" value="4" />
                                                    <label for="star-4" title="4 stars">
                                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="star_cls" id="star-3" type="radio" name="rating" value="3" />
                                                    <label for="star-3" title="3 stars">
                                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="star_cls" id="star-2" type="radio" name="rating" value="2" />
                                                    <label for="star-2" title="2 stars">
                                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="star_cls" id="star-1" type="radio" name="rating" value="1" />
                                                    <label for="star-1" title="1 star">
                                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    </div>
                                                </div>
                                                
                                                <div class="srt_014">
                                                    <h6 class="mb-0"><span id="star_show">Click on</span> Star!</h6>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- === Name/Email === --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="medium text-dark ft-medium">Full Name</label>
                                                <input value="{{Auth::guard('CustLogin')->user()->name}}" type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="medium text-dark ft-medium">Email Address</label>
                                                <input value="{{Auth::guard('CustLogin')->user()->email}}" type="email" class="form-control" />
                                            </div>
                                        </div>
                                        
                                        {{-- === Description === --}}
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="medium text-dark ft-medium">Description</label>
                                                <textarea name="review" class="form-control">{{ old('review') }}</textarea>
                                            </div>
                                        </div>
                                        
                                        {{-- === Submit === --}}
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group m-0">
                                                <button class="btn btn-white stretched-link hover-black">Submit Review <i class="lni lni-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning d-flex" style="justify-content: space-between; align-items:center">
                                <span style="font-size: 16px">Please Login to leave a Review!</span> 
                                <a class="btn btn-primary" href="{{route('customer_login')}}">Login Here</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- === Show All Reviews === --}}
        <div class="all_rev" style="background: #fffefb;">
            <div class="close_link">
                <button class="btn btn-primary close_btn rev_close_btn">Close</button>
            </div>

            <div class="reviews_info">
                @foreach (App\Models\OrdereditemsTab::where('product_id', $product_info->id)->whereNotNull('review')->orderBy('star', 'desc')->get() as $review)
                    <div class="single_rev d-flex align-items-start br-bottom py-3">
                        <div class="single_rev_thumb">
                            @if ($review->relto_cust->prof_pic)
                                <img src="{{asset('uploads/customer')}}/{{$review->relto_cust->prof_pic}}"
                                class="circle" width="90" alt="Customer" />
                            @else
                                <img src="{{asset('assets/img/customer.png')}}" class="img-fluid circle" width="90" alt="" />
                            @endif
                        </div>

                        <div class="single_rev_caption d-flex align-items-start pl-3">
                            <div class="single_capt_left">
                                <h5 class="fs-md ft-medium lh-1">{{$review->relto_cust->name}}</h5>
                                <div class="single_capt_right">
                                    <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                        @for ($i = 1; $i <= $review->star; $i ++)
                                            <i class="fas fa-star filled"></i>
                                        @endfor
                                        @for ($i = 1; $i <= 5-$review->star; $i ++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="small">{{$review->updated_at->isoFormat('DD-MMM-YY')}}</span>
                                <p style="line-height: 18px; margin: 10px 0;">{{$review->review}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Description End ==================== -->

<!-- ======================= Similar Products Start ============================ -->
<section class="middle pt-0">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Similar Products</h2>
                    <h3 class="ft-bold pt-3">Matching Products</h3>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="slide_items">
                    
                    <!-- single Item -->
                    @foreach ($rel_products as $rel)
                        <div class="single_itesm">
                            <div class="product_grid card mb-0">
                                @if ($rel->discount != 0)
                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                    <div class="badge bg-danger text-white position-absolute ft-regular ab-right text-upper">-{{$rel->discount}}%</div>
                                @endif

                                @if(Carbon\carbon::now()->diffInDays($rel->updated_at) < 7)
                                    <div class="badge text-white position-absolute ft-regular ab-right text-upper" style="top: 68%; background: rgba(0, 0, 0, 0.5); border: 1px solid whitesmoke">New Arrival!</div>
                                @endif

                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $rel->slug)}}"><img class="card-img-top" style="object-fit: scale-down" src="{{asset('uploads/product/preview')}}/{{$rel->preview}}" alt="Product Preview"></a>
                                    </div>
                                </div>
                                <div class="card-footer p-3 pb-0 d-flex align-items-start justify-content-center">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single-v1.html">{{$rel->product_name}}</a></h5>
                                            @if ($rel->discount != 0)
                                                <span class="ft-medium text-muted line-through fs-md mr-2">{{$rel->price}}</span>
                                                <span class="ft-bold theme-cl fs-md mr-2">{{number_format($rel->after_disc)}}&#2547;</span>
                                            @else
                                                <span class="ft-bold theme-cl fs-md mr-2">{{number_format($rel->price)}}&#2547;</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- ======================= Similar Products Start ============================ -->

@endsection

@section('footer_script')

{{-- === Get Size Ajax === --}}
<script>
    $('.color_sec').click(function(){
        var product_id = "{{$product_info->id}}";
        var color_id = $(this).val();

		// Root Ajax setup code
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		// Custom Ajax to send 'cata_id' to Route & controller
		$.ajax ({
			url: '/get_size',
			type: 'POST',
			data: {'product_id': product_id, 'color_id': color_id}, 
			
			//Data Receive from controller
			success: function(data){
				$('.size_sec').html(data);
			}
		})
    })
</script>

{{-- === Remove Empty Size-Div === --}}
@if (old('prod_color'))
<script>
    $(document).ready(function(){
        $(".sp_size_div").not(":has(input)").css("display", "none");
    });
</script>
@endif

{{-- === Quantity Click === --}}
<script>
    $('.size_sec').click(function(){
        var product_id = "{{$product_info->id}}";
        var color_id = $('.color_sec:checked').val();
        var size_id = $('.size_inp:checked').val();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$.ajax ({
			url: '/get_quantity',
			type: 'POST',
			data: {'color_id': color_id, 'size_id': size_id, 'product_id': product_id}, 
			
			success: function(data){
                $('.qty_sec').html(data);
			}
		})
    })
</script>

{{-- === Show Star === --}}
<script>
    $('.star_cls').click(function(){
        var star = $(this).val();

        $('#star_show').html(star);
    })
</script>

{{-- === Review Done Alert === --}}
@if (session('rev_done'))
<script>
    Swal.fire({
        position: 'middle-middle',
        icon: 'success',
        title: 'Your Review is Collected!',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Review Error Alert === --}}
@if (session('rev_error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Review not Completed! No star/msg provided!',
    })
</script>
@endif

{{-- === Scroll to Error === --}}
<script>
    $('.err').show(function(){
        $(document).ready(function(){
            $("html, body").animate({ 
                scrollTop: $('.err').offset().top -400 
            }, 1000);
        });
    })
</script>

{{-- === All Review Opening === --}}
<script>
    $('.rev_btn').click(function(){
        $('.all_rev').css({
            'opacity': '1',
            'visibility': 'visible',
        });
        $('#shadow').css({
            'display': 'block',
        });
    })
</script>

{{-- === All Review Closing === --}}
<script>
    $('.rev_close_btn').click(function(){
        $('.all_rev').css({
            'opacity': '0',
            'visibility': 'hidden',
        });
        $('#shadow').css({
            'display': 'none',
        });
    })
</script>
@endsection