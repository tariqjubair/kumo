@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Site Settings</a></li>
    </ol>
</div>

@can('site_info_update')
    
<div class="row">
    <div class="col-xl-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Site Info</h3>
            </div>
            <div class="card-body">
                <form action="{{route('siteinfo.store')}}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf

                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Name:</label>
                            <input type="text" name="site_name" class="form-control" value="{{old('site_name') ?old('site_name') :$site_info->site_name}}">
                            @error('site_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Email:</label>
                            <input type="email" name="site_email" class="form-control" value="{{old('site_email') ?old('site_email') :$site_info->site_email}}">
                            @error('site_email')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Phone Code:</label>
                            <input type="text" name="site_ph_code" class="form-control" value="{{old('site_ph_code') ?old('site_ph_code') :$site_info->site_ph_code}}">
                            @error('site_ph_code')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Phone:</label>
                            <input type="number" name="site_phone" class="form-control" value="{{old('site_phone') ?old('site_phone') :$site_info->site_phone}}">
                            @error('site_phone')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Icon: (100 * 100 px)</label>
                            <input type="file" name="site_icon" class="form-control" onchange="document.getElementById('balah').src=window.URL.createObjectURL(this.files[0])">
                            @error('site_icon')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror

                            <div class="item_div m-4">
                                @if ($site_info->site_icon)
                                    <img width="50" height="50" id="balah" src="{{asset('assets/img/logo/')}}/{{$site_info->site_icon}}" alt="Site Icon">
                                @else
                                    <img width="50" height="50" id="balah" src="{{asset('assets/img/site_logo.png')}}"alt="Site Icon">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Logo: (400 * 100 px)</label>
                            <input type="file" name="site_logo" class="form-control" onchange="document.getElementById('balah2').src=window.URL.createObjectURL(this.files[0])">
                            @error('site_logo')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror

                            <div class="item_div m-4">
                                @if ($site_info->site_logo)
                                    <img height="50" id="balah2" src="{{asset('assets/img/logo/')}}/{{$site_info->site_logo}}" alt="Logo">
                                @else
                                    <img height="50" id="balah2" src="{{asset('assets/img/logo.png')}}" alt="Logo">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Address Line 1:</label>
                            <input type="text" name="site_add1" class="form-control" value="{{old('site_add1') ?old('site_add1') :$site_info->site_add1}}">
                            @error('site_add1')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="item_div mb-4">
                            <label class="form-lable">Site Address Line 2:</label>
                            <input type="text" name="site_add2" class="form-control" value="{{old('site_add2') ?old('site_add2') :$site_info->site_add2}}">
                            @error('site_add2')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-3 m-auto">
                        <div class="item_div text-center mt-2 mb-4">
                            <button type="submit" class="btn btn-primary">Update Info</button>
                        </div>
                    </div>
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