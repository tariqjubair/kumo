@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product_list')}}">Product List</a></li>
        <li class="breadcrumb-item"><a href="{{route('product.inventory', $product_info->id)}}">Inventory</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Inventory</a></li>
    </ol>
</div>

@can('inventory_control')
    
<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3> <img width="80" src="{{asset('uploads/product/preview')}}/{{$product_info->preview}}" alt="Product Preview"> *Product=> {{$product_info->product_name}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('inv.update')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <input type="hidden" name="inv_id" value="{{$inv_info->id}}">
                            <div class="item_div mb-4">
                                <label class="form-lable">Product Color:</label>
                                <input type="text" class="form-control" value="{{$inv_info->relto_color->color_name}}" readonly>
                                {{-- <select name="color_upd" class="form-control">
                                    <option value="">-- Select Color</option>
                                    @foreach ($color_all as $color)
                                        <option {{($color->id == $inv_info->color) ?'selected': ' '}} 
                                        value="{{$color->id}}">{{$color->color_name}}</option>
                                    @endforeach
                                </select>
                                @error('color_upd')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror --}}
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Product Size:</label>
                                <input type="text" class="form-control" value="{{$inv_info->relto_size->size}}" readonly>
                                {{-- <select name="size_upd" class="form-control">
                                    <option value="">-- Select Size </option>
                                    @foreach ($avail_size as $size)
                                        <option {{($size->id == $inv_info->size) ?'selected': ' '}}
                                        value="{{$size->id}}">{{$size->size}}</option>
                                    @endforeach        
                                </select>
                                @error('size')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror --}}
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="item_div mb-4">
                                <label class="form-lable">Update Quantity:</label>
                                <input type="number" name="quantity_upd" class="form-control" value="{{$inv_info->quantity}}">
                                @error('quantity_upd')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Inventory</button>
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

{{-- === Inventory Updated === --}}
@if (session('inv_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("inv_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection