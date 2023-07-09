<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Size;
use App\Models\measure;

use App\Models\category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcateController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // === Subcate List Page ===
    function sub_cata_list(){
        $cata_all = Category::all();
        $sub_cata_all = Subcategory::orderBy('sub_cata_name')->get();
        $subcata_trashed = Subcategory::onlyTrashed()->orderBy('sub_cata_name')->get();

        $measure_all = measure::orderBy('size_type')->get();
        $size_all = Size::all();
        
        return view('admin.subcategory.sub_cata_list', [
            'cata_all' => $cata_all,
            'sub_cata_all' => $sub_cata_all,
            'subcata_trashed' => $subcata_trashed,
            'measure_all' => $measure_all,
        ]);
    }

    // === Add Subcate ===
    function sub_cata_add(Request $request){
        $request->validate([
            'cata_id' => 'required',
            'sub_cata_name' => 'required|unique:subcategories',
            'measure' => 'required',
        ]);

        Subcategory::insert([
            'cata_id' => $request->cata_id,
            'sub_cata_name' => $request->sub_cata_name,
            'created_at' => Carbon::now(),
            'measure' => $request->measure,
        ]);

        $sub_cata_name = $request->sub_cata_name;
        return back()->with('sub_cata_added', $sub_cata_name.' Added!');
    }

    // === Delete Subcategory ===
    function sub_cata_del($subcata_id){
        $subcata_info = Subcategory::find($subcata_id);
        $subcata_name = $subcata_info->sub_cata_name;

        Subcategory::find($subcata_id)->delete();
        return back()->with('subcata_del', $subcata_name.' Moved to Trash!');
    }

    // === Force-Delete Subcategory ===
    function subcata_f_del($subcata_id){
        $subcata_info = Subcategory::onlyTrashed()->find($subcata_id);
        $subcata_name = $subcata_info->sub_cata_name;

        Subcategory::onlyTrashed()->find($subcata_id)->forceDelete();
	    return back()->with('subcata_f_del', $subcata_name.' Permanently Deleted!');
    }

    // === Restore Subcategory ===
    function subcata_restore($subcata_id){
        $subcata_info = Subcategory::onlyTrashed()->find($subcata_id);
        $subcata_name = $subcata_info->sub_cata_name;

        Subcategory::onlyTrashed()->find($subcata_id)->restore();
	    return back()->with('subcata_restore', $subcata_name.' Restored!');
    }

    // === Edit-Page Subcategory ===
    function subcata_edit($subcata_id){
        $cata_all = category::all();
        $subcata_info = Subcategory::find($subcata_id);
        $measure_all = measure::orderBy('size_type')->get();

        return view('admin.subcategory.subcata_edit', [
            'cata_all' => $cata_all,
            'subcata_info' => $subcata_info,
            'measure_all' => $measure_all,
        ]);
    }

    // === Update Subcategory ===
    function subcata_upd(Request $request){
        $subcata_id = $request->subcata_id;
        $subcata_info = subcategory::find($subcata_id);

        if ($request->subcata_name_upd == $subcata_info->sub_cata_name){
            $request->validate([
                'measure' => 'required',
            ]);
        }
        else {
            $request->validate([
                'subcata_name_upd' => 'required|unique:subcategories,sub_cata_name',
                'measure' => 'required',
            ], [
                'subcata_name_upd.required' => 'Sub-Category Name cannot be Blank!',
                'subcata_name_upd.unique' => 'Sub-Category Name has already been taken!' 
            ]);
        }

        $subcata_id = $request->subcata_id;
        Subcategory::find($subcata_id)->update([
            'sub_cata_name' => $request->subcata_name_upd,
            'cata_id' => $request->cata_id,
            'measure' => $request->measure,
        ]);

        return back()->with('subcata_upd', 'Sub-Category Updated!');

    }
}
