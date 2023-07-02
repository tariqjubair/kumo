<?php

namespace App\Http\Controllers;

use App\Exports\ExportOrderTab;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelCont extends Controller
{
    public function export_orders(Request $request){
        return Excel::download(new ExportOrderTab, 'orders.xlsx');
    }
}
