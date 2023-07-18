@extends('layouts.dashboard')



@section('header_style')
<style>
    .sp_top {
    margin-bottom: 12px;
}

.perm_item {
    position: relative;
}

.timeline {
    border: 1px solid #f0f1f5;
    border-radius: 10px;
    min-height: 190px;
}

.head-chk{
    padding: 18px 20px !important;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.sub_chk {
    padding: 10px 20px;
}

h5.sp_chk {
    margin: 4px 0 0 8px;
}

.float {
    position: absolute;
    top: 13px;
    right: 20px;
}

@media(max-width: 767.98px){
    .sm_flex {
        flex-direction: column;
    }
}
</style>
@endsection



@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('role.store')}}">Manage Roles</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create New Role</a></li>
    </ol>
</div>

@can('roles_control')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <form action="{{route('role.insert')}}" method="POST">
                @csrf

                <div class="card-header sm_flex">
                    <h3>Assign Permissions to Role:</h3>
                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3 sp_top">
                        <input type="checkbox" class="custom-control-input" id="chk_all" name="perm_id[]" value="">
                        <label class="custom-control-label" for="chk_all">
                            <h5 class="sp_chk">Check All</h5></label>
                    </div>
                    <h4>Total: {{$perm_all->count()}}</h4>
                </div>

                {{-- === Add Permissions === --}}
                <div class="card-body row">
                    @foreach ($perm_group_all as $group)
                        <div class="col-xl-6">
                            <div id="" class="widget-media dz-scroll mb-4">
                                <ul class="timeline">
                                    <li>
                                        <div class="perm_item">
                                            <div class="timeline-panel head-chk mb-2 bg-primary group_chk">
                                                <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                                    <input type="checkbox" class="custom-control-input group" id="group{{$group->id}}" name="group_id" value="{{$group->id}}" disabled="disabled">
                                                    <label class="custom-control-label" for="group{{$group->id}}"></label>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-0 text-white">{{$group->group_name}}</h5>
                                                </div>
                                            </div>
                                            <div class="sub_chk row">
                                                @forelse ($perm_all->where('group_id', $group->id) as $perm)
                                                    <div class="col-xl-6 col-md-6">
                                                        <div class="timeline-panel mb-1">
                                                            <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                                <input {{(is_array(old('perm_id')) && in_array($perm->id, old('perm_id'))) ?'checked ' :''}}
                                                                type="checkbox" class="custom-control-input perm" id="perm{{$perm->id}}" name="perm_id[]" value="{{$perm->id}}">
                                                                <label class="custom-control-label" for="perm{{$perm->id}}">
                                                                    <h5 class="sp_chk">{{$perm->name}}</h5></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-xl-6">
                                                        <h6 class="mt-2">(Empty)</h6>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <div class="dropdown float">
                                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                    <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('perm.edit', $group->id)}}">Edit</a>
                                                    <button type="button" class="dropdown-item group_del" value="{{route('perm_group.delete', $group->id)}}">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-xl-12">
                        @error('perm_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                </div>

                {{-- === Add Role Name === --}}
                <div class="card-body pt-0">
                    <div class="col-xl-6">
                        <div class="item_div mb-4">
                            <label class="form-lable">New Roll Name:</label>
                            <input type="text" name="role_name" class="form-control">
                            @error('role_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xl-6">

        {{-- === Add Permissions to Group === --}}
        <div class="card">
            <div class="card-header">
                <h3>Add Permission:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('perm.insert')}}" method="POST">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">Permission Name:</label>
                        <input type="text" name="perm_name" value="{{old('perm_name')}}" class="form-control">
                        @error('perm_name')
                            <strong class="text-danger err">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item_div mb-4">
                        <label class="form-lable">Select Group:</label>
                        <select name="group_id" class="form-control">
                            <option value="">--Select--</option>
                            @foreach ($perm_group_all as $group)
                                <option {{$group->id == old('group_id') ?'selected' :''}} 
                                    value="{{$group->id}}">{{$group->group_name}}</option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <strong class="text-danger err">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Permission</button>
                </form>
            </div>
        </div>

        {{-- === Add Group === --}}
            <div class="card d-xl-none">
                <div class="card-header">
                    <h3>Add Permit Group:</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('perm_group.insert')}}" method="POST">
                        @csrf
                        <div class="item_div mb-4">
                            <label class="form-lable">New Group Name:</label>
                            <input type="text" name="perm_group" class="form-control">
                            @error('perm_group')
                                <strong class="text-danger err">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Group</button>
                    </form>
                </div>
            </div>
        </div>

    {{-- === XL View === --}}
    <div class="col-xl-6 d-none d-xl-block">
        <div class="card">
            <div class="card-header">
                <h3>Add Permit Group:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('perm_group.insert')}}" method="POST">
                    @csrf
                    <div class="item_div mb-4">
                        <label class="form-lable">New Group Name:</label>
                        <input type="text" name="perm_group" class="form-control">
                        @error('perm_group')
                            <strong class="text-danger err">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Group</button>
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



@section('footer_script')
    
{{-- === Group Check === --}}
<script>
    $('#chk_all').click(function(){
        var perm_all = $(this).closest('.row').find(':checkbox');
        perm_all.prop('checked', perm_all.prop('checked'));
    })
    
    $('.group_chk').click(function(){
        var group_select = $(this).find('.group');
        group_select.prop('checked', !group_select.prop('checked'));

        var perm_all = $(this).next('.sub_chk').find(':checkbox');
        perm_all.prop('checked', !perm_all.prop('checked'));
    })

    $('.perm').click(function(){
        var total_items = $(this).closest('.sub_chk').find(':checkbox').length;
        var checked_items = $(this).closest('.sub_chk').find('.perm:checked').length;

        if(checked_items == total_items){
            $(this).closest('.sub_chk').prev('.group_chk').find('.group').prop('checked', true);
        }
        else {
            $(this).closest('.sub_chk').prev('.group_chk').find('.group').prop('checked', false);
        }
    })
</script>

{{-- === Perm Group Deleted Confirm Session === --}}
<script>
    $('.group_del').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Permissions will be removed Permanently!",
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


