@extends('layouts.master')



@section('header_css')
<style>
	.form-group a.add_login i {
		font-size: 20px;
		margin-right: 7px;
	}
	.sp_media {
		display: flex;
		margin-bottom: 0;
	}

	@media (max-width: 575.98px){
		.sp_media {
			display: block;
		}
		.sp_media a {
			margin-bottom: 5px;
		}
	}

	@media (min-width: 992px) and (max-width: 1199.98px){
		.sp_media {
			display: block;
		}
		.sp_media a {
			margin-bottom: 5px;
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
                        <li class="breadcrumb-item active" aria-current="page">Login/Register</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
	<div class="container">
		<div class="row align-items-start justify-content-between">
		
			{{-- === Login === --}}
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
				<div class="mb-3 field">
					<h3>Login</h3>
					@if (session('cust_reg2'))
						<span class="err_msg err_msg_log bg-info" style="visibility:visible">
						<p>{{session('cust_reg2')}}</p></span>
					@endif
					@if (session('login_fail'))
						<span class="err_msg" style="visibility:visible; background: red;">
						<p>{{session('login_fail')}}</p></span>
					@endif

					@if (session('reg_success'))
						<span class="err_msg" style="visibility:visible">
						<p>{{session('reg_success')}}</p></span>
					@endif
					@if (session('reg_success2'))
						<span class="err_msg err_msg_log" style="visibility:visible">
						<p>{{session('reg_success2')}}</p></span>
					@endif
					@if (session('reg_fail'))
						<span class="err_msg" style="visibility:visible; background: red;">
						<p>{{session('reg_fail')}}</p></span>
					@endif
					@if (session('need_verify'))
						<span class="err_msg" style="visibility:visible; background: red;">
						<p>{{session('need_verify')}}</p></span>
					@endif
					
					@if (session('cust_logout'))
						<span class="err_msg" style="visibility:visible">
						<p>{{session('cust_logout')}}</p></span>
					@endif
					@if (session('cart_login'))
						<span class="err_msg bg-info" style="visibility:visible">
						<p>{{session('cart_login')}}</p></span>
					@endif
				</div>
				<form class="border p-3 rounded" action="{{route('customer.login')}}" method="POST">
					@csrf				
					<div class="form-group">
						<label>Email/Phone *</label>
						<input type="text" name="username" class="form-control" placeholder="Email*">
						@error('username')
							<strong class="text-danger">{{ $message }}</strong>
						@enderror
					</div>
					
					<div class="form-group">
						<label>Password *</label>
						<input type="password" name="password" class="form-control" placeholder="Password*">
						@error('password')
							<strong class="text-danger">{{ $message }}</strong>
						@enderror
					</div>
					
					<div class="form-group">
						<div class="d-flex align-items-center justify-content-between">
							<div class="eltio_k2">
								<a href="{{route('lost.pass')}}">Lost Your Password?</a>
							</div>	
						</div>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium" id="login_btn">Direct Login</button>
					</div>


					{{-- === Social Login === --}}
					<label>Or, Login with</label>
					<div class="form-group sp_media">
						<a href="{{route('github.redirect')}}" class="btn btn-md full-width text-light fs-md ft-medium add_login" id="" style="background: #7441C7"><i class="fab fa-github"></i>GitHub</a>
						<a href="{{route('google.redirect')}}" class="btn btn-md full-width text-light fs-md ft-medium add_login" id="" style="background: #EA4335"><i class="fab fa-google"></i>Google</a>
						<a href="{{route('facebook.redirect')}}" class="btn btn-md full-width text-light fs-md ft-medium add_login" id="" style="background: #1877F2"><i class="fab fa-facebook"></i>Facebook</a>
						{{-- <a href="{{route('twitter.redirect')}}" class="btn btn-md full-width text-light fs-md ft-medium add_login" id="" style="background: #1877F2"><i class="fab fa-twitter"></i>Twitter</a> --}}
					</div>
				</form>
			</div>
			
			{{-- === Register === --}}
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
				<div class="mb-3 field">
					<h3>Register</h3>
					@if (session('cust_reg'))
						<span class="err_msg" style="visibility:visible">
						<p>{{session('cust_reg')}}</p></span>
					@endif
				</div>
				<form class="border p-3 rounded" action="{{route('customer.register')}}" method="POST">
					@csrf
					<div class="row">
						<div class="form-group col-md-12">
							<label>Full Name *</label>
							<input type="text" name="name" class="form-control" placeholder="Full Name" value="{{old('name')}}">
							@error('name')
								<strong class="text-danger pt-4">{{ $message }}</strong>
							@enderror
						</div>
					</div>
					
					<div class="form-group">
						<label>Email *</label>
						<input type="email" name="email" class="form-control" placeholder="Email*" value="{{old('email')}}">
						@error('email')
							<strong class="text-danger pt-4">{{ $message }}</strong>
						@enderror
					</div>
					
					<div class="row">
						<div class="form-group col-md-6">
							<label>Password *</label>
							<input type="password" name="password" class="form-control" placeholder="Password*">
							@error('password')
								<strong class="text-danger pt-4">{{ $message }}</strong>
							@enderror
						</div>
						
						<div class="form-group col-md-6">
							<label>Confirm Password *</label>
							<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password*">
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium" id="reg_btn">Create An Account</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</section>
<!-- ======================= Login End ======================== -->

@endsection



@section('footer_script')

{{-- === Register Button Loader === --}}
<script>
	$(document).ready(function () {
		$("#reg_btn").click(function () {
			$("#loader").show();
		});
		$("#login_btn").click(function () {
			$("#loader").show();
		});
	});
</script>
@endsection