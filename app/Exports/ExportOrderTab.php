<?php

namespace App\Exports;

use App\Models\OrderTab;
use Maatwebsite\Excel\Concerns\FromCollection;


class ExportOrderTab implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrderTab::all();
    }
}
