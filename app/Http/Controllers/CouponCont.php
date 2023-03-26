<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CoupType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // === Add Coupon Page ===
    function add_coupon(){
        $coup_type_all = CoupType::all();
        return view('admin.coupon.add_coupon', [
            'coup_type_all' => $coup_type_all,
        ]);
    }

    // === Add New Coupon-Type ===
    function add_coupon_type(Request $request){
        $request->validate([
            'add_coupon_type' => 'required|unique:coup_types,coupon_type'
        ], [
            'add_coupon_type.required' => 'Coupon Type Cannot be blank!',
            'add_coupon_type.unique' => 'Coupon Type Already Exists!',
        ]);

        CoupType::insert([
            'coupon_type' => $request->add_coupon_type,
            'color' => $request->coupon_col,
        ]);
        return back()->with('ctype_added', 'Coupon-Type Added!');
    }

    // === Insert Coupon ===
    function coupon_store(Request $request){
        $request->validate([
            'coupon_name' => 'required|unique:coupons,coupon_name',
            'coupon_type' => 'required',
            'validity' => 'required',
            'disc' => 'required|gt:0',
            'min_total' => 'nullable|gte:0',
            'least_disc' => 'nullable|gte:0',
            'most_disc' => 'nullable|gte:0',
        ]);

        $sub_inp = implode(",", $request->subcata);

        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'type' => $request->coupon_type,
            'validity' => $request->validity,
            'discount' => $request->disc,
            'min_total' => $request->min_total,
            'least_disc' => $request->least_disc,
            'most_disc' => $request->most_disc,
            'subcata' => $sub_inp,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('coupon_added', 'New Coupon'.$request->coupon_name.' Successfully Added');
    }

    // === Edit Coupon-Type ===
    function coupon_type_edit($ctype_id){
        $ctype_info = CoupType::find($ctype_id);

        return view('admin.coupon.edit_ctype', [
            'ctype_info' => $ctype_info,
        ]);
    }

    // === Update Coupon-Type ===
    function coupon_type_update(Request $request){
        $ctype_info = CoupType::find($request->ctype_id);

        if($request->ctype_upd == $ctype_info->coupon_type){
            $request->validate([
                'ctype_upd' => 'required',
            ], [
                'ctype_upd' => 'Type Name cannot be blank!',
            ]);
        }
        else{
            $request->validate([
                'ctype_upd' => 'required|unique:coup_types,coupon_type',
            ], [
                'ctype_upd.required' => 'Type Name cannot be blank!',
                'ctype_upd.unique' => 'New Type Name must be Unique',
            ]);
        }

        CoupType::find($request->ctype_id)->update([
            'coupon_type' => $request->ctype_upd,
            'color' => $request->coupon_col,
        ]);
        return back()->with('ctype_upd', 'Coupon Type Updated!');
    }

    // === Coupon Type Delete ===
    function coupon_type_delete($ctype_id){
        CoupType::find($ctype_id)->delete();
        return back()->with('ctype_del', 'Coupon Type Deleted');
    }

    // === Coupon List Show ===
    function coupon_list(){
        $coupon_all = Coupon::all();
        $coupon_trashed = Coupon::onlyTrashed()->get();
        return view('admin.coupon.coupon_list', [
            'coupon_all' => $coupon_all,
            'coupon_trashed' => $coupon_trashed,
        ]);
    }

    // === Soft Del Coupon ===
    function coupon_soft_del($coupon_id){
        Coupon::find($coupon_id)->delete();
	    return back()->with('coupon_del', 'Coupon Moved to Trash!');
    }

    // === Force Del Coupon ===
    function coupon_force_del($coupon_id){
        Coupon::onlyTrashed()->find($coupon_id)->forceDelete();
	    return back()->with('coupon_f_del', 'Coupon Permanently Deleted!');
    }

    // === Restore Coupon ===
    function coupon_restore($coupon_id){
        Coupon::onlyTrashed()->find($coupon_id)->restore();
	    return back()->with('coupon_restore', 'Coupon is Restored!');
    }

    // === Edit Coupon ===
    function coupon_edit($coupon_id){
        $coupon_info = Coupon::find($coupon_id);
        $coup_type_all = CoupType::all();

        return view('admin.coupon.edit_coupon', [
            'coupon_info' => $coupon_info,
            'coup_type_all' => $coup_type_all,
        ]);
    }

    // === Update Coupon ===
    function coupon_update(Request $request){
        $coupon_info = Coupon::find($request->coupon_id);

        if($request->coupon_name == $coupon_info->coupon_name){
            $request->validate([
                'coupon_name' => 'required',
                'coupon_type' => 'required',
                'validity' => 'required',
                'disc' => 'required|gt:0',
                'min_total' => 'nullable|gte:0',
                'least_disc' => 'nullable|gte:0',
                'most_disc' => 'nullable|gte:0',
            ], [
                'coupon_name' => 'Coupon Name cannot be blank!',
            ]);
        }
        else{
            $request->validate([
                'coupon_name' => 'required|unique:coupons,coupon_name',
                'coupon_type' => 'required',
                'validity' => 'required',
                'disc' => 'required|gte:0',
                'min_total' => 'nullable|gte:0',
                'least_disc' => 'nullable|gte:0',
                'most_disc' => 'nullable|gte:0',
            ], [
                'coupon_name.required' => 'Coupon Name cannot be blank!',
                'coupon_name.unique' => 'New Coupon Name must be Unique',
            ]);
        }

        if ($request->subcata){
            $sub_inp = implode(",", $request->subcata);

            Coupon::find($request->coupon_id)->update([
                'subcata' => $sub_inp,
            ]);
        }

        Coupon::find($request->coupon_id)->update([
            'coupon_name' => $request->coupon_name,
            'type' => $request->coupon_type,
            'validity' => $request->validity,
            'discount' => $request->disc,
            'min_total' => $request->min_total,
            'least_disc' => $request->least_disc,
            'most_disc' => $request->most_disc,
        ]);
        return back()->with('coupon_upd', $request->coupon_name.' Successfully Updated');
    }
}
