@extends('layouts.dashboard')

@section('header_style')
<style>
    .select2-container--default .select2-selection--multiple{
        min-height: 56px !important;
        overflow: hidden !important;
        height: auto !important;
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
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Coupon</a></li>
    </ol>
</div>
<div class="row">

    {{-- === Add Coupon === --}}
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3>Add New Coupon:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('coupon.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="item_div mb-4">
                                <label class="form-lable">* Coupon Name:</label>
                                <input type="text" name="coupon_name" class="form-control" value="{{old('coupon_name')}}">
                                @error('coupon_name')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item_div mb-4">
                                <label class="form-lable">* Coupon Type:</label>
                                <select name="coupon_type" class="form-control">
                                    <option value="">-- Select Type</option>
                                    @foreach ($coup_type_all as $coup_type)
                                        <option {{$coup_type->id == old('coupon_type') ?'selected' :''}}
                                        value="{{$coup_type->id}}">{{$coup_type->coupon_type}}</option>
                                    @endforeach
                                </select>
                                @error('coupon_type')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item_div mb-4">
                                <label class="form-lable">* Validity:</label>
                                <input type="date" name="validity" class="form-control" value="{{old('validity')}}">
                                @error('validity')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Coupon Discount:</label>
                                <input type="number" name="disc" class="form-control" value="{{old('disc')}}">
                                @error('disc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Min. Purchase:</label>
                                <input type="number" name="min_total" class="form-control" value="{{old('min_total') != null ?old('min_total') :''}}">
                                @error('min_total')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Least Discounted Amount: (Perc. use)</label>
                                <input type="number" name="least_disc" class="form-control" value="{{old('least_disc')}}">
                                @error('least_disc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Most Discounted Amount: (Perc. use)</label>
                                <input type="number" name="most_disc" class="form-control" value="{{old('most_disc')}}">
                                @error('most_disc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Sub Category: (Cate. use only)</label>
                                <select name="subcata[]" class="form-control select2" multiple="multiple">
                                    <option value="">-- Select Subcategory --</option>
                                    @foreach (App\Models\Subcategory::all() as $subcata)
                                        <option {{collect(old('subcata'))->contains($subcata->id) ?'selected' :''}}
                                        value="{{$subcata->id}}">{{$subcata->sub_cata_name}}</option>
                                    @endforeach
                                </select>
                                @error('subcata')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-5 m-auto">
                            <div class="item_div mt-2 mb-4">
                                <button type="submit" class="btn btn-primary w-100">Add Coupon</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- === Coupon Type === --}}
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Coupon-Type:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('add.coupon_type')}}" method="POST">
                    @csrf
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Coupon Type:</label>
                        <input type="text" name="add_coupon_type" class="form-control" value="{{old('add_coupon_type')}}">
                        @error('add_coupon_type')
                            <strong class="text-danger err">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Color: (Optional)</label>
                        <select name="coupon_col" class="form-control">
                            <option value=""> -- Select Color-Class</option>
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
                    <div class="item_div mt-2 mb-4">
                        <button type="submit" class="btn btn-primary">Add Type</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Current Coupon Types:</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sr:</th>
                            <th>Type Name:</th>
                            <th>Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coup_type_all as $sl=>$coup_type)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$coup_type->coupon_type}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('ctype.edit', $coup_type->id)}}">Edit Type</a>
                                        <button class="dropdown-item del_ctype" value="{{route('ctype.delete', $coup_type->id)}}">Delete</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('footer_script')

{{-- === Coupon Type Added === --}}
@if (session('ctype_added'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("ctype_added")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Coupon Type Updated === --}}
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

{{-- === New Coupon Added === --}}
@if (session('coupon_added'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("coupon_added")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Coupon Type Deleted === --}}
<script>
    $('.del_ctype').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
        })
    })
</script>
@if (session('ctype_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("ctype_del")}}',
        'success'
    )
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