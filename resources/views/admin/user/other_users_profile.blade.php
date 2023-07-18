@extends('layouts.dashboard')

@section('header_style')
<style>
    .item_div i {
        position: absolute;
        top: 55%;
        right: 20px;
        font-size: 25px;
        transition: .3s;
    }

    .item_div i:hover {
        color: blue;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('user_list')}}">User List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">User Profile: <span class="text-danger">{{$user_info->name}}</span></a></li>
    </ol>
</div>

@can('user_control')
    
<div class="row">

    {{-- === Update User Info === --}}
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>User Info:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('other_user.info.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Name:</label>
                        <input type="text" name="name" class="form-control" value="{{$user_info->name}}">
                        @error('name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Email:</label>
                        <input type="text" name="email" class="form-control" value="{{$user_info->email}}" readonly>
                        @error('email')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Info</button>
                </form>
            </div>
        </div>
    </div>

    {{-- === Update User Pass === --}}
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Password:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('other_user.pass.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user_info->id}}">
                    <div class="item_div mb-4" style="position: relative">
                        <i class="fad fa-eye" id="pass"></i>
                        <label class="form-lable">New Password:</label>
                        <input type="password" name="password" class="form-control" id="inp2" autocomplete="new-password">
                        @error('password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4" style="position: relative">
                        <i class="fad fa-eye" id="cpass"></i>
                        <label class="form-lable">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" id="inp3" autocomplete="new-password">
                        @error('password_confirmation')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    {{-- === Update User Pic === --}}
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Profile Picture:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('other_user.pic.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Image:</label>
                        <input type="file" name="image" class="form-control" onchange="document.getElementById('balah').src=window.URL.createObjectURL(this.files[0])">
                        @error('image')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror

                        <div class="item_div m-4">
                            @if ($user_info->image != null)
                                <img width="80" height="80" id="balah" src="{{asset('uploads/user')}}/{{$user_info->image}}" alt="Profile Image">
                            @else
                                <img width="80" id="balah" src="{{ Avatar::create($user_info->name)->toBase64() }}" />
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Picture</button>
                </form>
            </div>
        </div>
    </div>
</div>

@else
<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text  font-weight-bold">403</h1>
                        <h4><i class="fa fa-times-circle text-danger"></i> Forbidden Error!</h4>
                        <p>You do not have permission to view this resource.</p>
						<div>
                            <a class="btn btn-primary" href="{{route('home')}}">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endcan
@endsection

@section('footer_script')

{{-- === Show-Pass Button === --}}
<script>
    var inp1 = document.getElementById('inp1');
    var inp2 = document.getElementById('inp2');
    var inp3 = document.getElementById('inp3');
    $('#old_pass').click(function(){
        if (inp1.type == 'password'){
            inp1.type = 'text';
        }
        else {
            inp1.type = 'password'
        }
    })
    $('#pass').click(function(){
        if (inp2.type == 'password'){
            inp2.type = 'text';
        }
        else {
            inp2.type = 'password'
        }
    })
    $('#cpass').click(function(){
        if (inp3.type == 'password'){
            inp3.type = 'text';
        }
        else {
            inp3.type = 'password'
        }
    })
</script>

{{-- === Info Update Sesstion Confirm === --}}
@if (session('info_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("info_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Pass Update Session === --}}
@if (session('pass_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("pass_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Pic Update Session === --}}
@if (session('img_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("img_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === User Notification Alert === --}}
@if (session('user_name'))
<script>
    Swal.fire(
        'Hi! {{session('user_name')}}',
        '{{session('msg')}}',
        'success'
    )
</script>
@endif
@endsection