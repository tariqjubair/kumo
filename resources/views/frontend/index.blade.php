@extends('layouts.master')

@section('content')
<!-- ======================= Category & Slider ======================== -->
<section class="p-0">
    <div class="container">
        <div class="row">
        
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="killore-new-block-link border mb-3 mt-3">
                    <div class="px-3 py-3 ft-medium fs-md text-dark gray">Top Categories</div>
                    
                    <div class="killore--block-link-content">
                        <ul>
                            @foreach ($cata_all as $cata)
                            <li><a href="javascript:void(0);"><img width="25" src="{{asset('uploads/category')}}/{{$cata->cata_image}}" alt="Category Image"> &nbsp;{{$cata->cata_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                <div class="home-slider auto-slider mb-3 mt-3">

                    <!-- Slide -->
                    <div data-background-image="{{asset('assets/img/light-banner-1.png')}}" class="item">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="home-slider-container">

                                        <!-- Slide Title -->
                                        <div class="home-slider-desc">
                                            <div class="home-slider-title mb-4">
                                                <h5 class="fs-sm ft-ragular mb-2">New Collection</h5>
                                                <h1 class="mb-2 ft-bold">The Standard<br>With <span class="theme-cl">Smartness</span></h1>
                                                <span class="trending">Apple 10 comes with 6.5 inches full HD + High Valume</span>
                                            </div>

                                            <a href="{{route('shop_page')}}" class="btn btn-white stretched-link hover-black">Buy Now<i class="lni lni-arrow-right ml-2"></i></a>
                                        </div>
                                        <!-- Slide Title / End -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide -->
                    <div data-background-image="{{asset('assets/img/light-banner-2.png')}}" class="item">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="home-slider-container">

                                        <!-- Slide Title -->
                                        <div class="home-slider-desc">
                                            <div class="home-slider-title mb-4">
                                                <h5 class="fs-sm ft-ragular mb-2">Super Sale</h5>
                                                <h1 class="mb-2 ft-bold">The Standard<br>With <span class="text-success">Smartness</span></h1>
                                                <span class="trending">Xiomi Redmi 10 comes with 6.5 inches full HD + LCD Screen</span>
                                            </div>

                                            <a href="{{route('shop_page')}}" class="btn btn-white stretched-link hover-black">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                                        </div>
                                        <!-- Slide Title / End -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide -->
                    <div data-background-image="{{asset('assets/img/light-banner-3.png')}}" class="item">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="home-slider-container">

                                        <!-- Slide Title -->
                                        <div class="home-slider-desc">
                                            <div class="home-slider-title mb-4">
                                                <h5 class="fs-sm ft-ragular mb-2">Super Sale</h5>
                                                <h1 class="mb-2 ft-bold">The Standard<br>With Smartness</h1>
                                                <span class="trending">Xiomi Redmi 10 comes with 6.5 inches full HD + LCD Screen</span>
                                            </div>

                                            <a href="{{route('shop_page')}}" class="btn theme-bg text-light">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                                        </div>
                                        <!-- Slide Title / End -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Category & Slider ======================== -->

<!-- ======================= Product List ======================== -->
<section class="middle">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Trendy Products</h2>
                    <h3 class="ft-bold pt-3">Our Trending Products</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center rows-products">			
            <!-- Single -->
            @foreach ($product_all as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
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
            @endforeach
            
        </div>
        
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative text-center">
                    <a href="shop-style-1.html" class="btn stretched-link borders">Explore More<i class="lni lni-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- ======================= Product List ======================== -->

<!-- ======================= Brand Start ============================ -->
<section class="py-3 br-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="smart-brand">
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-1.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-2.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-3.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-4.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-5.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-6.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-1.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-2.png" class="img-fluid" alt="" />
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Brand Start ============================ -->

<!-- ======================= Tag Wrap Start ============================ -->
<section class="bg-cover" style="background:url({{asset('assets/img/e-middle-banner.png')}}) no-repeat;">
    <div class="ht-60"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="tags_explore text-center">
                    <h2 class="mb-0 text-white ft-bold">Big Sale Up To 70% Off</h2>
                    <p class="text-light fs-lg mb-4">Exclussive Offers For Limited Time</p><p>
                    <a href="#" class="btn btn-lg bg-white px-5 text-dark ft-medium">Explore Your Order</a>
                </p></div>
            </div>
        </div>
    </div>
    <div class="ht-60"></div>
</section>
<!-- ======================= Tag Wrap Start ============================ -->

<!-- ======================= All Category ======================== -->
<section class="middle">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Popular Categories</h2>
                    <h3 class="ft-bold pt-3">Trending Categories</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center justify-content-center">

            @foreach ($cata_all_in as $cata)
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-4">
                    <div class="cats_side_wrap text-center mx-auto mb-3">
                        <div class="sl_cat_01"><div class="d-inline-flex align-items-center justify-content-center p-4 circle mb-2 border"><a href="javascript:void(0);" class="d-block"><img src="{{asset('uploads/category')}}/{{$cata->cata_image}}" class="img-fluid" width="40" alt=""></a></div></div>
                        <div class="sl_cat_02"><h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">{{$cata->cata_name}}</a></h6></div>
                    </div>
                </div>
            @endforeach
            
            
        </div>
        
    </div>
</section>
<!-- ======================= All Category ======================== -->

<!-- ======================= Customer Review ======================== -->
<section class="gray">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Testimonials</h2>
                    <h3 class="ft-bold pt-3">Client Reviews</h3>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12">
                <div class="reviews-slide px-3">
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-1.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">Mark Jevenue</h4>
                                <span class="fs-sm">CEO of Addle</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-2.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">Henna Bajaj</h4>
                                <span class="fs-sm">Aqua Founder</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-3.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">John Cenna</h4>
                                <span class="fs-sm">CEO of Plike</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-4.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">Madhu Sharma</h4>
                                <span class="fs-sm">Team Manager</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Customer Review ======================== -->

<!-- ======================= Top Seller Start ============================ -->
<section class="space min">
    <div class="container">
        
        <div class="row">
            
            {{-- === Top Seller === --}}
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="top-seller-title"><h4 class="ft-medium">Top Seller</h4></div>
                <div class="ftr-content">
                
                    <!-- Single Item -->
                    @foreach ($top_seller as $product)
                        {{-- {{'Sum:'.$product->sum.'|'}}{{$product->product_id}} --}}
                        <div class="product_grid row">
                            <div class="col-xl-4 col-lg-5 col-md-5 col-4">
                                <div class="shop_thumb position-relative" style="border: 1px solid rgba(128, 134, 134, 0.527)">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $product->relto_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$product->relto_product->preview}}" alt="Product Preview"></a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-7 col-8 pl-0">
                                <div class="text-left mfliud">
                                    <div class="elso_titl"><span class="small">{{$product->relto_product->relto_cata->cata_name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1 ft-medium"><a href="{{route('product.details', $product->relto_product->slug)}}">{{$product->relto_product->product_name}}</a></h5>
                                    <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                        @php
                                            $avg_star = App\Models\OrdereditemsTab::where('product_id', $product->product_id)->avg('star');
                                        @endphp

                                        @for ($i = 1; $i <= $avg_star; $i ++)
                                            <i class="fas fa-star filled"></i>

                                            @if ($avg_star - $i < 1 && $avg_star - $i > 0)
                                                <i class="fad fa-star-half" style="--fa-secondary-opacity: 1.0; --fa-primary-color: #FF9800; --fa-secondary-color: #D6DDE6;"></i>
                                            @endif
                                        @endfor

                                        @for ($i = 1; $i <= 5-$avg_star; $i ++)
                                            <i class="fas fa-star"></i>
                                        @endfor

                                        <span class="small">({{App\Models\OrdereditemsTab::where('product_id', $product->product_id)->whereNotNull('star')->count()}})</span>
                                    </div>
                                        @if ($product->relto_product->discount != 0)
                                            <span class="ft-medium text-muted line-through fs-sm mr-2">{{$product->relto_product->price}}</span>
                                            <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->relto_product->after_disc)}}&#2547;</span>
                                        @else
                                            <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->relto_product->price)}}&#2547;</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            {{-- === Featured Products === --}}
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="ftr-title"><h4 class="ft-medium">Featured Products</h4></div>
                <div class="ftr-content">

                    <!-- Single Item -->
                    @foreach ($featured as $product)
                        {{-- {{'Sum:'.$product->sum.'|'}}{{$product->product_id}} --}}
                        <div class="product_grid row">
                            <div class="col-xl-4 col-lg-5 col-md-5 col-4">
                                <div class="shop_thumb position-relative" style="border: 1px solid rgba(128, 134, 134, 0.527)">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $product->relto_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$product->relto_product->preview}}" alt="Product Preview"></a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-7 col-8 pl-0">
                                <div class="text-left mfliud">
                                    <div class="elso_titl"><span class="small">{{$product->relto_product->relto_cata->cata_name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1 ft-medium"><a href="{{route('product.details', $product->relto_product->slug)}}">{{$product->relto_product->product_name}}</a></h5>
                                    <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                        @php
                                            $avg_star = App\Models\OrdereditemsTab::where('product_id', $product->product_id)->avg('star');
                                        @endphp

                                        @for ($i = 1; $i <= $avg_star; $i ++)
                                            <i class="fas fa-star filled"></i>

                                            @if ($avg_star - $i < 1 && $avg_star - $i > 0)
                                                <i class="fad fa-star-half" style="--fa-secondary-opacity: 1.0; --fa-primary-color: #FF9800; --fa-secondary-color: #D6DDE6;"></i>
                                            @endif
                                        @endfor

                                        @for ($i = 1; $i <= 5-$avg_star; $i ++)
                                            <i class="fas fa-star"></i>
                                        @endfor

                                        <span class="small">({{App\Models\OrdereditemsTab::where('product_id', $product->product_id)->whereNotNull('star')->count()}})</span>
                                    </div>
                                        @if ($product->relto_product->discount != 0)
                                            <span class="ft-medium text-muted line-through fs-sm mr-2">{{$product->relto_product->price}}</span>
                                            <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->relto_product->after_disc)}}&#2547;</span>
                                        @else
                                            <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->relto_product->price)}}&#2547;</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Recent Products --}}
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="ftr-title"><h4 class="ft-medium">Recent Products</h4></div>
                <div class="ftr-content">

                    <!-- Single Item -->
                    @foreach ($product_recent as $product)
                    <div class="product_grid row">
                        <div class="col-xl-4 col-lg-5 col-md-5 col-4">
                            <div class="shop_thumb position-relative" style="border: 1px solid rgba(128, 134, 134, 0.527)">
                                <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt="Product Preview"></a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7 col-md-7 col-8 pl-0">
                            <div class="text-left mfliud">
                                <div class="elso_titl"><span class="small">{{$product->relto_cata->cata_name}}</span></div>
                                <h5 class="fs-md mb-0 lh-1 mb-1 ft-medium"><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h5>
                                <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                    @php
                                        $avg_star = App\Models\OrdereditemsTab::where('product_id', $product->id)->avg('star');
                                    @endphp

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
                                        <span class="ft-medium text-muted line-through fs-sm mr-2">{{$product->price}}</span>
                                        <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->after_disc)}}&#2547;</span>
                                    @else
                                        <span class="ft-bold theme-cl fs-sm mr-2">{{number_format($product->price)}}&#2547;</span>
                                    @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
            
        </div>
        
    </div>
</section>
<!-- ======================= Top Seller End ============================ -->
@endsection