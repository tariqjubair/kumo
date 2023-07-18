@extends('layouts.dashboard')

@section('header_style')
<style>
    
</style>
@endsection

@section('content')

{{-- === Dashboard === --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Target Settings</a></li>
    </ol>
</div>

@can('target_view')
    
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Daily Targets:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('daily_target.update')}}" method="POST">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Order Target:</label>
                        <input type="number" min="0" name="daily_order" class="form-control" value="{{$daily_target->order}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_order')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Sales Target:</label>
                        <input type="string" min="0" name="daily_sales" class="form-control" value="{{number_format($daily_target->sales)}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_sales')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Visitor Target:</label>
                        <input type="number" min="0" name="daily_visitor" class="form-control" value="{{$daily_target->visitor}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_visitor')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Delivery Target:</label>
                        <input type="number" min="0" name="daily_delivery" class="form-control" value="{{$daily_target->delivery}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_delivery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    @can('target_update')
                    <button type="submit" class="btn btn-primary">Update Info</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Weekly Targets:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('weekly_target.update')}}" method="POST">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Order Target:</label>
                        <input type="number" min="0" name="weekly_order" class="form-control" value="{{$weekly_target->order}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_order')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Sales Target:</label>
                        <input type="string" min="0" name="weekly_sales" class="form-control" value="{{number_format($weekly_target->sales)}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_sales')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Visitor Target:</label>
                        <input type="number" min="0" name="weekly_visitor" class="form-control" value="{{$weekly_target->visitor}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_visitor')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Delivery Target:</label>
                        <input type="number" min="0" name="weekly_delivery" class="form-control" value="{{$weekly_target->delivery}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_delivery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    @can('target_update')
                    <button type="submit" class="btn btn-primary">Update Info</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3>Monthly Targets:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('monthly_target.update')}}" method="POST">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Order Target:</label>
                        <input type="number" min="0" name="monthly_order" class="form-control" value="{{$monthly_target->order}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_order')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Sales Target:</label>
                        <input type="string" min="0" name="monthly_sales" class="form-control" value="{{number_format($monthly_target->sales)}}" @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_sales')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Visitor Target:</label>
                        <input type="number" min="0" name="monthly_visitor" class="form-control" value="{{$monthly_target->visitor}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_visitor')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Delivery Target:</label>
                        <input type="number" min="0" name="monthly_delivery" class="form-control" value="{{$monthly_target->delivery}}"
                        @can('target_update')
                        @else
                            {{'readonly'}}
                        @endcan>
                        @error('daily_delivery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    @can('target_update')
                    <button type="submit" class="btn btn-primary">Update Info</button>
                    @endcan
                </form>
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