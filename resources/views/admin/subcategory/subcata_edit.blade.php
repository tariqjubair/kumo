@extends('layouts.dashboard')


@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('subcategory_list')}}">Sub-Category</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Sub-Catagory</a></li>
    </ol>
</div>

@can('category_control')
    
<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Sub-Category Info:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('subcategory.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="subcata_id" value="{{$subcata_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Select Parent Category:</label>
                        <select name="cata_id" class="form-control">
                            {{-- <option value="">--Select--</option> --}}
                            @foreach ($cata_all as $cata)
                                <option {{($cata->id == $subcata_info->cata_id)? 'selected':''}}
                                value="{{$cata->id}}">{{$cata->cata_name}}</option>
                            @endforeach
                        </select>
                        @error('cata_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Sub-Category Name:</label>
                        <input type="text" name="subcata_name_upd" class="form-control" value="{{$subcata_info->sub_cata_name}}">
                        @error('subcata_name_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Update Measure:</label>
                        <select name="measure" id="" class="form-control">
                            <option value=""> -- Select Type  </option>
                        @foreach ($measure_all as $measure)
                            <option {{$measure->size_type == $subcata_info->measure ?'selected': ''}}
                             value="{{$measure->size_type}}">{{$measure->size_type}}</option>    
                        @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Sub-Category</button>
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
@if (session('subcata_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("subcata_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection