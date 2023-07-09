<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class cataController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // === Category List Page ===
    function cata_list(){
        $cata_all = Category::orderBy('cata_name')->get();
        $cata_trashed = Category::onlyTrashed()->orderBy('cata_name')->get();
        return view('admin.category.cata_name', [
            'categories' => $cata_all, 
            'cata_trashed' => $cata_trashed,
        ]);
    }

    // === Add Category ===
    function cata_upd(Request $request){
        $request->validate([
            'cata_name' => 'required|unique:categories',
            'cata_image' => 'required|mimes:png,jpg|max:1024',
        ]);

        
        $cata_id = Category::insertGetId([
            'cata_name' => $request->cata_name,
            'created_by' => Auth::id(),
        ]);

        $uploaded_file = $request->cata_image;
        $ext = $uploaded_file->getClientOriginalExtension();
        $cata_name = $request->cata_name;
        $file_name = Str::lower(str_replace(' ', '-', $cata_name)).'-'.rand(100000,999999).'.'.$ext;
        Image::make($uploaded_file)->save(public_path('uploads/category/'. $file_name));

        Category::find($cata_id)->update([
            'cata_image' => $file_name,
        ]);
        return back()->with('cata_upd', 'New Category Created!');
    }

    // === Soft-Delete Category ===
    function cata_del($cata_id){
        Category::find($cata_id)->delete();
        return back()->with('cata_del', 'Category Moved to Trash!');
    }

    // === Restore Category ===
    function cata_restore($cata_id){
        Category::onlyTrashed()->find($cata_id)->restore();
        return back()->with('cata_restore', 'Category is Restored!');
    }

    // === Force-Delete Category ===
    function cata_f_del($cata_id){
        $cata_img_data = Category::onlyTrashed()->find($cata_id);
        $cata_img = $cata_img_data->cata_image;
        $del_file = public_path('uploads/category/'.$cata_img);
        unlink($del_file);

        Category::onlyTrashed()->find($cata_id)->forceDelete();
        return back()->with('cata_f_del', 'Category Permanently Deleted!');
    }

    // === Edit Cate Page ===
    function cata_edit($cata_id){
        $cata_info = Category::find($cata_id);
        return view('admin.category.cata_edit', [
            'cata_info' => $cata_info,
        ]);
    }

    // === Update Category ===
    function cata_info_upd(Request $request){
        $cata_id = $request->cata_id;
        $cata_info = Category::find($cata_id);

        if ($request->cata_name_upd == $cata_info->cata_name){
            $request->validate([
                'new_category_image' => 'mimes:png,jpg|max:1024',
            ]);
        }
        else {
            $request->validate([
                'cata_name_upd' => 'required|unique:categories,cata_name',
                'new_category_image' => 'mimes:png,jpg|max:1024',
            ], [
                'cata_name_upd.required' => 'Category Name cannot be Blank!',
            ]);
        }

        if ($request->new_category_image == ''){
            Category::find($cata_id)->update([
                'cata_name' => $request->cata_name_upd,
            ]);
        }
        else {
            $cata_img_data = Category::find($cata_id);
            $cata_img = $cata_img_data->cata_image;
            $del_file = public_path('uploads/category/'.$cata_img);
            unlink($del_file);

            $uploaded_file = $request->new_category_image;
            $ext = $uploaded_file->getClientOriginalExtension();
            $cata_name = $request->cata_name_upd;
            $file_name = Str::lower(str_replace(' ', '-', $cata_name)).'-'.rand(100000,999999).'.'.$ext;

            Image::make($uploaded_file)->save(public_path('uploads/category/'. $file_name));

            Category::find($cata_id)->update([
                'cata_name' => $request->cata_name_upd,
                'cata_image' => $file_name,
            ]);
        }

        return back()->with('cata_info_upd', 'Category Updated!');
    }
}
