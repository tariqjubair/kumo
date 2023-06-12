@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product_list')}}">Product List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Product</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Add New Product:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">

                            {{-- === Select Cata === --}}
                            <div class="item_div mb-4">
                                <label class="form-lable">* Select Category Type:</label>
                                <select name="cata_id" id="cata_sec" class="form-control">
                                    <option value="">-- Select Category</option>
                                    @foreach ($cata_all as $cata)
                                        <option {{$cata->id == old('cata_id') ?'selected' :''}}
                                            value="{{$cata->id}}">{{$cata->cata_name}}</option>
                                    @endforeach
                                </select>
                                @error('cata_id')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- === Select Subcata === --}}
                            <div class="item_div mb-4">
                                <label class="form-lable">* Select Sub-Category Type:</label>
                                
                                @php
                                    $new_subcata = App\Models\Subcategory::where('cata_id', old('cata_id'))->get();
                                @endphp

                                @if(old('cata_id'))
                                    {{-- Old cata selected --}}
                                    @if (old('subcata_id'))
                                        {{-- Old cata + subcata selected --}}
                                        <select name="subcata_id" class="form-control">
                                            <option value="">-- Select Sub-Category</option>
                                            @foreach ($new_subcata as $scata)
                                                <option {{$scata->id == old('subcata_id') ?'selected' :''}}
                                                value="{{$scata->id}}">{{$scata->sub_cata_name}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{-- Only Old Cata selected (no subcata) --}}
                                        <select name="subcata_id" class="form-control">
                                            <option value="">-- Select Sub-Category</option>
                                            @foreach ($new_subcata as $scata)
                                                <option value="{{$scata->id}}">{{$scata->sub_cata_name}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                @else
                                    {{-- normal or Ajax --}}
                                    <select name="subcata_id" id="subcata_sec" class="form-control">
                                        <option value="{{old('subcata_id')}}">
                                        {{old('subcata_id') != null 
                                        ?App\Models\Subcategory::find(old('subcata_id'))->sub_cata_name 
                                        :'-- Select Sub-Category'}}
                                        </option>
                                    </select>
                                @endif

                                @error('subcata_id')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Product Name</label>
                                <input type="text" name="product_name" class="form-control" value="{{old('product_name')}}">
                                @error('product_name')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Product Price</label>
                                <input type="number" name="price" class="form-control" value="{{old('price')}}">
                                @error('price')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Discount(%)</label>
                                <input type="text" name="discount" class="form-control" 
                                style="color: transparent" id="disc_inp"
                                value="{{old('discount') != null ?old('discount') :'0'}}">
                                @error('discount')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Brand</label>
                                <input type="text" name="brand" class="form-control" value="{{old('brand')}}">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Preview</label>
                                <input type="file" name="preview" class="form-control">
                                @error('preview')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Thumbnails</label>
                                <input type="file" name="thumbnails[]" multiple class="form-control">
                                @error('thumbnails')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror

                                @error('thumbnails.*')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror

                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">* Short Description</label>
                                <input type="text" name="short_desc" class="form-control" value="{{old('short_desc')}}">
                                @error('short_desc')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Long Description</label>
                                <textarea name="long_desc" class="form-control" id="long_desc" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-5 m-auto">
                            <div class="item_div mt-2 mb-4">
                                <button type="submit" class="btn btn-primary w-100">Add Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('footer_script')

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

{{-- === Summernote HTML Editor ===  --}}
<script>
    $(document).ready(function() {
        $('#long_desc').summernote();
    });
</script>

{{-- === Product Added === --}}
@if (session('product_add'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("product_add")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Scroll to Error === --}}
<script>
    $('.err').show(function(){
        $(document).ready(function(){
            $("html, body").animate({ 
                scrollTop: $('.err').offset().top 
            }, 10);
        });
    })
</script>

{{-- === Discount Input Visible: On-click === --}}
<script>
    $('#disc_inp').click(function(){
        $(this).css("color", "#000");
    })
</script>


@endsection