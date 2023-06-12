@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon List</a></li>
    </ol>
</div>
{{-- === Current Coupons === --}}
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Coupons:</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="coupon_table">
                    <thead>
                        <tr>
                            <th>Sr:</th>
                            <th data-priority="1">Coupon:</th>
                            <th>Type:</th>
                            <th data-priority="3">Validity:</th>
                            <th><span class="text-danger">Discount:</span></th>
                            <th>Min Price:</th>
                            <th>Least Disc:</th>
                            <th>Most Disc:</th>
                            <th>Subcategory</th>
                            <th>Time Left:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupon_all as $sl=>$coupon)
                        <tr style="background: white">
                            <td style="text-align: center">{{$sl+1}}</td>
                            <td>{{$coupon->coupon_name}}</td>
                            <td><span class="badge badge-{{$coupon->relto_ctype->color}}" style="width: 110px">{{$coupon->relto_ctype->coupon_type}}</span></td>
                            <td>{{$coupon->validity}}</td>
                            <td><span class="text-danger">{{$coupon->discount}}</span></td>
                            <td>{{$coupon->min_total}}</td>
                            <td>{{$coupon->least_disc}}</td>
                            <td>{{$coupon->most_disc}}</td>
                            <td>
                                @php
                                    $sub_list = explode(",", $coupon->subcata);
                                @endphp
                                
                                @foreach ($sub_list as $sub)
                                    @if ($sub != null)
                                        <p class="mb-0">{{App\Models\Subcategory::find($sub)->sub_cata_name}}</p>
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$coupon->validity > carbon\carbon::now()->isoFormat('YYYY-MM-DD')
                            ?carbon\carbon::now()->diffInDays($coupon->validity).' Days'
                            :'Expired'}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('coupon.edit', $coupon->id)}}">Edit</a>
                                        <button class="dropdown-item del_coupon" value="{{route('coupon.soft_del', $coupon->id)}}">Delete</button>
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

{{-- === Coupon Trashed === --}}
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Trashed Coupons:</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="coupon_trashed_table">
                    <thead>
                        <tr>
                            <th>Sr:</th>
                            <th data-priority="1">Coupon:</th>
                            <th>Type:</th>
                            <th data-priority="3">Validity:</th>
                            <th><span class="text-danger">Discount:</span></th>
                            <th>Min Price:</th>
                            <th>Least Disc:</th>
                            <th>Most Disc:</th>
                            <th>Subcategory</th>
                            <th>Time Left:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupon_trashed as $sl=>$coupon)
                        <tr style="background: white">
                            <td style="text-align: center">{{$sl+1}}</td>
                            <td>{{$coupon->coupon_name}}</td>
                            <td><span class="badge badge-{{$coupon->relto_ctype->color}}" style="width: 110px">{{$coupon->relto_ctype->coupon_type}}</span></td>
                            <td>{{$coupon->validity}}</td>
                            <td><span class="text-danger">{{$coupon->discount}}</span></td>
                            <td>{{$coupon->min_total}}</td>
                            <td>{{$coupon->least_disc}}</td>
                            <td>{{$coupon->most_disc}}</td>
                            <td>
                                {{-- {{$coupon->relto_subcata->sub_cata_name}} --}}
                            </td>
                            <td>{{carbon\carbon::now()->diffInDays($coupon->validity)}} Days</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('coupon.restore', $coupon->id)}}">Restore</a>
                                        <button class="dropdown-item coupon_fdel" value="{{route('coupon.force_del', $coupon->id)}}">Force Delete</button>
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

{{-- === Coupon DataTable === --}}
<script>
	$(document).ready( function () {
		$('#coupon_table').DataTable({
            responsive:true,
        });
		$('#coupon_trashed_table').DataTable({
            responsive:true,
        });
	} );
</script>

{{-- === Coupon Soft Deleted === --}}
<script>
    $('.del_coupon').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Coupon will be moved to Trash!",
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
@if (session('coupon_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("coupon_del")}}',
        'success'
    )
</script>
@endif

{{-- === Coupon Force Deleted === --}}
<script>
    $('.coupon_fdel').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Coupon will be Deleted Permanently!",
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
@if (session('coupon_f_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("coupon_f_del")}}',
        'success'
    )
</script>
@endif

{{-- === Coupon Restored === --}}
@if (session('coupon_restore'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("coupon_restore")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

@endsection