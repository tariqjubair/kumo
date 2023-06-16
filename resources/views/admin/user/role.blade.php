@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('user.profile')}}">Profile</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Role & Permissions</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>User Roll & Permissions:</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="user_roll_table">
                    <thead>
                        <tr>
                            <th data-priority="1">User Name:</th>
                            <th data-priority="2">Roll:</th>
                            <th data-priority="3" style="width: 60%">Assigned Permissions:</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr style="background: white">
                            @php
                                $user_role = $user_info->getRoleNames()->first();
                            @endphp
                            <td style="text-align: center;">
                                @auth
                                    @if (Auth::user()->image == null)
                                        <img width="40%" src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
                                    @else
                                        <img width="40%" src="{{asset('uploads/user')}}/{{Auth::user()->image}}" alt="User">
                                    @endif
                                @endauth
                                <div class="item my-2">{{$user_info->name}}</div>
                            </td>
                            <td>
                                <span class="badge badge-secondary my-1">{{$user_role ?$user_role :'User'}}</span>
                            </td>
                            <td>
                                @foreach ($user_info->getPermissionsViaRoles() as $perm)
                                    <span class="badge badge-success my-1">{{$perm->name}}</span>
                                @endforeach

                                @foreach ($user_info->getDirectPermissions() as $perm)
                                    <span class="badge badge-warning my-1">{{$perm->name}}</span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



@section('footer_script')
    
{{-- === Roll Table === --}}
<script>
	$(document).ready( function () {
		$('#user_roll_table').DataTable({
			responsive: true,
		});
	} );
</script>

{{-- === User Notification Alert === --}}
@if (session('user_name'))
<script>
    Swal.fire(
        'Hi! {{session('user_name')}}',
        '{{session('msg')}}',
        'success'
    )
</script>
@endif
@endsection