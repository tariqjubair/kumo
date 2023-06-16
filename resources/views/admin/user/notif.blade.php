@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifications</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>User Notifications:</h3>
                <h4>Total: {{$notif_count}}</h4>
            </div>
            <div class="card-body">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="notif_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Image:</th>
                            <th data-priority="2">Message:</th>
                            <th>Received At:</th>
                            <th data-priority="3">Action:</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($notif_all as $key=>$notif)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>
                                <img width="60" height="60" src="{{asset('dashboard/images')}}/{{$notif->image}}" alt="Category">
                            </td>
                            <td>{{$notif->heading}}</td>
                            <td>{{$notif->created_at->format('d-M-y h:i A')}}</td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('notif.route', $notif->route)}}">View</a>
                                        <a class="dropdown-item del_btn" href="{{route('notif.delete', $notif->id)}}">Delete</a>
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

{{-- === Table Search === --}}
<script>
    $(document).ready( function () {
        $('#notif_table').DataTable({
            responsive: true,
        });
    } );
</script>
@endsection