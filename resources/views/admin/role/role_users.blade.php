@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('role.store')}}">Manage Roles</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Assigned Users</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Assigned Users:</h3>
                    <h4>Total: {{$user_with_roles->count()}}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="roll_user_table">
                        <thead>
                            <tr>
                                <th>SL:</th>
                                <th data-priority="1">User:</th>
                                <th data-priority="3" style="width: 60%">Assigned Roles:</th>
                                <th data-priority="2">Action:</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- @foreach ($role_users as $sl=>$role_u) --}}
                                {{-- @foreach ($users_all->where('id', $role_u) as $key=>$user) --}}
                                @foreach ($user_with_roles as $key=>$user)
                                    <tr style="background: white">
                                        <td style="text-align: center">{{$key+1}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>
                                            @foreach ($user->getRoleNames() as $role)
                                                <span class="badge badge-danger my-1">{{$role}}</span>
                                            @endforeach
                                            @foreach ($user->getPermissionNames() as $perm)
                                                <span class="badge badge-success my-1">{{$perm}}</span>
                                            @endforeach
                                        </td>
                                        <td style="text-align: center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                                    <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item edt_btn" href="{{route('user_role.edit', $user->id)}}">Edit</a>
                                                    <button class="dropdown-item remove_role" value="{{route('user_role.remove', $user->id)}}">Remove</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('footer_script')

{{-- === User Table === --}}
<script>
	$(document).ready( function () {
		$('#roll_user_table').DataTable({
			responsive: true,
		});
	} );
</script>

{{-- === Role Remove Confirm Session === --}}
<script>
    $('.remove_role').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Role will be dismissed from User!",
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
@endsection