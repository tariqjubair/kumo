@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product_list')}}">Product List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12">

        {{-- === Add Inventory === --}}
        <div class="card">
            <div class="card-header">
                <h3>Add Inventory:</h3>
                <h4>
                    @if (session('cata_id'))
                        {{$cata_name}}=> {{$subcata_name}}<br>
                    @endif
                </h4>
            </div>
            <div class="card-body">
                <form action="{{route('add.inventory')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Product Name:</label>
                                <input type="number" name="product_id" hidden class="form-control" value="{{$product_info->id}}">
                                <input type="text" name="product_name" readonly class="form-control" value="{{$product_info->product_name}}">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Add Color:</label>
                                <select name="color" class="form-control"><option value="">-- Select Color </option>
                                    @foreach ($color_all as $color)
                                    <option value="{{$color->id}}">{{$color->color_name}}</option>
                                    @endforeach        
                                </select>
                                @error('color')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Add Size:</label>
                                <select name="size" class="form-control">
                                    <option value="">-- Select Size </option>
                                    @foreach ($avail_size as $size)
                                        <option value="{{$size->id}}">{{$size->size}}</option>
                                    @endforeach        
                                </select>
                                @error('size')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="item-div mb-4">
                                <label for="" class="form-lable">Add Quantity:</label>
                                <input type="number" name="quantity" class="form-control" value="{{old('quantity')}}">
                                @error('quantity')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <button type="submit" class="btn btn-primary">Add Product Inventory</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-12">

        {{-- === Current Inventory List === --}}
        <div class="card">
            <div class="card-header">
                <h3> <img width="80" src="{{asset('uploads/product/preview')}}/{{$product_info->preview}}" alt="Product Preview"> *Inventory=> {{$product_info->product_name}} </h3>
                <h4 class="text-right">
                    Total: {{count($inventory_info)}}
                </h4>
            </div>
            
            <div class="card-body">
                <table class="table table-stiped stripe sp_col" id="inventory_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th>Color:</th>
                            <th>Size:</th>
                            <th>Quantity:</th>
                            <th>Updated at:</th>
                            <th>Updated by:</th>
                            <th>Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventory_info as $key=>$inv)
                        <tr 
                        @if(session('repeat_entry'))
                            class="{{$inv->id == session('repeat_entry') ?'text-danger' :''}} repeated"
                        @endif
                        >
                            <td>{{$key+1}}</td>
                            <td>{{$inv->relto_color->color_name}}</td>
                            <td>{{$inv->relto_size->size}}</td>
                            <td>{{$inv->quantity}}</td>
                            <td>{{$inv->updated_at}}</td>
                            <td>{{$inv->relto_user->name}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('inv.edit', $inv->id)}}">Edit</a>
                                        <button class="dropdown-item inventory_del" value="{{route('inventory.delete', $inv->id)}}">Delete</button>
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
    <div class="col-xl-12">

        {{-- === Trashed Inventory List === --}}
        <div class="card">
            <div class="card-header">
                <h3>*Trashed=></h3>
                <h4>Total: {{count($trashed_inv_info)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-stiped stripe sp_col" id="inv_trashed_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th>Color:</th>
                            <th>Size:</th>
                            <th>Quantity:</th>
                            <th>Updated at:</th>
                            <th>Updated by:</th>
                            <th>Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashed_inv_info as $key=>$inv)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$inv->relto_color->color_name}}</td>
                            <td>{{$inv->relto_size->size}}</td>
                            <td>{{$inv->quantity}}</td>
                            <td>{{$inv->updated_at}}</td>
                            <td>{{$inv->relto_user->name}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('inv.restore', $inv->id)}}">Restore</a>
                                        <button class="dropdown-item inv_force_del" value="{{route('inv_force.delete', $inv->id)}}">Force Delete</button>
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

{{-- === Inventory Added === --}}
@if (session('inventory_add'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("inventory_add")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#inventory_table').DataTable();
	} );
	$(document).ready( function () {
		$('#inv_trashed_table').DataTable();
	} );
</script>

{{-- === Inventory Soft Deleted === --}}
<script>
    $('.inventory_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "This Inventory will be moved to Trash!",
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
@if (session('inv_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("inv_del")}}',
        'success'
    )
</script>
@endif

{{-- === Inventory Force Deleted === --}}
<script>
    $('.inv_force_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "This Inventory will be Deleted Permanently!",
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
@if (session('inv_force_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("inv_force_del")}}',
        'success'
    )
</script>
@endif

{{-- === Inventory Restored === --}}
@if (session('inv_restore'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("inv_restore")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Inventory Repeated === --}}
@if (session('repeat_inv'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops... Repeated Inventory!',
        text: '{{session("repeat_inv")}}',
        footer: '<a href="{{route('repeat.inv', session('inv_id'))}}">Go to Inventory Entry!</a>'
    })
</script>
@endif

{{-- === Scroll to Repeated Entry === --}}
@if(session('repeat_entry'))
<script>
    $(document).ready(function(){
        $("html, body").animate({ 
            scrollTop: $('.repeated').offset().top 
        }, 1000);
    });
</script>
@endif
@endsection