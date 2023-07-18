@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product.variation')}}">Product Variation</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Color</a></li>
    </ol>
</div>

@can('control_variation')
    
<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Product Variation: {{$color_info->color_name}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('color.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="color_id" value="{{$color_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Color-Name:</label>
                        <input type="text" name="color_upd" class="form-control" value="{{$color_info->color_name}}">
                        @error('color_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Code:</label>
                        <input type="text" name="code_upd" class="form-control" value="{{$color_info->color_code}}">
                        @error('code_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Color</button>
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

{{-- === Color Updated === --}}
@if (session('color_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("color_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection