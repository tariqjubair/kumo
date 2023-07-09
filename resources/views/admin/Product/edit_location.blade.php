@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('charge.delivery')}}">Delivery Charges</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Delivery Location</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit Delivery Location: </h3>
            </div>
            <div class="card-body">
                <form action="{{route('update.charge')}}" method="POST">
                    @csrf
                    <input type="hidden" name="charge_id" value="{{$charge_all->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Location:</label>
                        <input type="text" name="location" class="form-control" value="{{$charge_all->location}}">
                        @error('location')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Delivery Charge:</label>
                        <input type="text" name="delivery_charge" class="form-control" value="{{$charge_all->charge}}">
                        @error('delivery_charge')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Info</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Location Updated === --}}
@if (session('loc_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("loc_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection