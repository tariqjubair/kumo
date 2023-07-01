
<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="utf-8" />
	<meta name="author" content="Themezhub" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('meta')
	
	<title>Kumo</title>
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/site_logo.png')}}">
		
	<!-- Custom CSS -->
	<link href="{{asset('assets/css/plugins/animation.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/flaticon.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/font-awesome.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/fontawesome.min.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/iconfont.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/ion.rangeSlider.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/light-box.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/line-icons.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/slick-theme.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/slick.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/snackbar.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/plugins/themify.css')}}" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/style_fend.css')}}" rel="stylesheet">

	{{-- === Google Fonts === --}}
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Jost:wght@400;500;600;800&family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">

	{{-- ==== Content HERE ==== --}}
	@yield('header_css')

	<style>
		@media(max-width: 575px){

			#back2Top {
				bottom: 30px;
    			right: unset;
    			left: 30px;
			}
			
		}
	</style>
	

</head>

<body>

	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/649b389594cf5d49dc603068/1h3v5a2no';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
	</script>

	<!-- ============================================================== -->
	<!-- Preloader - style you can find in spinners.css -->
	<!-- ============================================================== -->

	<div class="preloader"></div>
	<div id="loader"></div>
	<div id="shadow"></div>
	
	<!-- ============================================================== -->
	<!-- Main wrapper - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<div id="main-wrapper">
		@if(session('user_login')){
			<div class="shw" style = "visibility: visible"></div>
			<div class="alert_part" style = "visibility: visible">
				<div class="alert">
					<h2>Hello</h2>
					<h3>{{Auth::guard('CustLogin')->user()->name}}</h3>
					<img src="{{asset('assets/img/user.png')}}" width="80px">
				</div>
				<img src="{{asset('assets/img/signin_dash.png')}}" class="alert_bg" width="400px">
			</div>
			{{header("refresh: 2")}}
		}
		@endif
		
		<!-- ============================================================== -->
		<!-- Top header  -->
		<!-- ============================================================== -->
		<!-- Top Header -->
		<div class="py-2 br-bottom header_one">
			<div class="container">
				<div class="row">
					
					<div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 hide-ipad">
						<div class="top_second"><p class="medium text-muted m-0 p-0"><i class="fal fa-at"></i> 
							@if (session('lang_fra'))
								Adresse postale:
							@elseif (session('lang_ben'))
								মেইল:
							@else
								Email: 
							@endif
							<a href="mailto:tariq.wpdev@gmail.com" class="medium text-dark text-underline">tariq.wpdev@gmail.com</a></p>
						</div>
					</div>
					
					<!-- Right Menu -->
					<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
						<!-- Choose Language -->
						<div class="language-selector-wrapper dropdown js-dropdown float-right mr-3">
							<a class="popup-title" href="javascript:void(0)" data-toggle="dropdown" title="Language" aria-label="Language dropdown">
								<span class="hidden-xl-down medium text-muted">Language:</span>
								@if (session('lang_fra'))
									<img src="{{asset('assets/img/2.jpg')}}" alt="fr" width="16" height="11" />
									<span class="iso_code medium text-muted">{{'Français'}}</span>
								@elseif (session('lang_ben'))
									<img src="{{asset('assets/img/555.jpg')}}" alt="bn" width="16" height="11"/>
									<span class="iso_code medium text-muted">{{'Bengali'}}</span>
								@else
									<img src="{{asset('assets/img/1.jpg')}}" alt="en" width="16" height="11" />
									<span class="iso_code medium text-muted">{{'English'}}</span>
								@endif
								
								<i class="fa fa-angle-down medium text-muted"></i>
							</a>
							<ul class="dropdown-menu popup-content link">
								<li class="current"><a href="{{route('lang.eng')}}" class="dropdown-item medium text-muted"><img src="{{asset('assets/img/1.jpg')}}" alt="en" width="16" height="11" /><span>English</span></a></li>
								<li><a href="{{route('lang.fra')}}" class="dropdown-item medium text-muted"><img src="{{asset('assets/img/2.jpg')}}" alt="fr" width="16" height="11" /><span>Français</span></a></li>
								<li><a href="{{route('lang.ben')}}" class="dropdown-item medium text-muted"><img src="{{asset('assets/img/555.jpg')}}" alt="bn" width="16" height="11" /><span>Bengali</span></a></li>
							</ul>
						</div>

						{{-- === Profile/Logout === --}}
						<div class="language-selector-wrapper dropdown js-dropdown float-right mr-5">
							@auth('CustLogin')
								<a class="popup-title" href="javascript:void(0)" data-toggle="dropdown" title="" aria-label="">
									<span class="iso_code medium text-danger" style="font-size: 16px">
										{{Auth::guard('CustLogin')->user()->name}}
									</span>
									<i class="fa fa-angle-down medium text-muted"></i>
								</a>
								<ul class="dropdown-menu popup-content link">
									<li><a class="dropdown-item" href="{{route('customer.profile')}}">
										<i class="fas fa-user-circle mr-2"></i>
										@if (session('lang_fra'))
											profil
										@elseif (session('lang_ben'))
											প্রোফাইল
										@else
											Profile
										@endif
									</a></li>
									<li><a class="dropdown-item" href="{{route('customer.logout')}}"><i class="far fa-sign-out mr-2"></i>
										@if (session('lang_fra'))
											Se déconnecter
										@elseif (session('lang_ben'))
											প্রস্থান
										@else
											Logout
										@endif
									</a></li>
								</ul>
							@else
								<a href="{{route('customer_login')}}" class="text-muted medium"><i class="fad fa-users mr-2"></i>
									@if (session('lang_fra'))
										S'identifier / enregistrer
									@elseif (session('lang_ben'))
										সাইন ইন / নিবন্ধন
									@else
										Sign In / Register
									@endif
								</a>
							@endauth
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="headd-sty header">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="headd-sty-wrap d-flex align-items-center justify-content-between py-3">
							<div class="headd-sty-left d-flex align-items-center">
								<div class="headd-sty-01">
									<a class="nav-brand py-0" href="#">
										<img src="assets/img/logo.png" class="logo" alt="" />
									</a>
								</div>
								<div class="headd-sty-02 ml-3">
									<form class="bg-white rounded-md border-bold">
										<div class="input-group">
											<input 
											type="text" class="form-control custom-height b-0" placeholder="Search for products..." id="master_inp" value="{{@$_GET['inp'] ?$_GET['inp'] :''}}"/>
											<div class="input-group-append">
												<div class="input-group-text"><button class="btn bg-white text-danger custom-height rounded px-3" type="button" id="master_search"><i class="fas fa-search"></i></button></div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="headd-sty-last">
								<ul class="nav-menu nav-menu-social align-to-right align-items-center d-flex">
									<li>
										<div class="call d-flex align-items-center text-left">
											<i class="lni lni-phone fs-xl"></i>
											<span class="text-muted small ml-3">
												@if (session('lang_fra'))
													Appelez-nous Maintenant:
												@elseif (session('lang_ben'))
													আমাদের কল করুন:
												@else
													Call Us Now:
												@endif
												<strong class="d-block text-dark fs-md">0(800) 123-456</strong>
											</span>
										</div>
									</li>

									{{-- === Open Wishlist === --}}
									@php
										$act_wish_qty = 0;
									@endphp
									@foreach (App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->get() as $wish_qty)
										@if ($wish_qty->relto_product()->exists())
											@php
												$act_wish_qty += 1;
											@endphp
										@endif
									@endforeach
									<li>
										<a href="#" onclick="openWishlist()">
											<i class="far fa-heart fs-lg"></i><span class="dn-counter bg-success">{{$act_wish_qty}}</span>
										</a>
									</li>

									{{-- === Open Cart === --}}
									<li>
										<a href="#" onclick="openCart()">
											<div class="d-flex align-items-center justify-content-between">
												<i class="fas fa-shopping-basket fs-lg"></i><span class="dn-counter theme-bg">{{App\Models\cartMod::where('customer_id', Auth::guard('CustLogin')->id())->count()}}</span>
											</div>
										</a>
									</li>
								</ul>	
							</div>
							<div class="mobile_nav">
								<ul>
									<li>
									<a href="#" onclick="openSearch()">
										<i class="lni lni-search-alt"></i>
									</a>
								</li>
								<li>
									<a href="#" data-toggle="modal" data-target="#login">
										<i class="lni lni-user"></i>
									</a>
								</li>
								<li>
									<a href="#" onclick="openWishlist()">
										<i class="lni lni-heart"></i><span class="dn-counter">{{App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->count()}}</span>
									</a>
								</li>
								<li>
									<a href="#" onclick="openCart()">
										<i class="lni lni-shopping-basket"></i><span class="dn-counter">{{App\Models\cartMod::where('customer_id', Auth::guard('CustLogin')->id())->count()}}</span>
									</a>
								</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Start Navigation -->
		<div class="headerd header-dark head-style-2">
			<div class="container">
				<nav id="navigation" class="navigation navigation-landscape">
					<div class="nav-header">
						<div class="nav-toggle"></div>
						<div class="nav-menus-wrapper">
							<ul class="nav-menu">
								<li><a href="{{route('home_page')}}" class="pl-0">Home</a></li>
								<li><a href="{{route('shop_page')}}">Shop</a></li>
								<li><a href="{{route('about_page')}}">About Us</a></li>
								<li><a href="{{route('contact_page')}}">Contact</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<!-- End Navigation -->
		<div class="clearfix"></div>
		<!-- ============================================================== -->
		<!-- Top header  -->
		<!-- ============================================================== -->
		
		
		{{-- ==== Content HERE ==== --}}
		@yield('content')



		
		<!-- ======================= Customer Features ======================== -->
		<section class="px-0 py-3 br-top">
			<div class="container">
				<div class="row">
					
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="fas fa-shopping-basket"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">Free Shipping</h5>
								<span class="text-muted">Capped at $10 per order</span>
							</div>
						</div>
					</div>
					
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="far fa-credit-card"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">Secure Payments</h5>
								<span class="text-muted">Up to 6 months installments</span>
							</div>
						</div>
					</div>
					
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="fas fa-shield-alt"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">15-Days Returns</h5>
								<span class="text-muted">Shop with fully confidence</span>
							</div>
						</div>
					</div>
					
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="fas fa-headphones-alt"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">24x7 Fully Support</h5>
								<span class="text-muted">Get friendly support</span>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<!-- ======================= Customer Features ======================== -->
		
		<!-- ============================ Footer Start ================================== -->
		<footer class="dark-footer skin-dark-footer style-2">
			<div class="footer-middle">
				<div class="container">
					<div class="row">
						
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
							<div class="footer_widget">
								<img src="assets/img/logo-light.png" class="img-footer small mb-2" alt="" />
								
								<div class="address mt-3">
									3298 Grant Street Longview, TX<br>United Kingdom 75601	
								</div>
								<div class="address mt-3">
									1-202-555-0106<br>help@shopper.com
								</div>
								<div class="address mt-3">
									<ul class="list-inline">
										<li class="list-inline-item"><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
										<li class="list-inline-item"><a href="#"><i class="lni lni-twitter-filled"></i></a></li>
										<li class="list-inline-item"><a href="#"><i class="lni lni-youtube"></i></a></li>
										<li class="list-inline-item"><a href="#"><i class="lni lni-instagram-filled"></i></a></li>
										<li class="list-inline-item"><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
						
						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Supports</h4>
								<ul class="footer-menu">
									<li><a href="{{route('contact_page')}}">Contact Us</a></li>
									<li><a href="{{route('about_page')}}">About Page</a></li>
									<li><a href="#">Size Guide</a></li>
									<li><a href="#">FAQ's Page</a></li>
									<li><a href="#">Privacy</a></li>
								</ul>
							</div>
						</div>
								
						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Shop</h4>
								<ul class="footer-menu">
									<li><a href="#">Men's Shopping</a></li>
									<li><a href="#">Women's Shopping</a></li>
									<li><a href="#">Kids's Shopping</a></li>
									<li><a href="#">Furniture</a></li>
									<li><a href="#">Discounts</a></li>
								</ul>
							</div>
						</div>
				
						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Company</h4>
								<ul class="footer-menu">
									<li><a href="{{route('about_page')}}">About</a></li>
									<li><a href="#">Blog</a></li>
									<li><a href="#">Affiliate</a></li>
									<li><a href="{{route('customer_login')}}">Login</a></li>
								</ul>
							</div>
						</div>
						
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Subscribe</h4>
								<p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
								<div class="foot-news-last">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Email Address">
										<div class="input-group-append">
											<button type="button" class="input-group-text b-0 text-light"><i class="lni lni-arrow-right"></i></button>
										</div>
									</div>
								</div>
								<div class="address mt-3">
									<h5 class="fs-sm text-light">Secure Payments</h5>
									<div class="scr_payment"><img src="assets/img/card.png" class="img-fluid" alt="" /></div>
								</div>
							</div>
						</div>
							
					</div>
				</div>
			</div>
			
			<div class="footer-bottom">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-12 col-md-12 text-center copyright">
							<p class="mb-0">© 2023 Kumo. Designd By <a href="https://tariq-jubair.com/">RIQ-Dev</a>.</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- ============================ Footer End ================================== -->
		
		<!-- Add Wishlist -->
		<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
			<div class="rightMenu-scroll">
				<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
					<h4 class="cart_heading fs-md ft-medium mb-0">Saved Products</h4>
					<button onclick="closeWishlist()" class="close_slide"><i class="ti-close"></i></button>
				</div>
				<div class="right-ch-sideBar">
					
					<div class="cart_select_items py-2">
						<!-- Single Item -->

						@foreach (App\Models\WishTable::where('customer_id', Auth::guard('CustLogin')->id())->get() as $wish)
							@if ($wish->relto_product()->exists())
								<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
									<div class="cart_single d-flex align-items-center">
										<div class="cart_selected_single_thumb" style="border: 1px solid rgba(0,0,0,.125)">
											<a href="{{route('product.details', $wish->relto_product->slug)}}"><img src="{{asset('uploads/product/preview/'.$wish->relto_product->preview)}}" width="60" class="img-fluid" alt="" /></a>
										</div>
										<div class="cart_single_caption pl-2">
											<h4 class="product_title fs-sm ft-medium mb-0 lh-1">{{$wish->relto_product->product_name}}</h4>

											<p class="mb-2">
												@if ($wish->color_id != null)
													<span class="text-dark small">{{$wish->relto_color->color_name}}</span>, 
												@endif

												@if ($wish->size_id != null)
													<span class="text-dark small">{{$wish->relto_size->size}}</span>
												@endif
											</p>
											<h4 class="fs-sm ft-medium mb-0 lh-1">
												@if ($wish->quantity != null)
													BDT {{number_format($wish->relto_product->after_disc)}}
													* {{$wish->quantity}}
												@else
													BDT {{number_format($wish->relto_product->after_disc)}}
												@endif
											</h4>
										</div>
									</div>
									<div class="fls_last"><a href="{{route('wishlist.remove', $wish->id)}}" class="close_slide gray"><i class="ti-close"></i></a></div>
								</div>
							@else
								<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
									<div class="cart_single d-flex align-items-center">
										<div class="cart_selected_single_thumb" style="border: 1px solid rgba(0,0,0,.125)">
											<img src="" width="60" class="img-fluid" alt="" />
										</div>
										<div class="cart_single_caption pl-2">
											<h4 class="product_title fs-sm ft-medium mb-0 lh-1">Item Not Available Now!</h4>
										</div>
									</div>
									<div class="fls_last"><a href="{{route('wishlist.remove', $wish->id)}}" class="close_slide gray"><i class="ti-close"></i></a></div>
								</div>
							@endif
						@endforeach	
					</div>
					
					<div class="cart_action px-3 py-3">
						<div class="form-group">
							<a href="{{Auth::guard('CustLogin')->check() ?route('wishlist.remove_all') :route('customer_login')}}" style="width: 45%" class="btn btn-dark-light">Remove All</a>
							<a href="{{Auth::guard('CustLogin')->check() ?route('customer.wishlist') :route('customer_login')}}" style="width: 45%" class="btn btn-dark-light">View Whishlist</a>
						</div>
						@if (session('wish_added'))
							<span class="err_msg err_msg_cart" style="visibility:visible; background: #6f42c1">
							<p>{{session('wish_added')}}</p></span>
						@endif
						@if (session('wish_removed'))
							<span class="err_msg err_msg_cart bg-warning" style="visibility:visible">
							<p>{{session('wish_removed')}}</p></span>
						@endif
					</div>
					
				</div>
			</div>
		</div>
		
		<!-- Add Card List -->
		<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
			<div class="rightMenu-scroll">
				<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
					<h4 class="cart_heading fs-md ft-medium mb-0">Products List</h4>
					<button onclick="closeCart()" class="close_slide"><i class="ti-close"></i></button>
				</div>
				<div class="right-ch-sideBar">
					<div class="cart_select_items py-2" style="max-height: 70vh; overflow-y:scroll">
						
						<!-- Single Item -->
						@php
							$total = 0;
						@endphp

						@foreach (App\Models\cartMod::where('customer_id', Auth::guard('CustLogin')->id())->get() as $cart)
							<div class="d-flex align-items-center justify-content-between px-3 py-3">
								<div class="cart_single d-flex align-items-center">
									<div class="cart_selected_single_thumb" style="border: 1px solid rgba(0,0,0,.125)">
										<a href="{{route('product.details', $cart->relto_product->slug)}}"><img src="{{asset('uploads/product/preview/'.$cart->relto_product->preview)}}" width="60" class="img-fluid" alt="" /></a>
									</div>
									<div class="cart_single_caption pl-2">
										<h4 class="product_title fs-sm ft-medium mb-0 lh-1">{{$cart->relto_product->product_name}}</h4>
										<p class="mb-2"><span class="text-dark ft-medium small">{{$cart->relto_color->color_name}}</span>, <span class="text-dark small">{{$cart->relto_size->size}}</span></p>
										<h4 class="fs-sm ft-medium mb-0 lh-1">
											BDT {{number_format($cart->relto_product->after_disc)}}
											* {{$cart->quantity}}
										</h4>
									</div>
								</div>

								@if (!request()->route()->named('checkout'))
									<div class="fls_last"><a href="{{route('cart.remove', $cart->id)}}" class="close_slide gray"><i class="ti-close"></i></a></div>
								@endif
							</div>

							@php
								$total += $cart->relto_product->after_disc * $cart->quantity
							@endphp
						@endforeach
						
					</div>
					
					<div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
						<h6 class="mb-0">Subtotal</h6>
						
						<h3 class="mb-0 ft-medium">{{number_format($total)}} &#2547;</h3>
					</div>
					
					<div class="cart_action px-3 py-3">
						<div class="form-group">
							<a href="{{Auth::guard('CustLogin')->check() ?route('cart.remove_all') :route('customer_login')}}" style="width: 45%" class="btn btn-dark-light">Remove All</a>
							<a href="{{Auth::guard('CustLogin')->check() ?route('cart.store.update') :route('customer_login')}}" style="width: 45%" class="btn btn-dark-light">View Cart</a>
						</div>
						@if (session('cart_added'))
							<span class="err_msg err_msg_cart bg-success" style="visibility:visible">
							<p>{{session('cart_added')}}</p></span>
						@endif
						@if (session('cart_removed'))
							<span class="err_msg err_msg_cart bg-danger" style="visibility:visible">
							<p>{{session('cart_removed')}}</p></span>
						@endif
					</div>
				</div>
			</div>
		</div>
		
		<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
		

	</div>
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->

	<!-- ============================================================== -->
	<!-- All Jquery -->
	<!-- ============================================================== -->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/popper.min.js')}}"></script>
	<script src="{{asset('assets/js/jquery.number.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/js/ion.rangeSlider.min.js')}}"></script>
	<script src="{{asset('assets/js/slick.js')}}"></script>
	<script src="{{asset('assets/js/slider-bg.js')}}"></script>
	<script src="{{asset('assets/js/lightbox.js')}}"></script> 
	<script src="{{asset('assets/js/Font-Awesome.js')}}"></script> 
	<script src="{{asset('assets/js/smoothproducts.js')}}"></script>
	<script src="{{asset('assets/js/snackbar.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="{{asset('assets/js/jQuery.style.switcher.js')}}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="{{ asset('js/share.js') }}"></script>
	<script src="{{asset('assets/js/custom.js')}}"></script>
	<!-- ============================================================== -->
	<!-- This page plugins -->
	<!-- ============================================================== -->	

	<script>
		function openWishlist() {
			document.getElementById("Wishlist").style.display = "block";
		}
		function closeWishlist() {
			document.getElementById("Wishlist").style.display = "none";
		}
	</script>
	
	<script>
		function openCart() {
			document.getElementById("Cart").style.display = "block";
		}
		function closeCart() {
			document.getElementById("Cart").style.display = "none";
		}
	</script>

	<script>
		function openSearch() {
			document.getElementById("Search").style.display = "block";
		}
		function closeSearch() {
			document.getElementById("Search").style.display = "none";
		}
	</script>	

	{{-- === Fixed Header === --}}
	{{-- <script>
		$(function (){
			$(window).on("scroll", function() {
				if($(window).scrollTop() > 50) {
					$(".header_one").addClass("ext_hd");
				} 
				else {
					$(".header_one").removeClass("ext_hd");

				}
			});
		});
	</script> --}}

	{{-- === Stop Loader on Page Load === --}}
	<script>
		$(window).on('load', function () {
			$('#loader').fadeOut();
		}) 
	</script>
	
	{{-- === Custom Opened Cart === --}}
	@if (session('cart_added'))
		<script>
			document.getElementById("Cart").style.display = "block";
		</script>
	@endif
	@if (session('cart_removed'))
		<script>
			document.getElementById("Cart").style.display = "block";
		</script>
	@endif
	@if (session('wish_added'))
		<script>
			document.getElementById("Wishlist").style.display = "block";
		</script>
	@endif
	@if (session('wish_removed'))
		<script>
			document.getElementById("Wishlist").style.display = "block";
		</script>
	@endif

	{{-- === Master Search === --}}
	<script>
		$('#master_search').click(function(){
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

	{{-- ==== Script HERE ==== --}}
	@yield('footer_script')

</body>

</html>