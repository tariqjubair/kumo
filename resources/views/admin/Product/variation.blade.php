@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Variation</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-8">

        {{-- === Current Color List === --}}
        <div class="card">
            <div class="card-header">
                <h3>Color-List:</h3>
                <h4>Total: {{count($color_all)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" cellspacing="0" width="100%" id="color_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Color Name:</th>
                            <th>Color Code:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($color_all as $key=>$color)
                        <tr style="background: white">
                            <td style="text-align: center">{{$key+1}}</td>
                            <td>{{$color->color_name}}</td>
                            <td><span class="badge" style="background-color: {{$color->color_code}}; Color: transparent; width: 80px">{{$color->color_code}}</span></td>
                            <td style="text-align: center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('color.edit', $color->id)}}">Edit</a>

                                        @if(App\Models\Inventory::where('color', $color->id)->get()->first() != null)
                                            <button class="dropdown-item no_del_color" value="">Delete</button>
                                        @else
                                            <button class="dropdown-item del_color" value="{{route('color.delete', $color->id)}}">Delete</button>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- === Current Size List === --}}
        <div class="card">
            <div class="card-header">
                <h3>Size-List:</h3>
                <h4>Total: {{count($size_all)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" id="size_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th>Size Name:</th>
                            <th>Size Type:</th>
                            <th>Action:</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($size_all as $key=>$size)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$size->size}}</td>
                            <td>{{$size->size_type}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('size.edit', $size->id)}}">Edit</a>

                                        @if(App\Models\Inventory::where('size', $size->id)->get()->first() != null)
                                            <button class="dropdown-item no_del_size" value="">Delete</button>
                                        @else
                                            <button class="dropdown-item del_size" value="{{route('size.delete', $size->id)}}">Delete</button>
                                        @endif

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
    <div class="col-xl-4">

        {{-- === Add Color-Name === --}}
        <div class="card">
            <div class="card-header">
                <h3>Add Color:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('add.color')}}" method="POST">
                    @csrf
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Color Name:</label>
                        <input type="text" name="color_name" class="form-control" value="{{old('color_name')}}">
                        @error('color_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Color Code:</label>
                        <input type="text" name="color_code" class="form-control" value="{{old('color_code')}}">
                        @error('color_code')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Color</button>
                </form>
            </div>
        </div>

        {{-- === Add Size === --}}
        <div class="card">
            <div class="card-header">
                <h3>Add Size:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('add.size')}}" method="POST">
                    @csrf
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Insert Size:</label>
                        <input type="text" name="size" class="form-control" value="{{old('size')}}">
                        @error('size')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Insert Size-Type:</label>
                        <select name="size_type" id="" class="form-control">
                            <option value=""> -- Select Type  </option>
                        @foreach ($measure_all as $measure)
                            <option value="{{$measure->size_type}}">{{$measure->size_type}}</option>    
                        @endforeach
                        </select>
                        @error('size_type')
                            <strong class="text-danger has-error">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Size</button>
                </form>
            </div>
        </div>

        {{-- === Current Size-Type === --}}
        <div class="card">
            <div class="card-header">
                <h3>Size_Type:</h3>
                <h4>Total: {{count($measure_all)}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped stripe sp_col" id="measure_table">
                    <thead>
                        <tr>
                            <th>SL:</th>
                            <th data-priority="1">Size-Type:</th>
                            <th data-priority="2">Action:</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($measure_all as $key=>$measure)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$measure->size_type}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('measure.edit', $measure->id)}}">Edit</a>

                                        @if (App\Models\Size::where('size_type', $measure->size_type)->get()->first() != null)
                                            <button class="dropdown-item del_conf_measure" value="{{route('measure.delete', $measure->id)}}">Delete</button>
                                        @else
                                            <button class="dropdown-item del_measure" value="{{route('measure.delete', $measure->id)}}">Delete</button>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- === Add New Size-Type === --}}
        <div class="card">
            <div class="card-header">
                <h3>Add Size-Type:</h3>
            </div>
            <div class="card-body">
                <form action="{{route('add.size_type')}}" method="POST">
                    @csrf
                    <div class="item-div mb-4">
                        <label for="" class="form-lable">Insert Size-Type:</label>
                        <input type="text" name="size_type" class="form-control" value="{{old('size_type')}}">
                        @error('size_type')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Size-Type</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

{{-- === Color Added === --}}
@if (session('color_add'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("color_add")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Size Added === --}}
@if (session('size_add'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("size_add")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Length Added === --}}
@if (session('length_add'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("length_add")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Size-Type/Measure Added === --}}
@if (session('st_added'))
<script>
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: '{{session("st_added")}}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

{{-- === Size Deleted === --}}
<script>
    $('.del_size').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
@if (session('size_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("size_del")}}',
        'success'
    )
</script>
@endif

{{-- === No Delete for Size === --}}
<script>
    $('.no_del_size').click(function(){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This Size has Entry in Product Inventory, Cannot Delete Size!',
        })
    })
</script>

{{-- === Color Deleted === --}}
<script>
    $('.del_color').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
@if (session('col_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("col_del")}}',
        'success'
    )
</script>
@endif

{{-- === No Delete for Color === --}}
<script>
    $('.no_del_color').click(function(){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This Color has Entry in Product Inventory, Cannot Delete Color!',
        })
    })
</script>

{{-- === Size-Type/Measure: Confirm Deleted === --}}
<script>
    $('.del_conf_measure').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "There is Size Entry(s), Are you sure you want to Delete?",
            icon: 'question',
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
@if (session('measure_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("measure_del")}}',
        'success'
    )
</script>
@endif

{{-- === Size-Type/Measure Deleted === --}}
<script>
    $('.del_measure').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "There is no Size-entry with this Measure, Confirm to Delete?",
            icon: 'info',
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
@if (session('measure_del'))
<script>
    Swal.fire(
        'Deleted!',
        '{{session("measure_del")}}',
        'success'
    )
</script>
@endif



{{-- === Table Search === --}}
<script>
	$(document).ready( function () {
		$('#color_table').DataTable({
            responsive:true,
        });
		$('#size_table').DataTable({
            responsive:true,
        });
		$('#length_table').DataTable({
            responsive:true,
        });
		$('#measure_table').DataTable({
            responsive:true,
        });
	} );
</script>


@endsection