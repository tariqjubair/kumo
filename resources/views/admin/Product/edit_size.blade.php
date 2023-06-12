@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product.variation')}}">Product Variation</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Size</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Product Variation: {{$size_info->size}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('size.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="size_id" value="{{$size_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Size:</label>
                        <input type="text" name="size_upd" class="form-control" value="{{$size_info->size}}">
                        @error('size_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Insert Size-Type:</label>
                        <select name="size_type" id="" class="form-control">
                            <option value=""> -- Select Type  </option>
                        @foreach ($measure_all as $measure)
                            <option {{$measure->size_type == $size_info->size_type ?'selected': ''}}
                             value="{{$measure->size_type}}">{{$measure->size_type}}</option>    
                        @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Size</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Size Updated === --}}
@if (session('size_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("size_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection