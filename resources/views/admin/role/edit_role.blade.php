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
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Role</a></li>
    </ol>
</div>

@can('roles_control')
    

<div class="row">
    <div class="col-xl-12 m-auto">
        <div class="card">
            <form action="{{route('role.update')}}" method="POST">
                @csrf
                <input type="hidden" name="role_id" value="{{$role_info->id}}">

                <div class="card-header sm_flex">
                    <h3>Update Role Permissions: <span class="text-danger">{{$role_info->name}}</span></h3>
                    <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3 sp_top">
                        <input type="checkbox" class="custom-control-input" id="chk_all" name="perm_id[]" value="">
                        <label class="custom-control-label" for="chk_all">
                            <h5 class="sp_chk">Check All</h5></label>
                    </div>

                    @php
                        $perm_count = DB::table('role_has_permissions')->where('role_id', $role_info->id)->count()
                    @endphp

                    <h4>Assigned: {{$perm_count}}</h4>
                </div>

                {{-- === Add Permissions === --}}
                <div class="card-body row">
                    @foreach ($perm_group_all as $group)
                        @if (Spatie\Permission\Models\Permission::where('group_id', $group->id)->count() != 0)
                            <div class="col-xl-6">
                                <div id="" class="widget-media dz-scroll mb-4">
                                    <ul class="timeline">
                                        <li>
                                            <div class="perm_item">
                                                <div class="timeline-panel head-chk mb-2 bg-primary group_chk">
                                                    <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                                        @php
                                                            $group_perms = Spatie\Permission\Models\Permission::where('group_id', $group->id);
                                                            $perm_count = $group_perms->count();
                                                            $has_perm = 0;
                                                            $group_chk = '';
                                                        @endphp
                                                        @foreach ($group_perms->get() as $gp_perm)
                                                            @if ($role_info->hasPermissionTo($gp_perm->name))
                                                                @php
                                                                    $has_perm = $has_perm + 1;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @php
                                                            if($has_perm == $perm_count && $has_perm != 0){
                                                                $group_chk = 'on';
                                                            }
                                                        @endphp

                                                        <input type="checkbox" class="custom-control-input group" id="group{{$group->id}}" name="group_id" value="{{$group->id}}" disabled="disabled" {{$group_chk == 'on' ?'checked' :''}}>
                                                        <label class="custom-control-label" for="group{{$group->id}}"></label>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="mb-0 text-white">{{$group->group_name}}</h5>
                                                    </div>
                                                </div>
                                                {{-- {{$has_perm.'|'.$perm_count}} --}}
                                                <div class="sub_chk row">
                                                    @foreach ($perm_all->where('group_id', $group->id) as $perm)
                                                        <div class="col-xl-6 col-md-6">
                                                            <div class="timeline-panel mb-1">
                                                                <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                                    <input {{$role_info->hasPermissionTo($perm->name) ?'checked ' :''}}
                                                                    type="checkbox" class="custom-control-input perm" id="perm{{$perm->id}}" name="perm_id[]" value="{{$perm->id}}">
                                                                    <label class="custom-control-label" for="perm{{$perm->id}}">
                                                                        <h5 class="sp_chk">{{$perm->name}}</h5></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
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
                            <label class="form-lable">Roll Name:</label>
                            <input type="text" name="role_name" value="{{old('role_name') ?old('role_name') :$role_info->name}}" class="form-control">
                            @error('role_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </div>
            </form>
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
@endsection