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
                        <li class="breadcrumb-item"><a href="{{route('customer_login')}}">Login-Register</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Lost Password ======================== -->
<section class="middle">
	<div class="container">
		<div class="row align-items-start justify-content-center" style="margin-bottom: 30px">
		
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
				<div class="mb-3 field">
					<h3>Reset Password:</h3>
					@if (session('expired'))
						<span class="err_msg" style="visibility:visible; background: red;">
						<p>{{session('expired')}}</p></span>
					@endif
					@if (session('inv_user'))
						<span class="err_msg" style="visibility:visible; background: red;">
						<p>{{session('inv_user')}}</p></span>
					@endif
					@if (session('success_msg'))
						<span class="err_msg" style="visibility:visible">
						<p>{{session('success_msg')}}</p></span>
					@endif
				</div>

                @if (session('success_msg'))
                    <div class="form-group">
                        <h5 style="color: blue">Password has been reset Successfully!</h5>
                        <a href="{{route('customer_login')}}" class="btn btn-md bg-dark text-light fs-md ft-medium m-auto">Go To Login</a>
                    </div>
                @else
                    <form class="border p-3 rounded" action="{{route('reset.pass')}}" method="POST">
                        @csrf
                        <input type="hidden" name="reset_token" value="{{$token_info ?$token_info->token :old('reset_token')}}">
                        
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{$token_info 
                            ?$token_info->relto_cust->name :old('name')}}" readonly>
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
                            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium" id="pass_reset_btn">Submit</button>
                        </div>
                    </form>
                @endif
			</div>
        </div>
    </div>
</section>

@endsection



@section('footer_script')

{{-- === Submit Button Preloader === --}}
<script>
	$(document).ready(function () {
		$("#pass_reset_btn").click(function () {
			$("#loader").show();
		});
	});
</script>
@endsection
