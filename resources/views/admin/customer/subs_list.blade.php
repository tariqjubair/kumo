@extends('layouts.dashboard')



@section('header_style')
<style>

</style>
@endsection



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Subscriber List</a></li>
    </ol>
</div>
<div class="row">

    {{-- === User List === --}}
    <div class="col-xl-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Subscriber List</h3>
                <h4>Total: {{count($subs_all)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="subs_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Subscriber Email:</th>
                            <th>Joined At:</th>
                            <th data-priority="2">Action:</th>
                        </tr>   
                    </thead>
                    <tbody>
                        @foreach ($subs_all as $key=>$cust)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>{{$cust->email}}</td>
                            <td>{{$cust->created_at->format('d-M-y')}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item del_subs" value="{{route('subs.delete', $cust->id)}}">Delete</button>
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

{{-- === User Delete Session === --}}
<script>
    $('.del_subs').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Selected Subscriber will be Removed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
        })
    })
</script>

{{-- === Datatable === --}}
<script>
	$(document).ready( function () {
		$('#subs_table').DataTable({
			responsive: true,
		});
	});
</script>

@endsection