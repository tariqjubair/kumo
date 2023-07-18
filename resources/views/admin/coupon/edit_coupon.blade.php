@extends('layouts.dashboard')

@section('header_style')
<style>
    .select2-container--default .select2-selection--multiple{
        height: 56px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        color: black;
        font-size: 0.875rem;
    }

    .select2-container .select2-search--inline .select2-search__field {
        color: #B1B1B1;
        font-size: 15px;
        margin-left: 10px;
        margin-top: 18px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-left: 10px;
        margin-top: 16px;
    }
</style>
@endsection

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('coupon_list')}}">Coupon List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Coupon</a></li>
    </ol>
</div>

@can('control_coupon')
    
<div class="row">
    <div class="col-xl-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Update Coupon:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('coupon.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="coupon_id" value="{{$coupon_info->id}}">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="item_div mb-4">
                                <label class="form-lable">* Coupon Name:</label>
                                <input type="text" name="coupon_name" class="form-control" value="{{old('coupon_name') != null ?old('coupon_name') :$coupon_info->coupon_name}}">
                                @error('coupon_name')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item_div mb-4">
                                <label class="form-lable">* Coupon Type:</label>
                                <select name="coupon_type" class="form-control">
                                    <option value="">-- Select Type</option>
                                    @foreach ($coup_type_all as $coup_type)
                                        @if (old('coupon_type'))
                                            <option {{$coup_type->id == old('coupon_type') ?'selected' :''}}
                                            value="{{$coup_type->id}}">{{$coup_type->coupon_type}}</option>
                                        @else
                                            <option {{$coup_type->id == $coupon_info->type ?'selected' :''}}
                                            value="{{$coup_type->id}}">{{$coup_type->coupon_type}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('coupon_type')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item_div mb-4">
                                <label class="form-lable">* Validity:</label>
                                <input type="date" name="validity" class="form-control" value="{{old('validity') != null ?old('validity') :$coupon_info->validity}}">
                                @error('validity')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Coupon Discount:</label>
                                <input type="number" name="disc" class="form-control" value="{{old('disc') != null ?old('disc') :$coupon_info->discount}}">
                                @error('disc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Min. Purchase: </label>
                                <input type="number" name="min_total" class="form-control" value="{{old('min_total') != null ?old('min_total') :$coupon_info->min_total}}">
                                @error('min_total')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Least Discounted Amount: (Perc. use)</label>
                                <input type="number" name="least_disc" class="form-control" value="{{old('least_disc') != null ?old('least_disc') :$coupon_info->least_disc}}">
                                @error('least_disc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Most Discounted Amount: (Perc. use)</label>
                                <input type="number" name="most_disc" class="form-control" value="{{old('most_disc') != null ?old('most_disc') :$coupon_info->most_disc}}">
                                @error('most_disc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>

                            @php
                                $sub_list = explode(",", App\Models\Coupon::find($coupon_info->id)->subcata);
                                // print_r($sub_list);
                            @endphp
                            {{-- @foreach ($sub_list as $sub)
                                {{$sub}}
                            @endforeach --}}

                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Sub Category: (Cate. use only)</label>
                                <select name="subcata[]" class="form-control select2" multiple="multiple">
                                    <option value="">-- Select Subacategories --</option>
                                    @foreach (App\Models\Subcategory::all() as $subcata)
                                        @if (old('subcata'))
                                            <option {{$subcata->id == old('subcata') ?'selected' :''}}
                                            value="{{$subcata->id}}">{{$subcata->sub_cata_name}}</option>
                                        @else
                                            <option 
                                                @foreach ($sub_list as $sub)
                                                {{$subcata->id == $sub ?'selected' :''}}
                                                @endforeach
                                            value="{{$subcata->id}}">{{$subcata->sub_cata_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('subcata')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-5 m-auto">
                            <div class="item_div mt-2 mb-4">
                                <button type="submit" class="btn btn-primary w-100">Update</button>
                            </div>
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

@section('footer_script')

{{-- === Coupon Updated === --}}
@if (session('coupon_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("coupon_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Select2 Search === --}}
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('b[role="presentation"]').hide();
        $('.select2-selection__arrow').append('<i class="fad fa-sort-up"></i>');
    });
</script>
@endsection