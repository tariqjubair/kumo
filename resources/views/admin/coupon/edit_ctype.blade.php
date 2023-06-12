@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('add.coupon')}}">Add Coupon</a></li>
        <li class="breadcrumb-item"><a href="{{route('coupon_list')}}">Coupon List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Coupon-Type</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Update Type-Name:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('ctype.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="ctype_id" value="{{$ctype_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Coupon-Type:</label>
                        <input type="text" name="ctype_upd" class="form-control" value="{{old('ctype_upd') != null ?old('ctype_upd') :$ctype_info->coupon_type}}">
                        @error('ctype_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Color: (Optional)</label>
                        <select name="coupon_col" class="form-control">
                            <option value="{{$ctype_info->id}}">{{$ctype_info->color}}</option>
                            <option value="">N/A</option>
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary</option>
                            <option value="success">Success</option>
                            <option value="danger">Danger</option>
                            <option value="warning">Warning</option>
                            <option value="info">Info</option>
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                        @error('add_coupon_type')
                            <strong class="text-danger err">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Coupon-Type Updated === --}}
@if (session('ctype_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("ctype_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection