<?php

namespace App\Exports;

use App\Models\OrderTab;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSelectedOrders implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request  ;  
        return OrderTab::where(function($q) use($request){
			if(((!empty($request->start_dt)) && ($request->start_dt != '') && ($request->start_dt != 'undefined')) || ((!empty($request->end_dt)) && ($request->end_dt != '') && ($request->end_dt != 'undefined'))){
				$q->whereBetween('created_at', [$request->start_dt, $request->end_dt]);
			};
            if((!empty($request->pay)) && ($request->pay != '') && ($request->pay != 'undefined')){
				$q->where('payment_method', $request->pay);
			};
            if((!empty($request->status)) && ($request->status != '') && ($request->status != 'undefined')){
				$q->where('order_status', $request->status);
			};
		})->orderByDesc('id')->get();
    }
}
