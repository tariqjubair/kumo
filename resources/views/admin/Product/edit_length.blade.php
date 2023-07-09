@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product.variation')}}">Product Variation</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Length</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Product Variation: {{$length_info->size}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('length.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="length_id" value="{{$length_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Length:</label>
                        <input type="text" name="length_upd" class="form-control" value="{{$length_info->length}}">
                        @error('length_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Length</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Color Updated === --}}
@if (session('length_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("length_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection