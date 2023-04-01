@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">User List</a></li>
    </ol>
</div>
<div class="container-fluid">
    <div class="row">

        {{-- === User List === --}}
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3>Admin/User List</h3>
                    <h4>Total: {{count($all_user)}}</h4>
                </div>
                <div class="card-body">
                    <table class="table stripe sp_col" cellspacing="0" width="100%" id="user_table">
                        <thead>
                            <tr>
                                <th>SL:</th>
                                <th>Profile Pic:</th>
                                <th data-priority="1">Name of User:</th>
                                <th data-priority="3">Email:</th>
                                <th>Created At:</th>
                                <th data-priority="2">Action:</th>
                            </tr>   
                        </thead>
                        <tbody>
                            @foreach ($all_user as $key=>$user)
                            <tr style="background: white">
                                <td style="text-align: center">{{$key+1}}</td>
                                <td>
                                    @auth
                                        @if ($user->image == null)
                                            <img width="60" src="{{ Avatar::create($user->name)->toBase64() }}" />
                                        @else
                                            <img width="60" height="60" src="{{asset('uploads/user')}}/{{$user->image}}" alt="User">
                                        @endif
                                    @endauth
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td style="text-align: center"><button class="btn btn-danger del_btn" value="{{route('user_del', $user->id)}}" {{Auth::user()->role == 1 ?'' :'disabled'}}>Delete User</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === User Delete Session === --}}
<script>
    $('.del_btn').click(function(){
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
@if (session('del_success'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("del_success")}}',
        'success'
    )
</script>
@endif

{{-- === Datatable === --}}
<script>
	$(document).ready( function () {
		$('#user_table').DataTable({
			responsive: true,
		});
	});
</script>
@endsection