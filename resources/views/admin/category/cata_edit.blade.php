@extends('layouts.dashboard')


@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('category_list')}}">Category List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Category</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Category Info:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('category_info.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cata_id" value="{{$cata_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Category Name:</label>
                        <input type="text" name="cata_name_upd" class="form-control" value="{{$cata_info->cata_name}}">
                        @error('cata_name_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Category Image:</label>
                        <input type="file" name="new_category_image" class="form-control" onchange="document.getElementById('blah').src=window.URL.createObjectURL(this.files[0])">
                        @error('new_category_image')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="item_div m-4">
                            <img width="60" height="60" id="blah" src="{{asset('uploads/category')}}/{{$cata_info->cata_image}}" alt="Category Image">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
@if (session('cata_info_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("cata_info_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection