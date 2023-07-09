<?php

namespace App\Http\Controllers;

use App\Mail\PromoMail;
use App\Models\CustInfo;
use App\Models\newsletter;
use App\Models\OrderTab;
use App\Models\SubsTab;
use App\Notifications\TempPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class BackendCust extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function cust_list(){
        $all_cust = CustInfo::orderBy('name')->get();

        return view ('admin.customer.cust_list', [
            'all_cust' => $all_cust,
        ]);
    }

    function customer_block($cust_id){
        CustInfo::find($cust_id)->update([
            'status' => 0,
        ]);
        return back()->with('del', 'Customer Blocked!');
    }

    function customer_unblock($cust_id){
        CustInfo::find($cust_id)->update([
            'status' => 1,
        ]);
        return back()->with('job_upd', 'Customer Unblocked!');
    }

    function customer_orders($cust_id){
        $cust_name = CustInfo::find($cust_id)->name;
        $cust_order = OrderTab::where('customer_id', $cust_id)->orderBy('id', 'DESC')->get();

        return view ('admin.customer.backend_cust_order', [
            'cust_id' => $cust_id,
            'cust_name' => $cust_name,
            'cust_order' => $cust_order,
        ]);
    }

    function cust_pass_reset($cust_id){
        $cust_info = CustInfo::find($cust_id);
        $cust_name = CustInfo::find($cust_id)->name;
        $temp_pass = Str::random(8);
        CustInfo::find($cust_id)->update([
            'password' => bcrypt($temp_pass),
        ]);

        Notification::send($cust_info, new TempPassword($temp_pass));

        return back()->with([
            'user' => $cust_name,
            'cust_pass_reset' => 'Password has been Reset and Forwarded!'
        ]);
    }

    function newsletter_store(Request $request){
        $news_all = newsletter::orderBy('id', 'DESC')->get();
        $data = $request->all();

        $news_set = newsletter::where(function($q) use($data){
            if((!empty($data['inp'])) && ($data['inp'] != '') && ($data['inp'] != 'undefined')){
                $q->where('id', $data['inp']);
            };
        })->first();

        return view('admin.customer.newsletter', [
            'news_all' => $news_all,
            'news_set' => $news_set,
        ]);
    }



    
    function newsletter_add(Request $request){
        $request->validate([
            'head' => 'required|unique:newsletters,head',
            'promo' => 'required',
        ], [
            'head.required' => 'Must insert Header',
            'head.unique' => 'Header already Exists, change Name!',
            'promo.required' => 'Must add Promotion!',
        ]);
        // return $request->all();

        $news_item = newsletter::insertGetId([
            'head' => $request->head,
            'promo' => $request->promo,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('job_upd', 'New Promotion Added!');
    }




    function newsletter_update(Request $request){
        $news_head = newsletter::find($request->news_id)->head;
        if($news_head == $request->head){
            $request->validate([
                'promo' => 'required',
            ], [
                'promo.required' => 'Must add Promotion!',
            ]);
        }
        else {
            $request->validate([
                'head' => 'required|unique:newsletters,head',
                'promo' => 'required',
            ], [
                'head.required' => 'Must insert Header',
                'head.unique' => 'Header already Exists, change Name!',
                'promo.required' => 'Must add Promotion!',
            ]);
        }
        // return $request->all();

        newsletter::find($request->news_id)->update([
            'head' => $request->head,
            'promo' => $request->promo,
        ]);
        return back()->with('job_upd', 'Newsletter Updated!');
    }




    function newsletter_send(Request $request){
        $request->validate([
            'head' => 'required',
            'promo' => 'required',
        ], [
            'head.required' => 'Must insert Header!',
            'promo.required' => 'Must add Promotion!',
        ]);

        $header = $request->head;
        $promo = $request->promo;
        $cust_all = CustInfo::select('email')->whereNotNull('email_verified_at')->get();
        $subs_all = SubsTab::select('email')->get();

        // === Order Invoice View (/promo) ===
        Session([
            'header' => $header,
            'promo' => $promo,
        ]);
        // Mail::to('tariq.wpdev@gmail.com')->send(new PromoMail($header, $promo));

        foreach ($cust_all as $cust){
            Mail::to($cust->email)->send(new PromoMail($header, $promo));
        }
        foreach ($subs_all as $cust){
            Mail::to($cust->email)->send(new PromoMail($header, $promo));
        }

        return back()->with('job_upd', 'Mail Sent to All Customers!');
    }
}
