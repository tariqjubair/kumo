@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('faq.index')}}">FAQ List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add FAQ</a></li>
    </ol>
</div>

@can('add_faq')
    
<div class="row">
    <div class="col-xl-10 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Insert FAQ</h3>
            </div>
            <div class="card-body">
                <form action="{{route('faq.store')}}" method="POST" class="row">
                    @csrf
                    <div class="col-xl-2">
                        <div class="item-div mb-4">
                            <label class="form-lable">Order:</label>
                            <input type="number" name="order" min="1" value="{{old('order') ?old('order') :'1'}}" class="form-control text-center">
                            @error('order')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="item-div mb-4">
                            <label class="form-lable">Question:</label>
                            <input type="text" name="question" value="{{old('question')}}" class="form-control">
                            @error('question')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="item-div mb-4">
                            <label for="" class="form-lable">Answer:</label>
                            <textarea name="answer" class="form-control" id="answer" cols="" rows="3">{{old('answer')}}</textarea>
                            @error('answer')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 m-auto">
                        <div class="item_div text-center mt-2 mb-4">
                            <button type="submit" class="btn btn-primary">Create FAQ</button>
                        </div>
                    </div>
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