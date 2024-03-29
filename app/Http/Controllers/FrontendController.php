<?php

namespace App\Http\Controllers;

use Share;
use Carbon\Carbon;
use Stripe\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\category;
use App\Models\Coupon;
use App\Models\FaqTab;
use App\Models\Inventory;
use App\Models\Thumbnail;
use App\Models\WishTable;
use App\Models\Subcategory;
use App\Models\Product_list;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;
use App\Models\OrdereditemsTab;
use App\Models\SubsTab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    // === Frontend Home ===
    function home_page(){
        $cata_all = category::take(7)->get();
        $cata_all_in = category::all();
        $product_all = Product_list::inRandomOrder()->take(8)->get();
        // $product_all = Product_list::all();
        $product_recent = Product_list::orderBy('updated_at','desc')->take(3)->get();

        $top_seller = OrdereditemsTab::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('sum', 'DESC')
        ->take(3)
        ->get();

        $featured = OrdereditemsTab::whereNotNull('star')
        ->groupBy('product_id')
        ->selectRaw('sum(star) as sum, product_id')
        ->orderBy('sum', 'DESC')
        ->take(3)
        ->get();

        return view('frontend.index', [
            'cata_all' => $cata_all,
            'cata_all_in' => $cata_all_in,
            'product_all' => $product_all,
            'product_recent' => $product_recent,
            'top_seller' => $top_seller,
            'featured' => $featured,
        ]);
    }

    // === Frontend About ===
    function about_page(){
        return view('frontend.about');
    }





    // === Frontend Shop ===
    function shop_page(Request $request){
        $cate_all = category::orderBy('cata_name')->get();
        $subcate_all = Subcategory::orderBy('sub_cata_name')->get();
        $color_all = Color::all();
        // $color_inv = Inventory::select('color')->distinct()->get();
        $brand_all = Product_list::orderBy('brand')->whereNotNull('brand')->get()->unique('brand');
        $size_type = Size::where('size_type', '!=', 'N/A')->get()->unique('size_type');
        $size_all = Size::all();

        $data = $request->all();
		$sorting = 'created_at';
		$sort_type = 'DESC';
		$showing = '9';

        if((!empty($data['sort'])) && ($data['sort'] != '') && ($data['sort'] != 'undefined')){
			if($data['sort'] == 2){
				$sorting = 'product_name';
				$sort_type = 'ASC';
			}
			else if($data['sort'] == 3){
				$sorting = 'product_name';
				$sort_type = 'DESC';
			}
			else if($data['sort'] == 4){
				$sorting = 'after_disc';
				$sort_type = 'ASC';
			}
			else if($data['sort'] == 5){
				$sorting = 'after_disc';
				$sort_type = 'DESC';
			}
			else {
				$sorting = 'updated_at';
				$sort_type = 'DESC';
			}
		};

        if((!empty($data['show'])) && ($data['show'] != '') && ($data['show'] != 'undefined')){
			if($data['show'] == 2){
				$showing = '20';
			}
			else if($data['show'] == 3){
				$showing = '50';
			}
			else {
				$showing = '9';
			}
		};

        $product_all = Product_list::orderBy('updated_at', 'DESC')->paginate($showing);;

        $searched_items = Product_list::where(function($q) use($data){

			if((!empty($data['inp'])) && ($data['inp'] != '') && ($data['inp'] != 'undefined')){
				$q->where(function($q) use ($data){
					$q->where('product_name', 'like', '%' . $data['inp'] . '%');
					$q->orWhere('short_desc', 'like', '%' . $data['inp'] . '%');
					$q->orWhere('long_desc', 'like', '%' . $data['inp'] . '%');
				});
			};

			if((!empty($data['cate'])) && ($data['cate'] != '') && ($data['cate'] != 'undefined')){
				$q->where('cata_id', $data['cate']);
			};

			if((!empty($data['subcate'])) && ($data['subcate'] != '') && ($data['subcate'] != 'undefined')){
				$q->where('subcata_id', $data['subcate']);
			};

			if((!empty($data['brand'])) && ($data['brand'] != '') && ($data['brand'] != 'undefined')){
				$q->where('brand', $data['brand']);
			};

			if(((!empty($data['min'])) && ($data['min'] != '') && ($data['min'] != 'undefined')) || ((!empty($data['max'])) && ($data['max'] != '') && ($data['max'] != 'undefined'))){
				$q->whereBetween('after_disc', [$data['min'], $data['max']]);
			};

            if((!empty($data['col'])) && ($data['col'] != '') && ($data['col'] != 'undefined')){
				$q->whereHas('relto_invent', function($q) use ($data){
                    $q->where('color', $data['col']);
				});
			};

            if((!empty($data['siz'])) && ($data['siz'] != '') && ($data['siz'] != 'undefined')){
				$q->whereHas('relto_invent', function($q) use ($data){
                    $q->where('size', $data['siz']);
				});
			};

		})->orderBy($sorting, $sort_type)->paginate($showing);

        if ($data){
			$store_items = $searched_items;
		}
		else {
			$store_items = $product_all;
		}

        return view('frontend.shop', [
            'cate_all' => $cate_all,
            'subcate_all' => $subcate_all,
            'color_all' => $color_all,
            'size_all' => $size_all,
            'brand_all' => $brand_all,
            'size_type' => $size_type,
            'store_items' => $store_items,
        ]);
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

        $meta = [
            'title' => $product_info->product_name,
            'desc' => $product_info->short_desc,
        ];
        
        $shareComponent = ShareFacade::currentPage()
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()        
        ->reddit();

        return view('frontend.details', [
            'product_info' => $product_info,
            'thumbnail' => $thumbnail,
            'rel_products' => $rel_products,
            'color_info' => $color_info,
            'size_info' => $size_info,
            'shareComponent' => $shareComponent,
            'meta' => $meta,
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



    // === Language Select ===
    function lang_eng(){
        session::pull('lang_fra');
        session::pull('lang_ben');
        return back();
    }

    function lang_fra(){
        session::pull('lang_ben');
        Session([
            'lang_fra' => 'fr',
        ]);
        return back();
    }

    function lang_ben(){
        session::pull('lang_fra');
        Session([
            'lang_ben' => 'bn',
        ]);
        return back();
    }



    function coupon_view(){
        $coupon_all = Coupon::orderBy('id', 'DESC')->get();

        return view('frontend.coupon_view', [
            'coupon_all' => $coupon_all,
        ]);
    }


    function faq_page(){
        $faq_all = FaqTab::orderBy('order')->get();
        return view('frontend.faq', [
            'faq_all' => $faq_all,
        ]);
    }


    function subs_insert(Request $request){
        $request->validate([
            'subs_email' => 'required|email:rfc,dns|unique:subs_tabs,email',
        ], [
            'subs_email.required' => 'Invalid Email!',
            'subs_email.email' => 'Invalid Email!',
            'subs_email.unique' => 'Already Subscribed!',
        ]);
        // return $request->all();

        SubsTab::insert([
            'email' => $request->subs_email,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('subs_done', 'You have been successfully subscribed!');
    }
}
