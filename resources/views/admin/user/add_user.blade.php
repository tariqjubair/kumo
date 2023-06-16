@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('user_list')}}">User List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add New User</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-5 m-auto">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <a href="index.html"><img src="{{asset('dashboard/images/logo-full.png')}}" alt=""></a>
                        </div>
                        <h4 class="text-center mt-4 mb-4 text-white">Add New User:</h4>
                        <form action="{{route('insert.user')}}" method="POST">
                            @csrf
                            <input type="hidden" name="creator" value="{{Auth::id()}}">

                            <div class="form-group">
                                <label class="mb-1 text-white"><strong>Username</strong></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="username" value="{{ old('name') }}" required autocomplete="name" autofocus>
        
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1 text-white"><strong>Email</strong></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="hello@example.com" value="{{ old('email') }}" required autocomplete="email">
        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1 text-white"><strong>Password</strong></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1 text-white"><strong>Confirm Password</strong></label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn bg-white text-primary" id="user_created">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




@section('footer_script')

{{-- === Subcategory Update Alert === --}}
@if (session('msg'))
<script>
	Swal.fire(
      'Updated!',
      '<span class="text-danger">{{session("name")}}</span> {{session("msg")}}',
      'success'
    )
</script>
@endif

{{-- === Dash preloader on Submit === --}}
<script>
    $(document).ready(function () {
        $("#user_created").click(function () {
            $("#dash_loader").show();
        });
    });
</script>
@endsection