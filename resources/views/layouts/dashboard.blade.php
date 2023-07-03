
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gymove - Fitness Bootstrap Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('dashboard/images/favicon.png')}}">
	<link rel="stylesheet" href="{{asset('dashboard/vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link href="{{asset('dashboard/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
	<link href="{{asset('dashboard/icons/Font Awesome 5/fontawesome.min.css')}}" rel="stylesheet">
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-thin-straight/css/uicons-thin-straight.css'>
	<link href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="//cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('dashboard/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/css/custom_style.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>

	{{-- ======= Content ====== --}}
    @yield('header_style')

    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

	{{-- === Dash Loader === --}}
	<div id="dash_loader"></div>

    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{route('home')}}" class="brand-logo">
                <img class="logo-abbr" src="{{asset('dashboard/images/logo.png')}}" alt="">
                <img class="logo-compact" src="{{asset('dashboard/images/logo-text.png')}}" alt="">
                <img class="brand-title" src="{{asset('dashboard/images/logo-text.png')}}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		*****************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
								Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
							<li class="nav-item">
								<div class="input-group search-area d-xl-inline-flex d-none">
									<div class="input-group-append">
										<span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
									</div>
									<input type="text" class="form-control" placeholder="Search here...">
								</div>
							</li>

							@php
								$user_info = App\Models\User::where('id', Auth::user()->id)->first();
								$user_notif = App\Models\UserNotif::where('email', Auth::user()->email)->where('status', 1)->latest('id')->get();
								$notif_all = App\Models\UserNotif::orderBy('id', 'DESC')->get();
								$order_placed = App\Models\OrderTab::where('order_status', 1)->orderBy('id', 'DESC')->get();
								$user_role = Auth::user()->getRoleNames()->first();
							@endphp

							{{-- === Notification === --}}
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link ai-icon notif_link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.716 23.2604 11.5363 22.75H16.4637C16.284 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5ZM23.625 21H4.375C4.14298 20.9999 3.9205 20.9076 3.75644 20.7436C3.59237 20.5795 3.50014 20.357 3.5 20.125C3.50076 19.429 3.77757 18.7618 4.26969 18.2697C4.76181 17.7776 5.42904 17.5008 6.125 17.5H21.875C22.571 17.5008 23.2382 17.7776 23.7303 18.2697C24.2224 18.7618 24.4992 19.429 24.5 20.125C24.4999 20.357 24.4076 20.5795 24.2436 20.7436C24.0795 20.9076 23.857 20.9999 23.625 21Z" fill="#0B2A97"/>
									</svg>

									@if ($user_info->status == 2)
										<div class="pulse-css"></div>
									@endif
                                </a>
                                <div class="dropdown-menu rounded dropdown-menu-right">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3 height380">
										<ul class="timeline" style="border: none">
											@forelse ($user_notif as $item)
												<li>
													<a href="{{route('notif.route', $item->route)}}" class="notif_link">
														<div class="timeline-panel">
															<div class="media mr-2">
																<img alt="image" width="50" src="{{asset('dashboard/images')}}/{{$item->image}}">
															</div>
															<div class="media-body">
																<h6 class="mb-1">{{$item->heading}}</h6>
																<small class="d-block">{{$item->created_at->format('d-M-y h:i A')}}</small>
															</div>
														</div>
													</a>
												</li>
											@empty
												@if ($user_role == 'Admin' || $user_role == 'Super Admin')
													@if ($user_info->status == 0)
														<div class="time py-2 d-flex justify-content-center">
															<h6>No New Nofifications</h6>
														</div>
													@endif
												@else
													<div class="time py-2 d-flex justify-content-center">
														<h6>No New Nofifications</h6>
													</div>
												@endif
											@endforelse

											@can('admin_notification_view')
											@if ($user_info->status != 0)
												@foreach ($notif_all->take(1) as $item)
													<li>
														<a href="{{route('adm.notif')}}" class="notif_link">
															<div class="timeline-panel">
																<div class="media mr-2">
																	<img alt="image" width="50" src="{{asset('dashboard/images')}}/{{$item->image}}">
																</div>
																<div class="media-body">
																	<h6 class="mb-1">{{$item->heading}}</h6>
																	<small class="d-block">for <span class="text-primary"><b>{{$item->fname}}</b></span> in {{$item->created_at->format('d-M-y')}}</small>
																</div>
															</div>
														</a>
													</li>
												@endforeach
											@endif
											@endcan
										</ul>
									</div>
                                    <a class="all-notification" href="{{route('user.notif')}}">See all notifications <i class="ti-arrow-right"></i></a>
                                </div>
                            </li>
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell bell-link" href="javascript:void(0)">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M22.4605 3.84888H5.31688C4.64748 3.84961 4.00571 4.11586 3.53237 4.58919C3.05903 5.06253 2.79279 5.7043 2.79205 6.3737V18.1562C2.79279 18.8256 3.05903 19.4674 3.53237 19.9407C4.00571 20.4141 4.64748 20.6803 5.31688 20.6811C5.54005 20.6812 5.75404 20.7699 5.91184 20.9277C6.06964 21.0855 6.15836 21.2995 6.15849 21.5227V23.3168C6.15849 23.6215 6.24118 23.9204 6.39774 24.1818C6.5543 24.4431 6.77886 24.6571 7.04747 24.8009C7.31608 24.9446 7.61867 25.0128 7.92298 24.9981C8.22729 24.9834 8.52189 24.8863 8.77539 24.7173L14.6173 20.8224C14.7554 20.7299 14.918 20.6807 15.0842 20.6811H19.187C19.7383 20.68 20.2743 20.4994 20.7137 20.1664C21.1531 19.8335 21.4721 19.3664 21.6222 18.8359L24.8966 7.05011C24.9999 6.67481 25.0152 6.28074 24.9414 5.89856C24.8675 5.51637 24.7064 5.15639 24.4707 4.84663C24.235 4.53687 23.931 4.28568 23.5823 4.11263C23.2336 3.93957 22.8497 3.84931 22.4605 3.84888ZM23.2733 6.60304L20.0006 18.3847C19.95 18.5614 19.8432 18.7168 19.6964 18.8275C19.5496 18.9381 19.3708 18.9979 19.187 18.9978H15.0842C14.5856 18.9972 14.0981 19.1448 13.6837 19.4219L7.84171 23.3168V21.5227C7.84097 20.8533 7.57473 20.2115 7.10139 19.7382C6.62805 19.2648 5.98628 18.9986 5.31688 18.9978C5.09371 18.9977 4.87972 18.909 4.72192 18.7512C4.56412 18.5934 4.4754 18.3794 4.47527 18.1562V6.3737C4.4754 6.15054 4.56412 5.93655 4.72192 5.77874C4.87972 5.62094 5.09371 5.53223 5.31688 5.5321H22.4605C22.5905 5.53243 22.7188 5.56277 22.8353 5.62076C22.9517 5.67875 23.0532 5.76283 23.1318 5.86646C23.2105 5.97008 23.2642 6.09045 23.2887 6.21821C23.3132 6.34597 23.308 6.47766 23.2733 6.60304Z" fill="#0B2A97"/>
										<path d="M7.84173 11.4233H12.0498C12.273 11.4233 12.4871 11.3347 12.6449 11.1768C12.8027 11.019 12.8914 10.8049 12.8914 10.5817C12.8914 10.3585 12.8027 10.1444 12.6449 9.98661C12.4871 9.82878 12.273 9.74011 12.0498 9.74011H7.84173C7.61852 9.74011 7.40446 9.82878 7.24662 9.98661C7.08879 10.1444 7.00012 10.3585 7.00012 10.5817C7.00012 10.8049 7.08879 11.019 7.24662 11.1768C7.40446 11.3347 7.61852 11.4233 7.84173 11.4233Z" fill="#0B2A97"/>
										<path d="M15.4162 13.1066H7.84173C7.61852 13.1066 7.40446 13.1952 7.24662 13.3531C7.08879 13.5109 7.00012 13.725 7.00012 13.9482C7.00012 14.1714 7.08879 14.3855 7.24662 14.5433C7.40446 14.7011 7.61852 14.7898 7.84173 14.7898H15.4162C15.6394 14.7898 15.8535 14.7011 16.0113 14.5433C16.1692 14.3855 16.2578 14.1714 16.2578 13.9482C16.2578 13.725 16.1692 13.5109 16.0113 13.3531C15.8535 13.1952 15.6394 13.1066 15.4162 13.1066Z" fill="#0B2A97"/>
									</svg>
									<div class="pulse-css"></div>
                                </a>
							</li>

							{{-- === Order === --}}
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link ai-icon order_link" href="javascript:void(0)" data-toggle="dropdown">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M23.625 6.12506H22.75V2.62506C22.75 2.47268 22.7102 2.32295 22.6345 2.19068C22.5589 2.05841 22.45 1.94819 22.3186 1.87093C22.1873 1.79367 22.0381 1.75205 21.8857 1.75019C21.7333 1.74832 21.5831 1.78629 21.4499 1.86031L14 5.99915L6.55007 1.86031C6.41688 1.78629 6.26667 1.74832 6.11431 1.75019C5.96194 1.75205 5.8127 1.79367 5.68136 1.87093C5.55002 1.94819 5.44113 2.05841 5.36547 2.19068C5.28981 2.32295 5.25001 2.47268 5.25 2.62506V6.12506H4.375C3.67904 6.12582 3.01181 6.40263 2.51969 6.89475C2.02757 7.38687 1.75076 8.0541 1.75 8.75006V11.3751C1.75076 12.071 2.02757 12.7383 2.51969 13.2304C3.01181 13.7225 3.67904 13.9993 4.375 14.0001H5.25V23.6251C5.25076 24.321 5.52757 24.9882 6.01969 25.4804C6.51181 25.9725 7.17904 26.2493 7.875 26.2501H20.125C20.821 26.2493 21.4882 25.9725 21.9803 25.4804C22.4724 24.9882 22.7492 24.321 22.75 23.6251V14.0001H23.625C24.321 13.9993 24.9882 13.7225 25.4803 13.2304C25.9724 12.7383 26.2492 12.071 26.25 11.3751V8.75006C26.2492 8.0541 25.9724 7.38687 25.4803 6.89475C24.9882 6.40263 24.321 6.12582 23.625 6.12506ZM21 6.12506H17.3769L21 4.11256V6.12506ZM7 4.11256L10.6231 6.12506H7V4.11256ZM7 23.6251V14.0001H13.125V24.5001H7.875C7.64303 24.4998 7.42064 24.4075 7.25661 24.2434C7.09258 24.0794 7.0003 23.857 7 23.6251ZM21 23.6251C20.9997 23.857 20.9074 24.0794 20.7434 24.2434C20.5794 24.4075 20.357 24.4998 20.125 24.5001H14.875V14.0001H21V23.6251ZM24.5 11.3751C24.4997 11.607 24.4074 11.8294 24.2434 11.9934C24.0794 12.1575 23.857 12.2498 23.625 12.2501H4.375C4.14303 12.2498 3.92064 12.1575 3.75661 11.9934C3.59258 11.8294 3.5003 11.607 3.5 11.3751V8.75006C3.5003 8.51809 3.59258 8.2957 3.75661 8.13167C3.92064 7.96764 4.14303 7.87536 4.375 7.87506H23.625C23.857 7.87536 24.0794 7.96764 24.2434 8.13167C24.4074 8.2957 24.4997 8.51809 24.5 8.75006V11.3751Z" fill="#0B2A97"/>
									</svg>

									@if (App\Models\OrderTab::where('order_status', 1)->exists())
										<div class="pulse-css"></div>
									@endif
                                </a>
								<div class="dropdown-menu dropdown-menu-right rounded">
									<div id="DZ_W_TimeLine11Home" class="widget-timeline dz-scroll style-1 p-3 height370 ps ps--active-y">
										<ul class="timeline" style="border: none">
											@forelse ($order_placed as $order)
											<li class="order_list">
												<div class="timeline-badge primary">
												</div>
												<a class="timeline-panel text-muted" href="{{route('order.info', $order->id)}}">
													<span class="mb-0 time">{{$order->created_at->diffForHumans()}}</span>
													<p class="mb-0"><strong>{{$order->order_id}}</strong></p>
													<h6 class="mb-0">New order placed</h6>
												</a>
											</li>
											@empty
												<div class="time py-2 d-flex justify-content-center">
													<h6>No New Orders</h6>
												</div>
											@endforelse
										</ul>
									</div>
								</div>
							</li>

							{{-- === User Corner === --}}
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    @auth
										@if (Auth::user()->image == null)
											<img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
										@else
											<img src="{{asset('uploads/user')}}/{{Auth::user()->image}}" alt="User">
										@endif
										<div class="header-info">
											<span class="text-black"><strong>{{Auth::user()->name}}</strong></span>
											<h5 class="fs-12 mb-0">
												{{-- {{Auth::user()->role == 1 ?'Super Admin' :'Admin'}} --}}
												{{$user_role ?$user_role :'Visitor'}}
											</h5>
										</div>
									@endauth
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{route('user.profile')}}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="{{ route('logout') }}" class="dropdown-item ai-icon"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->

		{{-- === Dashboard Side Menu === --}}
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-chart-area"></i>
							<span class="nav-text">Dashboard</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="{{route('home')}}">Home</a></li>
						</ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-users"></i>
							<span class="nav-text">Users</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('user.profile')}}">Profile</a></li>
                            <li><a href="{{route('user.role')}}">Role & Permissions</a></li>
                            <li><a href="{{route('user.notif')}}">Notifications</a></li>
                            <li><a href="{{route('user_list')}}" aria-expanded="false">User List</a>
                            </li>
							@can('user_add')
								<li><a href="{{route('add.user')}}" aria-expanded="false">Add User</a></li>
							@endcan
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-users-class"></i>
							<span class="nav-text">Customers</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('cust_list')}}" aria-expanded="false">Customer List</a></li>
                        </ul>
                    </li>
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="fad fa-project-diagram"></i>
						<span class="nav-text">Roles</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="{{route('perm.store')}}">Create New Role</a></li>
							<li><a href="{{route('role.store')}}">Manage Roles</a></li>
							<li><a href="{{route('role.users')}}">Assigned Users</a></li>
						</ul>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-sitemap"></i>
							<span class="nav-text">Catagories</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('category_list')}}">Catagory List</a></li>
							<li><a href="{{route('subcategory_list')}}">Sub-Catagory List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-box"></i>
							<span class="nav-text">Products</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('add.product')}}">Add New Product</a></li>
							<li><a href="{{route('product_list')}}">Product List</a></li>
							<li><a href="{{route('product.variation')}}">Variation</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-gift-card"></i>
							<span class="nav-text">Coupons</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('add.coupon')}}">Add New Coupon</a></li>
							<li><a href="{{route('coupon_list')}}">Coupon List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-file-invoice-dollar"></i>
							<span class="nav-text">Charges</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('charge.delivery')}}">Delivery Charge</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fad fa-shopping-bag"></i>
							<span class="nav-text">Order</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('order_list')}}">Order List</a></li>
                        </ul>
                    </li>
                </ul>
				<div class="copyright">
					<p><strong>Gymove Admin Dashboard</strong> © 2022 All Rights Reserved</p>
					<p>Made by RIQ-Dev</p>
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				{{-- ======= Content ====== --}}
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/" target="_blank">DexignZone</a> 2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('dashboard/vendor/global/global.min.js')}}"></script>
	<script src="{{asset('dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('dashboard/vendor/chart.js/Chart.bundle.min.js/vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('dashboard/js/custom.min.js')}}"></script>
	<script src="{{asset('dashboard/js/deznav-init.js')}}"></script>
	<script src="{{asset('dashboard/vendor/owl-carousel/owl.carousel.js')}}"></script>
	<script src="{{asset('dashboard/icons/Font Awesome 5/Font-Awesome.js')}}"></script>
	
	<!-- Chart piety plugin files -->
    <script src="{{asset('dashboard/vendor/peity/jquery.peity.min.js')}}"></script>
	
	<!-- Apex Chart -->
	<script src="{{asset('dashboard/vendor/apexchart/apexchart.js')}}"></script>
	
	<!-- Dashboard 1 -->
	<script src="{{asset('dashboard/js/dashboard/dashboard-1.js')}}"></script>
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:30,
				nav:false,
				dots: false,
				left:true,
				navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
				responsive:{
					0:{
						items:1
					},
					484:{
						items:2
					},
					882:{
						items:3
					},	
					1200:{
						items:2
					},			
					
					1540:{
						items:3
					},
					1740:{
						items:4
					}
				}
			})			
		}
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000); 
		});
	</script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

	{{-- === Job Update Confirm Session === --}}
	@if (session('job_upd'))
	<script>
		Swal.fire({
			position: 'center-center',
			icon: 'success',
			title: '{{session("job_upd")}}',
			showConfirmButton: false,
			timer: 1500
		})
	</script>
	@endif

	{{-- === Item Deleted === --}}
	@if (session('del'))
		<script>
			Swal.fire(
				'Deleted!',
				'{{session("del")}}',
				'success'
			)
		</script>
	@endif

	{{-- === Dash Loader === --}}
	<script>
		$(window).on('load', function () {
			$('#dash_loader').fadeOut();
		}) 
	</script>

	{{-- === Notification Pulse === --}}
	<script>
		$('.notif_link').click(function(){
			$(this).find('.pulse-css').addClass('d-none');

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$.ajax ({
				url: '/get_user_status',
				type: 'POST',
			})
		})
	</script>

    {{-- ======= Footer Script ====== --}}
    @yield('footer_script')
</body>
</html>