<?php

namespace App\Exports;

use App\Models\OrderTab;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCustOrder implements FromCollection
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
        return OrderTab::where('customer_id',$request->cust_id)->get();
    }
}
