<?php

namespace App\Http\Controllers;

use App\Models\ChargeTab;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChargesCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function charges_store(){
        $charge_all = ChargeTab::all();
        return view('admin.Product.charges', [
            'charge_all' => $charge_all,
        ]);
    }

    function add_location(Request $request){
        $request->validate([
            'location' => 'required',
            'del_charge' => 'required|integer|gte:0',
        ], [
            'del_charge.required' => 'Amount cannot be blank',
            'del_charge.integer' => 'Invalid Charge Amount!',
            'del_charge.gte' => 'Invalid Charge Amount!',
        ]);

        ChargeTab::insert([
            'location' => $request->location,
            'charge' => $request->del_charge,
            'created_at' => Carbon::now(),
        ]);
        return back()->with([
            'loc_added' => 'New Delivery Location Added!'
        ]);
    }

    function delete_location($charge_id){
        ChargeTab::find($charge_id)->delete();
        return back()->with('loc_del', 'Delivery Location Deleted!');
    }

    function edit_location($charge_id){
        $charge_all = ChargeTab::find($charge_id);
        return view('admin.Product.edit_location', [
            'charge_all' => $charge_all,
        ]);
    }



    function charges_update(Request $request){
        $charge_location = ChargeTab::find($request->charge_id)->location;

        if($charge_location == $request->location){
            $request->validate([
                'location' => 'required',
                'delivery_charge' => 'required|integer|gte:0',
            ]);
        }
        else {
            $request->validate([
                'location' => 'required|unique:charge_tabs,location',
                'delivery_charge' => 'required|integer|gte:0',
            ]);
        }

        ChargeTab::find($request->charge_id)->update([
            'location' => $request->location,
            'charge' => $request->delivery_charge,
        ]);
        return back()->with('loc_upd', 'Deliver Location Updated!');
    }
}
