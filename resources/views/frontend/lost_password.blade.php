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
                        <li class="breadcrumb-item active" aria-current="page">Lost Password</li>
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
					<h3>Lost Password:</h3>
					@if (session('inv_mail'))
						<span class="err_msg" style="visibility:visible; background: red;">
						<p>{{session('inv_mail')}}</p></span>
					@endif
					@if (session('success_msg'))
						<span class="err_msg bg-info" style="visibility:visible">
						<p>{{session('success_msg')}}</p></span>
					@endif
					@if (session('success2'))
						<span class="err_msg err_msg_log" style="visibility:visible">
						<p>{{session('success2')}}</p></span>
					@endif
				</div>

				<form class="border p-3 rounded" action="{{route('email.verify')}}" method="POST">
					@csrf				
					<div class="form-group">
						<label>Enter Email *</label>
						<input type="email" name="email" class="form-control" placeholder="Email*">
						@error('email')
							<strong class="text-danger">{{ $message }}</strong>
						@enderror
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium" id="email_submit_btn">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>
</section>

@endsection



@section('footer_script')

{{-- === Submit Button Preloader === --}}
<script>
	$(document).ready(function () {
		$("#email_submit_btn").click(function () {
			$("#loader").show();
		});
	});
</script>
@endsection
