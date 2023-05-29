@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('perm.store')}}">Assign Roles</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Permissions</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Update Permissions:</h3>
                </div>
                <div class="card-body row">
                    <div class="col-lg-12">
                        <div class="item_div mb-4">
                            <label class="form-lable">Category Name:</label>
                            <input type="text" name="perm_cate" class="form-control">
                            @error('perm_cate')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-lable">Permission Names:</label>
                    </div>
                    <div class="col-lg-6">
                        <div class="item_div mb-4">
                            <input type="text" name="perm_name" class="form-control">
                            @error('perm_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item_div mb-4">
                            <input type="text" name="perm_name" class="form-control">
                            @error('perm_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item_div mb-4">
                            <input type="text" name="perm_name" class="form-control">
                            @error('perm_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Update List</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection