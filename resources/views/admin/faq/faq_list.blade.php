@extends('layouts.dashboard')



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">FAQ List</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>FAQ List</h3>
                <h4>Total: {{count($faq_all)}}</h4>
            </div>
            <div class="card-header">
                <table class="table stripe sp_col" cellspacing="0" width="100%" id="faq_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Questions:</th>
                            <th>Answers:</th>
                            <th data-priority="3">Order:</th>
                            <th data-priority="2">Action:</th>
                        </tr>   
                    </thead>
                    <tbody>
                        @foreach ($faq_all as $key=>$faq)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>{{$faq->question}}</td>
                            <td>{{$faq->answer}}</td>
                            <td style="text-align: center"><span class="text-danger">{{$faq->order}}</span></td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edt_btn" href="{{route('faq.edit', $faq->id)}}">Edit</a>
                                        <form action="{{route('faq.destroy', $faq->id)}}" method="POST" id="faq_del_form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item del_faq">Delete</button>
                                        </form>
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

{{-- === Datatable === --}}
<script>
	$(document).ready( function () {
		$('#faq_table').DataTable({
			responsive: true,
		});
	});
</script>

{{-- === Category Deleted Confirm Session === --}}
<script>
    $('.del_faq').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "This Catagory will move to Trash!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                // var link = $(this).val();
                // window.location.href = link;
                $('#faq_del_form').submit();
            }
        })
    })
</script>
@endsection