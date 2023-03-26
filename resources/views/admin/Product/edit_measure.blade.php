@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product.variation')}}">Product Variation</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Measure</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Size-Type: {{$measure_info->size_type}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('measure.update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="measure_id" value="{{$measure_info->id}}">
                        <div class="item_div mb-4">
                            <label class="form-lable">Update Measure:</label>
                            <input type="text" name="measure_upd" class="form-control" value="{{$measure_info->size_type}}">
                            @error('measure_upd')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Measure</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Measure Updated === --}}
@if (session('measure_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("measure_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection