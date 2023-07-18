@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product_list')}}">Product List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Product</a></li>
    </ol>
</div>

@can('product_control')
    
<div class="row">
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header d-block">
                <h3><img width="80" src="{{asset('uploads/product/preview')}}/{{$product_info->preview}}" alt="Product Preview"> *Product: {{$product_info->product_name}}</h3><br>
                <h4>{{$cata_name}}=> {{$subcata_name}}</h4>
            </div>
            <div class="card-body">
                <form action="{{route('product.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="product_id" value="{{$product_info->id}}">
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Category:</label>
                        <select name="cata_id" id="cata_sec" class="form-control">
                            @foreach ($cata_all as $cata)
                                <option {{$cata->id == $product_info->cata_id ?'selected' :''}}
                                    @if (old('cata_id'))
                                        {{$cata->id == old('cata_id') ?'selected' :''}}
                                    @endif
                                value="{{$cata->id}}">{{$cata->cata_name}}</option>
                            @endforeach
                        </select>
                        @error('cata_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Sub-Category:</label>
                        <select name="subcata_id" id="subcata_sec" class="form-control">
                            @foreach ($subcata_info as $subcata)
                                <option {{$subcata->id == $product_info->subcata_id ?'selected' :''}}
                                    @if (old('subcata_id'))
                                        {{$subcata->id == old('subcata_id') ?'selected' :''}}
                                    @endif
                                value="{{$subcata->id}}">{{$subcata->sub_cata_name}}</option>
                            @endforeach
                        </select>
                        @error('subcata_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Name:</label>
                        <input type="text" name="product_name" class="form-control" value="{{old('product_name') != null ?old('product_name') :$product_info->product_name}}">
                        @error('product_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Price:</label>
                        <input type="number" name="price_upd" class="form-control" value="{{old('price_upd') != null ?old('price_upd') :$product_info->price}}">
                        @error('price_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Update Discount:</label>
                        <input type="number" name="disc_upd" class="form-control" value="{{old('disc_upd') != null ?old('disc_upd') :$product_info->discount}}">
                        @error('disc_upd')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Brand:</label>
                        <input type="text" name="brand" class="form-control" value="{{old('brand') != null ?old('brand') :$product_info->brand}}">
                        @error('brand')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Preview:</label>
                        <input type="file" name="preview" class="form-control" onchange="document.getElementById('blah').src=window.URL.createObjectURL(this.files[0])">
                        @error('preview')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="item_div m-4">
                            <img width="80" id="blah" 
                            src="{{asset('uploads/product/preview')}}/{{$product_info->preview}}" alt="Product Preview">
                        </div>
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Thumbnails:</label>
                        <input type="file" name="thumbnails[]" class="form-control" multiple onchange="loadFile(event)">
                        @error('thumbnails')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="item_div m-4" id="output">
                            @foreach (App\Models\Thumbnail::where('product_id', $product_info->id)->get() as $thumb)
                                <img width="80" id="blah2" src="{{asset('uploads/product/thumbnails')}}/{{$thumb->thumbnail}}" alt="Thumbnail">
                            @endforeach
                        </div>
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Short-Description:</label>
                        <input type="text" name="short_desc" class="form-control" value="{{old('short_desc') != null ?old('short_desc') :$product_info->short_desc}}">
                        @error('short_desc')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="item_div mb-4">
                        <label class="form-lable">Update Long-Description:</label>
                        <textarea name="long_desc" class="form-control" id="long_desc" cols="30" rows="10">         
                            {{old('long_desc') != null ?old('long_desc') :$product_info->long_desc}}</textarea>
                        @error('long_desc')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Product</button>
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

{{-- === Product Updated === --}}
@if (session('product_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("product_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Auto Subcategory Dropdown values === --}}
<script>
    $('#cata_sec').change(function(){
        var cata_id = $(this).val();
        // alert(cata_id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax ({
            url: '/get_subcata',
            type: 'POST',
            data: {'cata_id': cata_id},
            
            success: function(data){
                $('#subcata_sec').html(data);
            }
        })
    })
</script>

{{-- === Thumbnail Multiple Image Onchange === --}}
<script>
    const img = (src) => `<img src=${src} width="80px"/>`;

    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.innerHTML = '';

        [...event.target.files].forEach(
            (file) => (output.innerHTML += img(URL.createObjectURL(file)))
        );
    }; 
</script>
@endsection
