@extends('layouts.master')




@section('header_css')
<style>

    /* Select2 CSS === */
    .select2-container--default .select2-selection--single{
        height: 52px !important;
        padding: 10px 15px;
        padding-top: 13px;
        border-radius: 1px;
        border-color: #e5e5e5;

        font-size: 1rem;
        line-height: 1.25;
        color: #495057;
        background-color: #fff;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        font-size: 14px;
        position: absolute;
        top: 18px;
        right: 8px;
    }

    #code_view .select2-container--default .select2-selection--single{
        padding: 12px 0 8px 5px !important;
    }

    /* Form CSS === */
    .form-control, select.form-control {
        line-height: 24px;
    }

    @media(max-width: 767.98px){
    
        .cust_form {
            margin-top: 15px;
        }
            
    }

    @media(min-width: 768px) and (max-width: 991.98px){
        
        .cust_form {
            margin-top: 25px;
        }
            
    }
</style>
@endsection




@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home_page')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Dashboard Detail ======================== -->
<section class="middle">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Customer Profile</h2>
                    <h3 class="ft-bold pt-3">Your Profile</h3>
                </div>
            </div>
        </div>

        <div class="row align-items-start justify-content-between">
        
            {{-- === Customer Dashboard === --}}
            <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                @if (session('cust_prof_upd'))
                    <span class="err_msg err_msg_prof" style="visibility:visible; background: blue">
                    <p>{{session('cust_prof_upd')}}</p></span>
                @endif

                <div class="d-block border rounded mfliud-bot">
                    <div class="dashboard_author px-2 pt-5 pb-4">
                            <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                                @if ($cust_info->prof_pic)
                                    <img src="{{asset('uploads/customer')}}/{{$cust_info->prof_pic}}" class="img-fluid circle" width="100" alt="Customer" />
                                @else
                                    <img src="{{asset('assets/img/customer.png')}}" class="img-fluid circle" width="100" alt="Customer" />
                                @endif
                            </div>
                        <div class="dash_caption">
                            <h4 class="fs-md ft-medium mb-0 lh-1">{{$cust_info->name}}</h4>
                            @if ($cust_info->city)
                                <span class="text-muted smalls d-block pt-3">{{$cust_info->relto_city->name}}</span>
                            @else
                                <span class="text-muted smalls d-block pt-3" style="font-style: italic">(-- City --)</span>    
                            @endif
                            @if ($cust_info->country)
                                <span class="text-muted smalls d-block">{{$cust_info->relto_country->name}}</span>
                            @else
                                <span class="text-muted smalls d-block" style="font-style: italic">(-- Country --)</span>    
                            @endif
                        </div>
                    </div>
                    
                    <div class="dashboard_author">
                        <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard Navigation</h4>
                        <ul class="dahs_navbar">
                            <li><a href="{{route('customer.order')}}"><i class="lni lni-shopping-basket mr-2"></i>My Orders</a></li>
                            <li><a href="{{route('customer.wishlist')}}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{route('customer.profile')}}" class="active"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{route('customer.logout')}}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <div class="row align-items-center cust_form">

                    {{-- === User Info Form === --}}
                    <form class="row m-0" action="{{route('cust_profile.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="cust_id" value="{{Auth::guard('CustLogin')->id()}}">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">First Name *</label>
                                <input type="text" name="name" class="form-control" value="{{old('name') != null ?old('name') :$cust_info->name}}" />
                                @error('name')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Email ID *</label>
                                <input type="email" name="email" class="form-control" value="{{old('email') != null ?old('email') :$cust_info->email}}" />
                                @error('email')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Current Password *</label>
                                <input type="password" name="old_password" class="form-control" autocomplete="new-password"/>
                                @error('old_password')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                                @if (session('wrong_old_pass'))
                                    <strong class="text-danger">{{session('wrong_old_pass')}}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">New Password *</label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password"/>
                                @error('password')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Confirm Password *</label>
                                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password"/>
                                @error('password_confirmation')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Address</label>
                                <input type="text" name="address" class="form-control" value="{{old('address') != null ?old('address') :$cust_info->address}}" />
                                @error('address')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium ">Country</label>
                                <select name="country" class="form-control select2 set_country">
                                    <option value="">-- Select Country --</option>
                                    @foreach (App\Models\Country::all() as $country)
                                        <option {{old('country') != null && $country->id == old('country') ?'selected' :''}}
                                            {{$country->id == $cust_info->country ?'selected' :''}}
                                        value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium ">City</label>
                                <select name="city" class="form-control select2 show_city">
                                    @if ($cust_info->city)
                                        <option value="{{$cust_info->city}}">{{$cust_info->relto_city->name}}</option>
                                    @else
                                        <option value="">-- --</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4 pr-0">
                            <div class="form-group" id="code_view">
                                <label class="text-dark">Phone Code *</label>
                                <select type="text" class="custom-select select2 show_code" name="code">
                                    @if ($cust_info->country)
                                        @php
                                            $ph_code = App\Models\Country::find($cust_info->country)->phonecode;
                                        @endphp
                                        <option value="{{$ph_code}}">{{$ph_code}}</option>
                                    @else
                                        <option value="">-- --</option>
                                    @endif
                                </select>
                                @error('code')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-8 col-sm-8 col-8">
                            <div class="form-group">
                                <label class="text-dark">Mobile Number *</label>
                                <input type="number" name="mobile" class="form-control" value="{{old('mobile') != null ?old('mobile') :$cust_info->mobile}}">
                                @error('mobile')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Profile Image</label>
                                <input type="file" name="prof_pic" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark" style="margin-top: 20px">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->
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

{{-- === Ajax: PROFILE=> Get City/Code === --}}
<script>
    $('.set_country').change(function(){
        var country_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax ({
            url: '/prof_get_city',
            type: 'POST',
            data: {'country_id': country_id},
            
            success: function(data){
                $('.show_city').html(data);
            }
        })

        $.ajax ({
            url: '/prof_get_code',
            type: 'POST',
            data: {'country_id': country_id},
            
            success: function(data){
                $('.show_code').html(data);
            }
        })
    })
</script>
@endsection