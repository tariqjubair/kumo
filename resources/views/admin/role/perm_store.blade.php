@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Assign Roles</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>Assign Permissions to Role:</h3>
                    <h4>Total: </h4>
                </div>
                <div class="card-body row">
                    <div class="col-lg-6">
                        <div id="" class="widget-media dz-scroll">
                            <ul class="timeline">
                                <li>
                                    <div class="perm_item">
                                        <div class="timeline-panel head-chk mb-2 bg-primary">
                                            <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                                <input type="checkbox" class="custom-control-input" id="customCheckBox1" required="">
                                                <label class="custom-control-label" for="customCheckBox1"></label>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mb-0 text-white">Category</h5>
                                            </div>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                    <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sub_chk row">
                                            <div class="col-lg-6">
                                                <div class="timeline-panel mb-1">
                                                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                        <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                                        <label class="custom-control-label" for="customCheckBox2"></label>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="mb-0">Category</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="timeline-panel mb-1">
                                                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                        <input type="checkbox" class="custom-control-input" id="customCheckBox1" required="">
                                                        <label class="custom-control-label" for="customCheckBox1"></label>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="mb-0">Category</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="timeline-panel mb-1">
                                                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                        <input type="checkbox" class="custom-control-input" id="customCheckBox1" required="">
                                                        <label class="custom-control-label" for="customCheckBox1"></label>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="mb-0">Category category</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="timeline-panel mb-1">
                                                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                        <input type="checkbox" class="custom-control-input" id="customCheckBox1" required="">
                                                        <label class="custom-control-label" for="customCheckBox1"></label>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="mb-0">Category</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="timeline-panel mb-1">
                                                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                        <input type="checkbox" class="custom-control-input" id="customCheckBox1" required="">
                                                        <label class="custom-control-label" for="customCheckBox1"></label>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="mb-0">Category</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </li>
                            </ul>
                        </div>
                    </div>

                    
                </div>

                <div class="card-body">
                    <div class="col-lg-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">New Roll Name:</label>
                            <input type="text" name="roll_name" class="form-control">
                            @error('roll_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h3>Add Permission:</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('category_update')}}" method="POST">
                        @csrf
                        <div class="item_div mb-4">
                            <label class="form-lable">Permission Name:</label>
                            <input type="text" name="perm_name" class="form-control">
                            @error('perm_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="item_div mb-4">
                            <label class="form-lable">Select Group:</label>
                            <select name="group_id" class="form-control">
                                <option value="">--Select--</option>
                                {{-- @foreach ($cata_all as $cata)
                                    <option value="{{$cata->id}}">{{$cata->cata_name}}</option>
                                @endforeach --}}
                            </select>
                            @error('cata_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Permission</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Add Permit Group:</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('category_update')}}" method="POST">
                        @csrf
                        <div class="item_div mb-4">
                            <label class="form-lable">New Group Name:</label>
                            <input type="text" name="perm_group" class="form-control">
                            @error('perm_group')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Group</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection