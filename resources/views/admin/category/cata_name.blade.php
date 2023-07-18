@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Catagory List</a></li>
    </ol>
</div>
<div class="row">

    {{-- === Catagory List === --}}
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3>Categories:</h3>
                <h4>Total: {{count($categories)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="cata_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="3">Category Image:</th>
                            <th data-priority="1">Category Name:</th>
                            <th>Added By:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categories as $key=>$cata)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>
                                <img width="60" height="60" src="{{asset('uploads/category')}}/{{$cata->cata_image}}" alt="Category">
                            </td>
                            <td>{{$cata->cata_name}}</td>
                            <td>{{$cata->relto_user ?$cata->relto_user->name :'Other User'}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    @can('category_control')
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('category.edit', $cata->id)}}">Edit</a>
                                        <button class="dropdown-item del_btn" value="{{route('category.delete', $cata->id)}}">Delete</button>
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

    {{-- === Add Category === --}}
    @can('category_add')
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Category:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('category_update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">New Category Name:</label>
                        <input type="text" name="cata_name" class="form-control">
                        @error('cata_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Category Image:</label>
                        <input type="file" name="cata_image" class="form-control">
                        @error('cata_image')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>

@can('category_trash')
    
<div class="row">
    {{-- === Trashed Catagory === --}}
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3>Trashed :</h3>
                <h4>Total: {{count($cata_trashed)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="trashed_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="3">Category Image:</th>
                            <th data-priority="1">Category Name:</th>
                            <th>Added By:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($cata_trashed as $key=>$cata)
                        <tr style="background: white">
                            <td>{{$key+1}}</td>
                            <td>
                                <img width="60" height="60" src="{{asset('uploads/category')}}/{{$cata->cata_image}}" alt="Category">
                            </td>
                            <td>{{$cata->cata_name}}</td>
                            <td>{{$cata->relto_user ?$cata->relto_user->name :'Other User'}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('category.restore', $cata->id)}}">Restore</a>
                                        <button class="dropdown-item f_del_cata" value="{{route('category.force_delete', $cata->id)}}">Force Delete</button>
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

{{-- === Category Added Confirm Session === --}}
@if (session('cata_upd'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("cata_upd")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Category Deleted Confirm Session === --}}
<script>
    $('.del_btn').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "This Catagory will move to Trash!",
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
@if (session('cata_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("cata_del")}}',
        'success'
    )
</script>
@endif

{{-- === Catagory Restored Confirm Session === --}}
@if (session('cata_restore'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("cata_restore")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Force Delete Confirm Session === --}}
<script>
    $('.f_del_cata').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "This Catagory will be deleted Permanently!",
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
@if (session('cata_f_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("cata_f_del")}}',
        'success'
    )
</script>
@endif

{{-- === Table Search === --}}
<script>
    $(document).ready( function () {
        $('#cata_table').DataTable({
            responsive: true,
        });
        $('#trashed_table').DataTable({
            responsive: true,
        });
    } );
</script>
@endsection