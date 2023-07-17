<?php

namespace App\Exports;

use App\Models\OrderTab;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCustomOrder implements FromCollection
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
        return OrderTab::whereBetween('created_at', [
            $request->start_dt, $request->end_dt
        ])->orderByDesc('id')->get();
    }
}
