@extends('layouts.dashboard')



@section('header_style')
<style>
    p.blw_text{
        font-style: italic;
        font-size: 13px;
    }
</style>

{{-- === Select2 Permission === --}}
<style>
    .select2-container--default .select2-selection--multiple{
        min-height: 56px !important;
        overflow: hidden !important;
        height: auto !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        color: black;
        font-size: 0.875rem;
    }

    .select2-container .select2-search--inline .select2-search__field {
        color: #B1B1B1;
        font-size: 15px;
        margin-left: 10px;
        margin-top: 18px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-left: 10px;
        margin-top: 16px;
    }
</style>
@endsection



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('role.users')}}">Assigned Users</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Role & Permissions</a></li>
    </ol>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Role & Permissions:</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('user_role.update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user_info->id}}">

                        <div class="item_div mb-4">
                            <label class="form-lable">User:</label>
                            <input type="text" name="" class="form-control" value="{{$user_info->name}}" readonly>
                        </div>
                        <div class="item_div mb-4">
                            <label class="form-lable">Assign Rolls:</label>
                            <select name="role_id[]" class="form-control" multiple size="5">
                                @foreach ($roles_all as $role)
                                    <option {{$role->id == old('role_id') ?'selected' :''}} 
                                        {{$user_info->hasRole($role->name) ?'selected' :''}} 
                                        value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            <p class="blw_text">* Press Ctrl for Multiple Selection</p>
                            @error('role_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="item_div mb-4">
                            <label class="form-lable">Additional Permissions: (Optional)</label>
                            <select name="perm_id[]" class="form-control select2" multiple="multiple">
                                <option value="">-- Select Permissions --</option>
                                @foreach ($perm_all as $perm)
                                    <option {{collect(old('perm_id'))->contains($perm->id) ?'selected' :''}} 
                                    {{DB::table('model_has_permissions')->where('permission_id', $perm->id)->where('model_id', $user_info->id)->exists() ?'selected' :''}}
                                    value="{{$perm->id}}">{{$perm->name}}</option>
                                @endforeach
                            </select>
                            @error('perm_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" id="upd_user_role_btn" class="btn btn-primary">Update User Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('footer_script')

{{-- === Select2 Search === --}}
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('b[role="presentation"]').hide();
        $('.select2-selection__arrow').append('<i class="fad fa-sort-up"></i>');
    });
</script>

{{-- === Dash preloader on Submit === --}}
<script>
    $(document).ready(function () {
        $("#upd_user_role_btn").click(function () {
            $("#dash_loader").show();
        });
    });
</script>
@endsection