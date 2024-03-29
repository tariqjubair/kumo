@extends('layouts.dashboard')



@section('header_style')
<style>
    img.cust_img {
        border-radius: 50%;
    }
</style>
@endsection



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer List</a></li>
    </ol>
</div>

@can('customer_view')
    
<div class="row">

    {{-- === User List === --}}
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Customer List</h3>
                <h4>Total: {{count($all_cust)}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="cust_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="3">Profile Pic:</th>
                            <th data-priority="1">Customer Name:</th>
                            <th>Status:</th>
                            <th data-priority="4">Email/Phone:</th>
                            <th>Full Address:</th>
                            <th>Active Orders:</th>
                            <th>Reg. At:</th>
                            <th data-priority="2">Action:</th>
                        </tr>   
                    </thead>
                    <tbody>
                        @foreach ($all_cust as $key=>$cust)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>
                                @if ($cust->prof_pic == null)
                                    <img width="60" src="{{ asset('assets/img/customer.png') }}" style="opacity: {{$cust->status == 0 ?'.2' :'1'}}; border-radius: 50%" class="cust_img"/>
                                @else
                                    <img width="60" height="60" src="{{asset('uploads/customer')}}/{{$cust->prof_pic}}" alt="Customer" style="opacity: {{$cust->status == 0 ?'.2' :'1'}}; border-radius: 50%">
                                @endif
                            </td>
                            <td>
                                @if ($cust->status == 0)
                                    <del>{{$cust->name}}</del>
                                @else
                                    <span class="text-primary">{{$cust->name}}</span>
                                @endif
                            </td>
                            <td><span class="{{$cust->status == 0 ?'text-danger' :''}}">{{$cust->status == 0 ?'Blocked' :'Active'}}</span></td>
                            <td>{{$cust->email}}<br>
                                {{$cust->code ?$cust->code.'-' :''}} {{$cust->mobile ?$cust->mobile :''}}</td>
                            <td>{{$cust->address}}
                                @if ($cust->address)
                                    {!! '<br>' !!}
                                @endif
                                {{$cust->city ?$cust->relto_city->name.',' :''}} {{$cust->country ?$cust->relto_country->name :''}}</td>
                            <td style="text-align: center">
                                @php
                                    $cust_order = App\Models\OrderTab::where('customer_id', $cust->id)->where('order_status', '!=', 6) ->count();
                                @endphp
                                {{$cust_order != 0 ?$cust_order :'-'}}
                            </td>
                            <td>{{$cust->email_verified_at ?$cust->email_verified_at->format('d-M-y') :'-'}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    @can('customer_control')
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('backend_cust.order', $cust->id)}}">View Orders</a>
                                        @if ($cust->status == 1)
                                            <button class="dropdown-item block_btn" value="{{route('cust.block', $cust->id)}}">Block Customer</button>
                                        @else 
                                            <a class="dropdown-item" href="{{route('cust.unblock', $cust->id)}}">Unblock</a>
                                        @endif
                                        <a class="dropdown-item" id="reset_btn" href="{{route('cust.reset_pass', $cust->id)}}">Reset Password</a>
                                    </div>
                                    @else
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
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
</div>

@else
<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text  font-weight-bold">403</h1>
                        <h4><i class="fa fa-times-circle text-danger"></i> Forbidden Error!</h4>
                        <p>You do not have permission to view this resource.</p>
						<div>
                            <a class="btn btn-primary" href="{{route('home')}}">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endcan
@endsection

@section('footer_script')

{{-- === User Delete Session === --}}
<script>
    $('.block_btn').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Selected Customer will be Suspended!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Block it!'
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
		$('#cust_table').DataTable({
			responsive: true,
		});
	});
</script>

{{-- === Dash preloader on Submit === --}}
<script>
    $(document).ready(function () {
        $("#reset_btn").click(function () {
            $("#dash_loader").show();
        });
    });
</script>
@endsection