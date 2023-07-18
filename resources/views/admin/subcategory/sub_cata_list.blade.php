@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Sub-Catagory</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3>Sub-Category:</h3>
                <h4>Total: {{count($sub_cata_all)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="sub_cata_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Sub-Category:</th>
                            <th>Image:</th>
                            <th data-priority="3">Category Name:</th>
                            <th>Measure:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sub_cata_all as $key=>$sub_cata)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>{{$sub_cata->sub_cata_name}}</td>
                            <td><img width="35" src="{{ Avatar::create($sub_cata->sub_cata_name)->toBase64() }}" /></td>
                            <td>{{$sub_cata->relto_cata->cata_name}}</td>
                            <td>{{$sub_cata->measure}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    @can('category_control')
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('subcategory.edit', $sub_cata->id)}}">Edit</a>
                                        <a class="dropdown-item del_btn" href="{{route('subcategory.delete', $sub_cata->id)}}">Delete</a>
                                    </div>
                                    @else
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown" disabled>
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @can('category_add')
        
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Sub-Category:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('subcatagory.add')}}" method="POST">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">Select Category:</label>
                        <select name="cata_id" class="form-control">
                            <option value="">--Select--</option>
                            @foreach ($cata_all as $cata)
                                <option value="{{$cata->id}}">{{$cata->cata_name}}</option>
                            @endforeach
                        </select>
                        @error('cata_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">New Sub-Category Name:</label>
                        <input type="text" name="sub_cata_name" class="form-control" placeholder="Sub-Category Name">
                        @error('sub_cata_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Insert Measure:</label>
                        <select name="measure" id="" class="form-control">
                            <option value=""> -- Select Type  </option>
                        @foreach ($measure_all as $measure)
                            <option value="{{$measure->size_type}}">{{$measure->size_type}}</option>    
                        @endforeach
                        </select>
                        @error('size_type')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Sub-Category</button>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>

@can('category_trash')
    
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3>Trashed:</h3>
                <h4>Total: {{count($subcata_trashed)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="sub_cata_table_trashed">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Sub-Category Name:</th>
                            <th>Image:</th>
                            <th data-priority="3">Category Name:</th>
                            <th>Measure:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($subcata_trashed as $key=>$sub_cata)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>{{$sub_cata->sub_cata_name}}</td>
                            <td><img width="35" src="{{ Avatar::create($sub_cata->sub_cata_name)->toBase64() }}" /></td>
                            <td>{{$sub_cata->relto_cata->cata_name}}</td>
                            <td>{{$sub_cata->measure}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('subcategory.restore', $sub_cata->id)}}">Restore</a>
                                        <button class="dropdown-item f_del_btn" value="{{route('subcategory.force.delete', $sub_cata->id)}}">Force Delete</button>
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

@endcan
@endsection

@section('footer_script')

{{-- === Subcategory Added === --}}
@if (session('sub_cata_added'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("sub_cata_added")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#sub_cata_table').DataTable({
            responsive:true,
        });
		$('#sub_cata_table_trashed').DataTable({
            responsive:true,
        });
	} );
</script>

{{-- === Subcategory Deleted === --}}
@if (session('subcata_del'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("subcata_del")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Subcategory Force Deleted === --}}
<script>
    $('.f_del_btn').click(function(){
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
@if (session('subcata_f_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("subcata_f_del")}}',
        'success'
    )
</script>
@endif

{{-- === Subcategory Restored === --}}
@if (session('subcata_restore'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("subcata_restore")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection