@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery Charges</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">

        {{-- === Current Locations === --}}
        <div class="offset-xl-1 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h3>Current Charges: </h3>
                </div>
                <div class="card-body">
                    <table class="table stripe sp_col" cellspacing="0" width="100%" id="charge_table">
                        <thead>
                            <tr>
                                <th>Sr:</th>
                                <th data-priority="1">Delivery Location:</th>
                                <th>Charge:</th>
                                <th data-priority="2">Action:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($charge_all as $sl=>$charge)
                                <tr style="background: white">
                                    <td style="text-align: center">{{$sl+1}}</td>
                                    <td>{{$charge->location}}</td>
                                    <td>{{$charge->charge}}</td>
                                    <td style="text-align: center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                                <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edt_loc" href="{{route('edit.location', $charge->id)}}">Edit</a>
                                                <button class="dropdown-item loc_del" value="{{route('delete.location', $charge->id)}}">Delete</button>
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

        {{-- === Add Location === --}}
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Delivery Location:</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('add.location')}}" method="POST">
                        @csrf
                        <div class="item_div mb-4">
                            <label class="form-lable">Location:</label>
                            <input type="text" name="location" class="form-control" value="">
                            @error('location')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="item_div mb-4">
                            <label class="form-lable">Delivery Charge:</label>
                            <input type="text" name="del_charge" class="form-control" value="">
                            @error('del_charge')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Location</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Location Added === --}}
@if (session('loc_added'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("loc_added")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#charge_table').DataTable({
            responsive:true,
        });
	} );
</script>

{{-- === Location Deleted === --}}
<script>
    $('.loc_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "This Delivery Location will be Deleted Permanently!",
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
@if (session('loc_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("loc_del")}}',
        'success'
    )
</script>
@endif
@endsection