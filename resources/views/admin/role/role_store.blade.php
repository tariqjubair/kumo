@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Manage Roles</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-9">
        <div class="card">
            <div class="card-header">
                <h3>Manage Rolls:</h3>
                <h4>Total: {{$roles_all->count() - 1}}</h4>
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
                        @foreach ($roles_all->where('name', '!=', 'Super Admin') as $key=>$role)
                            <tr style="background: white">
                                <td style="text-align: center">{{$key+1}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    @foreach ($role->getAllPermissions() as $perm)
                                        <span class="badge badge-success my-1">{{$perm->name}}</span>
                                    @endforeach
                                </td>
                                <td style="text-align: center">
                                    <div class="dropdown">
                                        @can('roles_control')
                                        <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                            <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edt_btn" href="{{route('role.edit', $role->id)}}">Edit</a>
                                            <button class="dropdown-item del_role" value="{{route('role.delete', $role->id)}}"
                                                @if ($role->name == 'Admin')
                                                @if (Auth::user()->getRoleNames()->first() != 'Super Admin')
                                                    {{'disabled'}}
                                                @endif
                                            @endif>Delete</button>
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

    @can('roles_control')
        
    <div class="col-xl-3">
        <div class="card">
            <div class="card-header">
                <h3>Assign Role:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('role.assign')}}" method="POST">
                    @csrf

                    <div class="item_div mb-4">
                        <label class="form-lable">Select User:</label>
                        <select name="user_id" class="form-control">
                            <option value="">--Select--</option>
                            @foreach ($user_all as $user)
                                <option {{$user->id == old('user_id') ?'selected' :''}} value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Select Roll:</label>
                        <select name="role_id" class="form-control">
                            <option value="">--Select--</option>
                            @foreach ($roles_all as $role)
                                <option {{$role->id == old('role_id') ?'selected' :''}} value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button class="btn btn-primary" id="assign_role_btn">Assign Role</button>
                </form>
            </div>
        </div>
    </div>
    @endcan
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

{{-- === Role Deleted Confirm Session === --}}
<script>
    $('.del_role').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Role will be Deleted Permanently!",
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

{{-- === Dash preloader on Submit === --}}
<script>
    $(document).ready(function () {
        $("#assign_role_btn").click(function () {
            $("#dash_loader").show();
        });
    });
</script>
@endsection