@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Manage Roles</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>Manage Rolls:</h3>
                    <h4>Total: </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="roll_table">
                        <thead>
                            <tr>
                                <th>SL:</th>
                                <th data-priority="1">Roll:</th>
                                <th data-priority="3" style="width: 60%">Assigned Permissions:</th>
                                <th data-priority="2">Action:</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($roles_all as $key=>$role)
                                <tr style="background: white">
                                    <td style="text-align: center">{{$key+1}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @foreach ($role->getAllPermissions()->orderBy('name') as $perm)
                                            <span class="badge badge-success my-1">{{$perm->name}}</span>
                                        @endforeach
                                    </td>
                                    <td style="text-align: center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                                <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edt_btn" href="">Edit</a>
                                                <button class="dropdown-item f_del_btn" value="">Delete</button>
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
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h3>Assign Role:</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf

                        <div class="item_div mb-4">
                            <label class="form-lable">Select User:</label>
                            <select name="user_id" class="form-control">
                                <option value="">--Select--</option>
                                {{-- @foreach ($cata_all as $cata)
                                    <option value="{{$cata->id}}">{{$cata->cata_name}}</option>
                                @endforeach --}}
                            </select>
                            @error('user_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="item_div mb-4">
                            <label class="form-lable">Select Roll:</label>
                            <select name="roll_id" class="form-control">
                                <option value="">--Select--</option>
                                {{-- @foreach ($cata_all as $cata)
                                    <option value="{{$cata->id}}">{{$cata->cata_name}}</option>
                                @endforeach --}}
                            </select>
                            @error('roll_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('footer_script')

{{-- === Roll Table === --}}
<script>
	$(document).ready( function () {
		$('#roll_table').DataTable({
			responsive: true,
		});
	} );
</script>
@endsection