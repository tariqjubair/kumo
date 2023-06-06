@extends('layouts.dashboard')



@section('header_style')
<style>
    .item_div button {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
    }
</style>
@endsection



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('perm.store')}}">Create New Role</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Permissions</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 m-auto">
            <div class="card">
                <form action="{{route('perm.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="group_id" value="{{$group_info->id}}">

                    <div class="card-header">
                        <h3>Update Permissions:</h3>
                    </div>
                    <div class="card-body row">
                        <div class="col-xl-12">
                            <div class="item_div mb-4">
                                <label class="form-lable">Group Name:</label>
                                <input type="text" name="perm_group" value="{{$group_info->group_name}}" class="form-control">
                                @error('perm_group')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <label class="form-lable">Permission Names:</label>
                        </div>
                        @forelse ($group_perms as $sl=>$perm)
                            <div class="col-xl-6 col-lg-6">
                                <div class="item_div mb-4 position-relative">
                                    <input type="hidden" name="perm_id[]" value="{{$perm->id}}">
                                    <input type="text" name="perm_name[]" class="form-control" 
                                        value="{{session('error') && $perm->id == session('err_id') ?session('err_val') :$perm->name}}" 
                                        style="{{session('error') && $perm->id == session('err_id') ?'border: 1px solid red' :''}}">
                                    
                                    <button type="button" value="{{route('perm.delete', $perm->id)}}" class="btn btn-outline-danger btn-xxs perm_del">Delete</button>
                                </div>
                            </div>
                        @empty
                            <div class="col-xl-6">
                                <h6 class="mt-2">Oops! No Permissions Added</h6>
                            </div>
                        @endforelse

                        <div class="col-xl-12">
                            @if (session('error'))
                                <strong class="text-danger">{{session('error')}}</strong>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Update List</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



@section('footer_script')

{{-- === Permission Deleted Confirm Session === --}}
<script>
    $('.perm_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Permission will be removed Permanently!",
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
@endsection