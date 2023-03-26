<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\OrdereditemsTab;
use App\Models\Product_list;
use App\Models\Thumbnail;
use App\Models\WishTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    // === Frontend Home ===
    function home_page(){
        $cata_all = category::take(6)->get();
        $cata_all_in = category::all();
        // $product_all = Product_list::inRandomOrder()->take(8)->get();
        $product_all = Product_list::all();
        $product_recent = Product_list::orderBy('updated_at','desc')->take(3)->get();

        return view('frontend.index', [
            'cata_all' => $cata_all,
            'cata_all_in' => $cata_all_in,
            'product_all' => $product_all,
            'product_recent' => $product_recent,
        ]);
    }

    // === Frontend About ===
    function about_page(){
        return view('frontend.about');
    }

    // === Frontend Shop ===
    function shop_page(){
        return view('frontend.shop');
    }

    // === Frontend Contact ===
    function contact_page(){
        return view('frontend.contact');
    }

    // === Product Details ===
    function product_details($slug){
        $product_info = Product_list::where('slug', $slug)->get()->first();

        $thumbnail = Thumbnail::where('product_id', $product_info->id)->get();
        $rel_products = Product_list::where('cata_id', $product_info->cata_id)->where('id', '!=', $product_info->id)->get();
        
        $color_info = Inventory::where('product_id', $product_info->id)->groupBy('color')->selectRaw('sum(color) as sum, color')->get('sum', 'color');

        $size_info = Inventory::where('product_id', $product_info->id)->orderBy('size')->groupBy('size')->selectRaw('sum(size) as sum, size')->get('sum', 'size');

        return view('frontend.details', [
            'product_info' => $product_info,
            'thumbnail' => $thumbnail,
            'rel_products' => $rel_products,
            'color_info' => $color_info,
            'size_info' => $size_info,
        ]);
    }

    // === Get Size ===
    function get_size(Request $request){

        $avail_size = Inventory::where('product_id', $request->product_id)->where('color', $request->color_id)->orderBy('size')->get();
        
        $str = '';
        foreach($avail_size as $size){
            $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                <input class="form-check-input size_inp" type="radio" name="prod_size" value="'.$size->size.'" id="siz'.$size->relto_size->id.'">
                <label class="form-option-label" for="siz'.$size->relto_size->id.'">'.$size->relto_size->size.'</label>
            </div>';
        }
        echo $str; 
    }

    // === Get Quantity Ajax ===
    function get_quantity(Request $request){
        $stock = Inventory::where('product_id', $request->product_id)->where('color', $request->color_id)->where('size', $request->size_id)->get()->first()->quantity;

        $qty = '';
        for ($i=1; $i <= $stock; $i++) { 
            $qty .= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $qty;
    }

    // === Customer Login ===
    function customer_login(){
        return view('frontend.cust_login');
    }

    // === Color_Size for QTY ===
    function get_color_size(Request $request){
        $stock = Inventory::where('product_id', $request->product_id)->where('color', $request->color_id)->where('size', $request->size_id)->get()->first()->quantity;

        echo $stock;
    }

    // === Product Review ===
    function product_review(Request $request, $product_id){
        if(!$request->rating || !$request->review){
            return back()->with([
                'rev_error' => 'rev_error',
            ])->withInput();
        }
        else {
            OrdereditemsTab::where('customer_id', Auth::guard('CustLogin')->id())->where('product_id', $product_id)->whereNull('review')->first()->update([
                'review' => $request->review,
                'star' => $request->rating,
            ]);
    
            return back()->with([
                'rev_done' => 'rev_done',
            ]);
        }
    }
}
