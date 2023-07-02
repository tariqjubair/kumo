<?php

namespace App\Http\Controllers;

use App\Models\cartMod;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\Color;
use App\Models\measure;
use App\Models\category;
use App\Models\SizeType;

use App\Models\Inventory;
use App\Models\Thumbnail;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use App\Models\Product_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    // === Add Product ===
    function add_product(){
        $cata_all = Category::all();
        $subcata_all = Subcategory::all();
        return view('admin.Product.add_product', [
            'cata_all' => $cata_all,
            'subcata_all' => $subcata_all,
        ]);
    }

    // === Get Subcata ===
    function get_subcata(Request $request){
        $str = "<option value=''>-- Select Sub-Category</option>";
        $subcata_items = Subcategory::where('cata_id', $request->cata_id)->get();
        
        foreach($subcata_items as $subcata){
            $str .= "<option
            value='$subcata->id'>$subcata->sub_cata_name</option>";
        }
        echo $str;
    }
    
    // === Insert Product ===
    function product_store(Request $request){
        $request->validate([
            'cata_id' => 'required',
            'subcata_id' => 'required',
            'product_name' => 'required|min:3|max:255',
            'price' => 'required',
            'discount' => 'required|numeric|gte:0|lte:100',
            'preview' => 'required|mimes:png,jpg|max:1024',
            'thumbnails' => 'required',
            'thumbnails.*' => 'mimes:png,jpg|max:1024',
            'short_desc' => 'required',
        ], [
            'cata_id' => 'Must Select one Category',
            'subcata_id' => 'Must Select one Sub Category',
            'discount' => 'Must Select value 0-100',
            'thumbnails.required' => 'Must insert Thumbnails',
            'thumbnails.*.mimes' => 'Pictures must be JPG/PNG',
            'thumbnails.*.max' => 'Pictures must be lower than 1024 KB',
            'short_desc' => 'Must include Product Short Description',
        ]);

        $product_id = Product_list::insertGetId([
            'cata_id' => $request->cata_id,
            'subcata_id' => $request->subcata_id,
            'product_name' => $request->product_name,

            'slug' => Str::lower(str_replace(' ', '-', $request->product_name)).'-'.rand(100000, 999999),
            
            'price' => $request->price,
            'discount' => $request->discount,
            
            'after_disc' => $request->price - ($request->price*$request->discount/100),
            
            'brand' => $request->brand,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
        ]);

        $ext = $request->preview->getClientOriginalExtension();
        $file_name = $product_id.'-'.rand(100000, 999999).'.'.$ext;
        Image::make($request->preview)->resize(600, 600)->save(public_path('uploads/product/preview/'.$file_name));
        
        Product_list::find($product_id)->update([
            'preview' => $file_name,
        ]);
        
        if ($request->thumbnails){
            $thumbnails = $request->thumbnails;
            foreach ($thumbnails as $thumb) {
                $ext = $thumb->getClientOriginalExtension();
                $file_name = $product_id.'-'.rand(100000, 999999).'.'.$ext;
                
                Image::make($thumb)->resize(600, 600)->save(public_path('uploads/product/thumbnails/'.$file_name));
                
                Thumbnail::insert([
                    'product_id' => $product_id,
                    'thumbnail' => $file_name,
                ]);
            }
        }
        return back()->with('product_add', 'New Product Added!');
    }

    // === Product List ===
    function product_list(){
        $cata_all = Category::all();
        $subcata_all = Subcategory::all();
        $product_trashed = Product_list::onlyTrashed()->orderBy('product_name')->get();
        $product_all = Product_list::orderBy('product_name')->get();

        return view('admin.Product.product_list', [
            'cata_all' => $cata_all,
            'subcata_all' => $subcata_all,
            'product_trashed' => $product_trashed,
            'product_all' => $product_all,
        ]);
    }

    // === Get Cate Products ===
    function get_cata_products(Request $request){
        $request->validate([
            'cata_id' => 'required',
            'subcata_id' => 'required',
        ]);

        $cata_id = $request->cata_id;
        $cata_info = Category::find($cata_id);
        $cata_name = $cata_info->cata_name;

        $subcata_id = $request->subcata_id;
        $subcata_info = Subcategory::find($subcata_id);
        $subcata_name = $subcata_info->sub_cata_name;

        $cate_product = Product_list::where('cata_id', $cata_id)->where('subcata_id', $subcata_id)->get()->count();

        session([
            'cata_id' => $cata_id,
            'cata_name' => $cata_name,
            'subcata_id' => $subcata_id,
            'subcata_name' => $subcata_name,
            'cate_product' => $cate_product,
        ]);
        return redirect()->route('product_list');

    }

    // === Clear Cate Selection ===
    function clear_cata_selection(){
        Session::pull('cata_id');
        Session::pull('cata_name');
        Session::pull('subcata_id');
        Session::pull('subcata_name');
        Session::pull('cate_product');
        return back()->with([
            'clear_cata'=> 'Category Selection Cleared!'
        ]);
    }

    // === Soft Delete Product ===
    function del_product($product_id){
        $product_info = Product_list::find($product_id);
        $product_name = $product_info->product_name;
        
        Product_list::find($product_id)->delete();
        cartMod::where('product_id', $product_id)->delete();

        return back()->with('product_del', $product_name.' Moved to Trash!');
    }

    // === Soft Delete Checked_Products ===
    function product_del_checked(Request $request){
        foreach($request->product_id as $chk_sel){
            Product_list::find($chk_sel)->delete();
        }
        return back()->with('product_chk_del', 'All checked Products & corresponding inventories Moved to Trash!');
    }

    // === Hard Delete Product ===
    function force_del_product($product_id){
        $product_info = Product_list::onlyTrashed()->find($product_id);
        $product_name = $product_info->product_name;

        $product_preview = $product_info->preview;
        $del_file = public_path('uploads/product/preview/'.$product_preview);
        unlink($del_file);

        $thumbnail = Thumbnail::where('product_id', $product_id)->get();
        foreach ($thumbnail as $thumb) {
            $product_thumb = $thumb->thumbnail;
            $del_thumb = public_path('uploads/product/thumbnails/'.$product_thumb);
            unlink($del_thumb);
        }

        Product_list::onlyTrashed()->find($product_id)->forceDelete();
        Thumbnail::where('product_id', $product_id)->delete();
        return back()->with('product_force_del', $product_name.' Permanently Deleted!');
    }

    // === Force Delete Checked Products ===
    function product_fdel_checked(Request $request){
        foreach ($request->product_id as $chk_sel){
            $product_info = Product_list::onlyTrashed()->find($chk_sel);

            $product_preview = $product_info->preview;
            $del_file = public_path('uploads/product/preview/'.$product_preview);
            unlink($del_file);

            $thumbnail = Thumbnail::where('product_id', $chk_sel)->get();
            foreach ($thumbnail as $thumb) {
                $product_thumb = $thumb->thumbnail;
                $del_thumb = public_path('uploads/product/thumbnails/'.$product_thumb);
                unlink($del_thumb);
            }

            Product_list::onlyTrashed()->find($chk_sel)->forceDelete();
            Thumbnail::where('product_id', $chk_sel)->delete();
            Inventory::where('product_id', $chk_sel)->delete();
        }

        return back()->with('product_chk_force_del', 'All checked Products and their Inventories Deleted Permanently!');
    }

    // === Product Restore ===
    function product_restore($product_id){
        Product_list::onlyTrashed()->find($product_id)->restore();
        return back()->with('product_restore', 'Product Restored!');
    }

    // === Restore Checked Products ===
    function product_restore_checked(Request $request){
        foreach($request->product_id as $chk_sel){
            Product_list::onlyTrashed()->find($chk_sel)->restore();
        }
        return back()->with('product_restore', 'All checkded Products Restored!');
    }

    // === Edit Product ===
    function edit_product($product_id){
        $product_info = Product_list::find($product_id);

        $cata_all = Category::all();
        $cata_name = Category::where('id', $product_info->cata_id)->get()->first()->cata_name; 
        $subcata_name = Subcategory::where('id', $product_info->subcata_id)->get()->first()->sub_cata_name; 
        $subcata_info = Subcategory::where('cata_id', $product_info->cata_id)->get(); 

        return view('admin.Product.edit_product', [
            'product_info' => $product_info,
            'cata_all' => $cata_all,
            'cata_name' => $cata_name,
            'subcata_name' => $subcata_name,
            'subcata_info' => $subcata_info,
        ]);
    }

    // === Update Product ===
    function update_product(Request $request){
        $product_info = Product_list::find($request->product_id);
        $product_name = $product_info->product_name;
        $product_thumb = Thumbnail::where('product_id', $request->product_id)->get();

        $request->validate([
            'cata_id' => 'required',
            'subcata_id' => 'required',
            'product_name' => 'required|min:3|max:255',
            'price_upd' => 'required',
            'disc_upd' => 'required|numeric|gte:0|lte:100',
            'preview' => 'mimes:png,jpg|max:1024',
            'thumbnails.*' => 'mimes:png,jpg|max:1024',
            'short_desc' => 'required',
        ], [
            'cata_id' => 'Must Select one Category',
            'subcata_id' => 'Must Select one Sub Category',
            'disc_upd' => 'Must Select value 0-100',
            'thumbnails.*.mimes' => 'Pictures must be JPG/PNG',
            'thumbnails.*.max' => 'Pictures must be lower than 1024 KB',
            'short_desc' => 'Must include Product Short Description',
        ]);

        Product_list::find($request->product_id)->update([
            'cata_id' => $request->cata_id,
            'subcata_id' => $request->subcata_id,
            'product_name' => $request->product_name,

            // 'slug' => Str::lower(str_replace(' ', '-', $request->product_name)).'-'.rand(100000, 999999),
            
            'price' => $request->price_upd,
            'discount' => $request->disc_upd,
            'after_disc' => $request->price_upd - ($request->price_upd*$request->disc_upd/100),
            
            'brand' => $request->brand,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
        ]);

        if($request->preview){
            $ext = $request->preview->getClientOriginalExtension();
            $file_name = $product_info->id.'-'.rand(100000, 999999).'.'.$ext;

            $del_old_image = public_path('uploads/product/preview/'.$product_info->preview);
            unlink($del_old_image);

            Image::make($request->preview)->resize(600, 600)->save(public_path('uploads/product/preview/'.$file_name));

            Product_list::find($request->product_id)->update([
                'preview' => $file_name,
            ]);
        }

        if ($request->thumbnails){
            foreach($product_thumb as $thumb){
                $del_old_image = public_path('uploads/product/thumbnails/'.$thumb->thumbnail);
                unlink($del_old_image);

                Thumbnail::where('product_id', $request->product_id)->delete();
            }

            $thumbnails = $request->thumbnails;
            foreach ($thumbnails as $thumb) {
                $ext = $thumb->getClientOriginalExtension();
                $file_name = $product_info->id.'-'.rand(100000, 999999).'.'.$ext;
                
                Image::make($thumb)->resize(600, 600)->save(public_path('uploads/product/thumbnails/'.$file_name));
                
                Thumbnail::insert([
                    'product_id' => $product_info->id,
                    'thumbnail' => $file_name,
                ]);
            }
        }

        return back()->with([
            'product_upd'=> $product_name.' Product Updated!'
        ]);
    }
    
    // === Variation ===
    function product_variation(){
        $color_all = Color::orderBy('color_name')->get();
        $size_all = Size::all();
        $measure_all = measure::orderBy('size_type')->get();

        return view('admin.Product.variation', [
            'color_all' => $color_all,
            'size_all' => $size_all,
            'measure_all' => $measure_all,
        ]);
    }
    
    // === Add Color ===
    function add_color(Request $request){
        $request->validate([
            'color_name' => 'required',
            'color_code' => 'required',
        ]);

        Color::insert([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
        ]);
        return back()->with('color_add', 'New Color Added!');
    }

    // === Edit Color ===
    function edit_color($color_id){
        $color_info = Color::find($color_id);

        return view('admin.Product.edit_color', [
            'color_info' => $color_info,
        ]);
    }

    // === Update Color ===
    function update_color(Request $request){
        $request->validate([
            'color_upd' => 'required',
            'code_upd' => 'required',
        ]);

        Color::find($request->color_id)->update([
            'color_name' => $request->color_upd,
            'color_code' => $request->code_upd,
        ]);
        return back()->with('color_upd', 'Color Updated Successfully!');
    }

    // === Del Color ===
    function del_color($color_id){
        $color_info = Color::find($color_id);
        $col_name = $color_info->color_name;

        Color::find($color_id)->delete();
        return back()->with('col_del', $col_name.' Successfully Deleted!');
    }

    // === Add Size ===
    function add_size(Request $request){
        $request->validate([
            'size' => 'required',
            'size_type' => 'required',
        ]);

        Size::insert([
            'size' => $request->size,
            'size_type' => $request->size_type,
        ]);
        return back()->with('size_add', 'New Size Added!');
    }

    // === Del Size ===
    function del_size($size_id){
        $size_info = Size::find($size_id);
        $size_name = $size_info->size;

        Size::find($size_id)->delete();
        return back()->with('size_del', 'Size: '.$size_name.' Successfully Deleted!');
    }

    // === Edit Size ===
    function edit_size($size_id){
        $size_info = Size::find($size_id);
        $measure_all = measure::all();

        return view('admin.Product.edit_size', [
            'size_info' => $size_info,
            'measure_all' => $measure_all,
        ]);
    }

    // === Update Size ===
    function update_size(Request $request){
        $request->validate([
            'size_upd' => 'required',
        ]);

        Size::find($request->size_id)->update([
            'size' => $request->size_upd,
            'size_type' => $request->size_type,
        ]);
        return back()->with('size_upd', 'Size Updated Successfully!');
    }

    // === Add Measure ===
    function add_size_type(Request $request){
        $request->validate([
            'size_type' => 'required|unique:measures,size_type',
        ]);

        measure::insert([
            'size_type' => $request->size_type,
        ]);
        return back()->with('st_added', 'New Size-Type Added');
    }

    // === Delete Measure ===
    function delete_measure($measure_id){
        $measure_info = Measure::find($measure_id);
        $measure_name = $measure_info->size_type;

        measure::find($measure_id)->delete();
        return back()->with('measure_del', 'Measure: '.$measure_name.' Successfully Deleted!');
    }

    // === Edit Measure ===
    function edit_measure($measure_id){
        $measure_info = measure::find($measure_id);
        return view('admin.Product.edit_measure', [
            'measure_info' => $measure_info,
        ]);
    }

    // === Update Measure ===
    function update_measure(Request $request){
        $request->validate([
            'measure_upd' => 'required|unique:measures,size_type',
        ]);

        Measure::find($request->measure_id)->update([
            'size_type' => $request->measure_upd,
        ]);
        return back()->with('measure_upd', 'Measure Updated Successfully!');
    }

    

    // === Product Inventory ===
    function product_inventory($product_id){
        $product_info = Product_list::find($product_id);
        $measure = Subcategory::find($product_info->subcata_id)->measure;

        $inventory_info = Inventory::where('product_id', $product_id)->orderBy('color')->get();
        $trashed_inv_info = Inventory::onlyTrashed()->where('product_id', $product_id)->get();

        $cata_name = Category::where('id', $product_info->cata_id)->get()->first()->cata_name; 
        $subcata_name = Subcategory::where('id', $product_info->subcata_id)->get()->first()->sub_cata_name; 
        $subcata_measure = Subcategory::where('id', $product_info->subcata_id)->get()->first()->measure; 

        $color_all = Color::orderBy('color_name')->get();
        if($subcata_measure == 'Inch'){
            $avail_size = Size::where('size_type', $measure)->orderby('size')->get();
        }
        else {
            $avail_size = Size::where('size_type', $measure)->get();
        }

        return view('admin.Product.Inventory', [
            'product_info' => $product_info,
            'inventory_info' => $inventory_info,
            'trashed_inv_info' => $trashed_inv_info,

            'color_all' => $color_all,
            'avail_size' => $avail_size,

            'cata_name' => $cata_name,
            'subcata_name' => $subcata_name,
        ]);
    }

    // === Add Inventory ===
    function add_inventory(Request $request){
        $product_name = $request->product_name;

        $request->validate([
            'color' => 'required',
            'quantity' => 'required|gte:0',
        ]);

        $repeat_inv = Inventory::where('product_id', $request->product_id)->where('color', $request->color)->where('size', $request->size)->get()->first();

        $color_id = $request->color;
        $color_name = Color::find($color_id)->color_name;

        $size_id = $request->size;
        $size_val = Size::find($size_id)->size;
        $size_name = str_replace('"', '', $size_val);

        if($repeat_inv){
            return back()->with([
                'repeat_inv' => $product_name.': '.$color_name.'-'.$size_name.' Already Exists!',
                'inv_id' => $repeat_inv->id,
            ]);
        }
        else {
            Inventory::insert([
                'product_id' => $request->product_id,
                'color' => $request->color,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'updated_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);
            return back()->with('inventory_add', 'Inventory Added for '. $product_name);
        }
    }

    // === Repeated Inventory ===
    function repeat_inventory($inv_id){
        $product_id = Inventory::find($inv_id)->product_id;
        return redirect()->route('product.inventory', $product_id)->with('repeat_entry', $inv_id);
    }

    // === Soft Delete Inventory ===
    function delete_inventory($inv_id){
        Inventory::find($inv_id)->delete();
	    return back()->with('inv_del', 'Inventory Moved to Trash!');
    }

    // === Force Delete Inventory ===
    function force_delete_inventory($inv_id){
        Inventory::onlyTrashed()->find($inv_id)->forceDelete();
	    return back()->with('inv_force_del', 'Inventory Permanently Deleted!');
    }

    // === Restore Inventory ===
    function restore_inventory($inv_id){
        Inventory::onlyTrashed()->find($inv_id)->restore();
	    return back()->with('inv_restore', 'Inventory is Restored!');
    }

    // === Edit Inventory ===
    function edit_inventory($inv_id){
        $inv_info = Inventory::find($inv_id);
        $product_id = $inv_info->product_id;
        $product_info = Product_list::find($product_id);

        $measure = Subcategory::find($product_info->subcata_id)->measure;
        $avail_size = Size::where('size_type', $measure)->get();

        $color_all = Color::all();
        $size_all = Size::all();

        return view('admin.Product.edit_inventory', [
            'inv_info' => $inv_info,
            'product_info' => $product_info,

            'color_all' => $color_all,
            'size_all' => $size_all,

            'avail_size' => $avail_size,
        ]);
    }

    // === Update Inventory ===
    function update_inventory(Request $request){
        $request->validate([
            'color_upd' => 'required',
            'size_upd' => 'required',
            'quantity_upd' => 'required|gte:0',
        ]);

        Inventory::find($request->inv_id)->update([
            'color' => $request->color_upd,
            'size' => $request->size_upd,
            'quantity' => $request->quantity_upd,
        ]);
        return back()->with('inv_upd', 'Inventory Updated Successfully!');
    }
}
