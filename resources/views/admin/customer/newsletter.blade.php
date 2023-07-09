@extends('layouts.dashboard')



@section('header_style')
<style>
    .note-editor.note-airframe .note-editing-area, .note-editor.note-frame .note-editing-area {
        min-height: 500px;
    }
    .note-editor.note-frame .note-editing-area .note-editable {
        height: 450px;
    }
    .note-editor.note-frame .panel-heading {
        padding: 0;
        z-index: 1;
        background: #f3f3f3;
		border-bottom: 1px solid #ddd;
    }
    .modal-dialog input {
        margin-right: 10px;
    }
</style>
@endsection



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Newsletter</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Newsletter</h3>
            </div>
            <div class="card-body">
                <form action="{{route('newsletter.add')}}" method="POST" class="row">
                    @csrf

                    <input type="hidden" name="news_id" value="{{@$_GET['inp']}}">
                    <div class="col-xl-7">
                        <div class="item_div mb-4">
                            <label class="form-lable">Header:</label>
                            <input type="text" name="head" class="form-control" value="{{@$_GET['inp'] ?$news_set->head :''}}">
                            @error('head')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="item_div mb-4">
                            <label class="form-lable">* Select from List:</label>
                            <select class="form-control news_sel">
                                <option value="0">-- Select --</option>
                                @foreach ($news_all as $news)
                                    <option {{$news->id == @$_GET['inp'] ?'selected' :''}}
                                        value="{{$news->id}}">{{$news->head}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <a href="{{route('newsletter')}}" class="btn btn-primary">Clear Newsletter Selection</a>
                    </div>

                    <div class="col-xl-12 mt-3">
                        <div class="item-div mb-4">
                            <label for="" class="form-lable">Promotion:</label>
                            <textarea name="promo" class="form-control" id="promo" cols="30" rows="10">
                                {{@$_GET['inp'] ?$news_set->promo :''}}
                            </textarea>
                            @error('promo')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="item_div mt-2 mb-4 text-center">
                            @if (@$_GET['inp'])
                                <button formaction="{{route('newsletter.update')}}" type="submit" class="btn btn-primary">Update Item</button>
                            @else
                                <button type="submit" class="btn btn-primary">Add New Item</button>
                                @endif
                            <button formaction="{{route('newsletter.send')}}" class="btn btn-secondary ml-2" id="mail_btn">Send Mail</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



@section('footer_script')

{{-- === Summernote HTML Editor ===  --}}
<script>
    $(document).ready(function() {
        $('#promo').summernote();
    });
</script>

{{-- === News Select === --}}
<script>
    $('.news_sel').change(function(){
        var news = $(this).val();

        var search_link = "{{route('newsletter')}}" + "?inp=" + news;
        window.location.href = search_link;
    })
</script>

{{-- === Dash preloader on Submit === --}}
<script>
    $(document).ready(function () {
        $("#mail_btn").click(function () {
            $("#dash_loader").show();
        });
    });
</script>
@endsection