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
                        <input type="number" min="0" name="daily_order" class="form-control" value="{{$daily_target->order}}">
                        @error('daily_order')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Sales Target:</label>
                        <input type="string" min="0" name="daily_sales" class="form-control" value="{{number_format($daily_target->sales)}}">
                        @error('daily_sales')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Visitor Target:</label>
                        <input type="number" min="0" name="daily_visitor" class="form-control" value="{{$daily_target->visitor}}">
                        @error('daily_visitor')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Daily Delivery Target:</label>
                        <input type="number" min="0" name="daily_delivery" class="form-control" value="{{$daily_target->delivery}}">
                        @error('daily_delivery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Info</button>
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
                        <input type="number" min="0" name="weekly_order" class="form-control" value="{{$weekly_target->order}}">
                        @error('daily_order')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Sales Target:</label>
                        <input type="string" min="0" name="weekly_sales" class="form-control" value="{{number_format($weekly_target->sales)}}">
                        @error('daily_sales')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Visitor Target:</label>
                        <input type="number" min="0" name="weekly_visitor" class="form-control" value="{{$weekly_target->visitor}}">
                        @error('daily_visitor')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Weekly Delivery Target:</label>
                        <input type="number" min="0" name="weekly_delivery" class="form-control" value="{{$weekly_target->delivery}}">
                        @error('daily_delivery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Info</button>
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
                        <input type="number" min="0" name="monthly_order" class="form-control" value="{{$monthly_target->order}}">
                        @error('daily_order')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Sales Target:</label>
                        <input type="string" min="0" name="monthly_sales" class="form-control" value="{{number_format($monthly_target->sales)}}">
                        @error('daily_sales')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Visitor Target:</label>
                        <input type="number" min="0" name="monthly_visitor" class="form-control" value="{{$monthly_target->visitor}}">
                        @error('daily_visitor')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Monthly Delivery Target:</label>
                        <input type="number" min="0" name="monthly_delivery" class="form-control" value="{{$monthly_target->delivery}}">
                        @error('daily_delivery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Info</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection