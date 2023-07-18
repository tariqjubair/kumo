@extends('layouts.dashboard')




@section('header_style')
<style>

    /* === Datatable Multiple Controls === */
    div.dataTables_length {
    padding-left: 2em;
    }
    div.dataTables_length, div.dataTables_filter {
        padding-top: 0.55em;
    }

    /* === Additional === */
    .dataTables_wrapper .dataTables_info {
        padding: 25px 0;
        padding-top: 0.95em;
    }
</style>
@endsection




@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product List</a></li>
    </ol>
</div>

<form action="{{route('product.cata_items')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xl-5">
            <div class="item_div mb-4">
                <label class="form-lable">Select Category Type:</label>
                <select name="cata_id" id="cata_sec" class="form-control">
                    <option value="">-- Select Category </option>
                    @foreach ($cata_all as $cata)
                        <option 
                        @if (session('cata_id'))
                            {{$cata->id == session('cata_id') ?'selected': ''}}
                        @endif
                        value="{{$cata->id}}">{{$cata->cata_name}}</option>
                    @endforeach
                </select>
                @error('cata_id')
                    <strong class="text-danger">{{$message}}</strong>
                @enderror
            </div>
        </div>
        <div class="col-xl-5">
            <div class="item_div mb-4">
                <label class="form-lable">Select Sub-Category Type:</label>
                <select name="subcata_id" id="subcata_sec" class="form-control">
                    @if (session('subcata_name'))
                        <option value="">{{session('subcata_name')}}</option>
                    @endif
                    <option value="">-- Select Sub-Category</option>
                </select>
                @error('subcata_id')
                    <strong class="text-danger">{{$message}}</strong>
                @enderror
            </div>
        </div>
        <div class="col-xl-2">
            <button type="submit" class="btn btn-primary">Get Categorized Products</button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-xl-12">
        
        {{-- === Current Products === --}}
        <div class="card">
            <div class="card-header">
                <h3>
                    @if (session('subcata_id'))
                        Product List=> [{{session('cata_name')}}: {{session('subcata_name')}}]
                        <a class="btn btn-link" href="{{route('clear.cata')}}">Reset Selection</a>
                    @else
                        Product List=> [ALL]
                    @endif
                </h3>
                <h4>Total: 
                    @if (session('cata_id'))
                        {{session('cate_product')}}
                    @else
                        {{count($product_all)}}
                    @endif
                </h4>
            </div>
            <div class="card-body">
                <form action="{{route('delete.checked')}}" method="POST" id="pro_form">
                    @csrf
                    <table class="table stripe sp_col" cellspacing="0" width="100%" id="product_table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="product_id" id="chk_all"></th>
                                <th>SL:</th>
                                <th data-priority="1">Product Name:</th>
                                <th>Price:</th>
                                <th>Discount:</th>
                                <th data-priority="3">Net Price:</th>
                                <th>Brand:</th>
                                <th>Preview:</th>
                                <th>Thumbnails:</th>
                                <th data-priority="2">Action:</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (session('subcata_id'))
                                @foreach (App\Models\Product_list::where('subcata_id', session('subcata_id'))->get() as $key=>$product)
                                    <tr style="background: white">
                                        <td><input type="checkbox" name="product_id[]" class="chk_sel" value="{{$product->id}}"></td>
                                        <td>{{$key+1}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->discount}}</td>
                                        <td>{{$product->after_disc}}</td>
                                        <td>{{$product->brand}}</td>
                                        <td>
                                            <img width="80" src="{{asset('uploads/product/preview/')}}/{{$product->preview}}" alt="Product Photo">
                                        </td>
                                        <td>
                                            @foreach (App\Models\Thumbnail::where('product_id', $product->id)->get() as $thumb)
                                                <img width="50" src="{{asset('uploads/product/thumbnails/')}}/{{$thumb->thumbnail}}" alt="Product Thumbnails">
                                            @endforeach
                                        </td>
                                        <td style="text-align: center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                                    <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('view_inventory')
                                                    <a class="dropdown-item" href="{{route('product.inventory', $product->id)}}">Inventory</a>
                                                    @endcan
                                                    @can('product_control')
                                                    <a class="dropdown-item edt_btn" href="{{route('product.edit', $product->id)}}">Edit</a>
                                                    <button type="button" class="dropdown-item product_del" value="{{route('product.delete', $product->id)}}">Delete</button>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            @else 
                                @foreach ($product_all as $key=>$product)
                                <tr style="background: white">
                                    <td><input type="checkbox" name="product_id[]" class="chk_sel" value="{{$product->id}}"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->discount}}</td>
                                    <td>{{$product->after_disc}}</td>
                                    <td>{{$product->brand}}</td>
                                    <td>
                                        <img width="80" src="{{asset('uploads/product/preview/')}}/{{$product->preview}}" alt="Product Photo">
                                    </td>
                                    <td>
                                        @foreach (App\Models\Thumbnail::where('product_id', $product->id)->get() as $thumb)
                                            <img width="50" src="{{asset('uploads/product/thumbnails/')}}/{{$thumb->thumbnail}}" alt="Product Thumbnails">
                                        @endforeach
                                    </td>
                                    <td style="text-align: center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                                <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('view_inventory')
                                                <a class="dropdown-item" href="{{route('product.inventory', $product->id)}}">Inventory</a>
                                                @endcan
                                                @can('product_control')
                                                <a class="dropdown-item edt_btn" href="{{route('product.edit', $product->id)}}">Edit</a>
                                                <button type="button" class="dropdown-item product_del" value="{{route('product.delete', $product->id)}}">Delete</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    @can('product_control')
                    <button type="button" class="btn btn-warning d-none product_chk_del" id="chk_del">Delete All-Checked</button>
                    @endcan
                </form>

            </div>
        </div>

        {{-- === Trashed Products === --}}
        <div class="card">
            <div class="card-header">
                <h3>Trashed Products</h3>
                <h4>Total: {{count($product_trashed)}}</h4>
            </div>
            <div class="card-body">
                <form action="{{route('fdel.checked')}}" method="POST" id="pro_tr_form">
                    @csrf
                    <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="product_trash_table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="product_id" id="chk_tr_all"></th>
                                <th>SL:</th>
                                <th data-priority="1">Product Name:</th>
                                <th>Price:</th>
                                <th>Discount:</th>
                                <th data-priority="3">After Discount:</th>
                                <th>Brand:</th>
                                <th>Preview:</th>
                                <th>Thumbnails:</th>
                                <th data-priority="2">Action:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_trashed as $key=>$product)
                            <tr style="background: white">
                                <td><input type="checkbox" name="product_id[]" class="chk_tr_sel" value="{{$product->id}}"></td>
                                <td>{{$key+1}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->discount}}</td>
                                <td>{{$product->after_disc}}</td>
                                <td>{{$product->brand}}</td>
                                <td>
                                    <img width="80" src="{{asset('uploads/product/preview/')}}/{{$product->preview}}" alt="Product Photo">
                                </td>
                                <td>
                                    @foreach (App\Models\Thumbnail::where('product_id', $product->id)->get() as $thumb)
                                        <img width="50" src="{{asset('uploads/product/thumbnails/')}}/{{$thumb->thumbnail}}" alt="Product Thumbnails">
                                    @endforeach
                                </td>
                                <td style="text-align: center">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                            <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('product_control')
                                            <a class="dropdown-item edt_btn" href="{{route('product.restore', $product->id)}}">Restore</a>
                                            <button type="button" class="dropdown-item product_force_del" value="{{route('product.force_delete', $product->id)}}">Force Delete</button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @can('product_control')
                    <button class="btn btn-success d-none chk_tr_btn" formaction="{{route('restore.checked')}}">Restore Checked</button>
                    <button type="button" class="btn btn-danger d-none chk_tr_btn product_chk_tr_del">Force Delete Checked</button>
                    @endcan
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

{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#product_table').DataTable({
            responsive:true,
            dom: '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
        });
		$('#product_trash_table').DataTable({
            responsive:true,
        });
	} );
</script>

{{-- === Product Deleted === --}}
<script>
    $('.product_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Product will be moved to Trash!",
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
@if (session('product_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("product_del")}}',
        'success'
    )
</script>
@endif

{{-- === Product Force_Deleted === --}}
<script>
    $('.product_force_del').click(function(){
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
@if (session('product_force_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("product_force_del")}}',
        'success'
    )
</script>
@endif

{{-- === Product Restored === --}}
@if (session('product_restore'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("product_restore")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Cata Selection Cleared === --}}
@if (session('clear_cata'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("clear_cata")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Check ALL ==== --}}
<script>
    $('#chk_all').on('click', function(){
        // $('#chk_del').toggleClass('d-none');
        this.checked ?$('.chk_sel').prop('checked', true) :$('.chk_sel').prop('checked', false);
        var check = $("input:checkbox:checked").length

        if(check != 0){
            $('#chk_del').removeClass('d-none');
        }
        else {
            $('#chk_del').addClass('d-none');
        }
    })

    $('.chk_sel').on('click', function(){
        // $('#chk_del').toggleClass('d-none');
        var check = $("input:checkbox:checked").length
        
        if(check != 0){
            $('#chk_del').removeClass('d-none');
        }
        else {
            $('#chk_del').addClass('d-none');
        }
    })
</script>

{{-- === Checked=> Product Deleted === --}}
<script>
    $('.product_chk_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Product & all of it's inventorires will be moved to Trash!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('pro_form').submit();
            }
        })
    })
</script>
@if (session('product_chk_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("product_chk_del")}}',
        'success'
    )
</script>
@endif

{{-- === Trashed Checked === --}}
<script>
    $('#chk_tr_all').on('click', function(){
        $('.chk_tr_btn').toggleClass('d-none');
        this.checked ?$('.chk_tr_sel').prop('checked', true) :$('.chk_tr_sel').prop('checked', false);
        var check = $("input:checkbox:checked").length

        if(check != 0){
            $('.chk_tr_btn').removeClass('d-none');
        }
        else {
            $('.chk_tr_btn').addClass('d-none');
        }
    })

    $('.chk_tr_sel').on('click', function(){
        $('.chk_tr_btn').toggleClass('d-none');
        var check = $("input:checkbox:checked").length

        if(check != 0){
            $('.chk_tr_btn').removeClass('d-none');
        }
        else {
            $('.chk_tr_btn').addClass('d-none');
        }
    })
</script>



{{-- === Checked=> Product Hard Deleted === --}}
<script>
    $('.product_chk_tr_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Product & all of it's inventorires will be removed Permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#pro_tr_form').submit();
            }
        })
    })
</script>
@if (session('product_chk_force_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("product_chk_force_del")}}',
        'success'
    )
</script>
@endif






@endsection