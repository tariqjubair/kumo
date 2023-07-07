@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('faq.index')}}">FAQ List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit FAQ</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-10 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit FAQ</h3>
            </div>
            <div class="card-body">
                <form action="{{route('faq.update', $faq_id)}}" method="POST" class="row">
                    @csrf
                    @method('PUT')
                    <div class="col-xl-2">
                        <div class="item-div mb-4">
                            <label class="form-lable">Order:</label>
                            <input type="number" name="order" min="1" value="{{old('order') ?old('order') :$faq_info->order}}" class="form-control text-center">
                            @error('order')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="item-div mb-4">
                            <label class="form-lable">Question:</label>
                            <input type="text" name="question" value="{{old('question') ?old('question') :$faq_info->question}}" class="form-control">
                            @error('question')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="item-div mb-4">
                            <label for="" class="form-lable">Answer:</label>
                            <textarea name="answer" class="form-control" id="answer" cols="" rows="3">{{old('answer') ?old('answer') :$faq_info->answer}}</textarea>
                            @error('answer')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 m-auto">
                        <div class="item_div text-center mt-2 mb-4">
                            <button type="submit" class="btn btn-primary">Update FAQ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection