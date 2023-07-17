<?php

namespace App\Http\Controllers;

use App\Exports\ExportCustomOrder;
use App\Exports\ExportCustOrder;
use App\Exports\ExportOrderTab;
use App\Exports\ExportSelectedOrders;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelCont extends Controller
{
    public function export_orders(Request $request){
        return Excel::download(new ExportOrderTab, 'orders.xlsx');
    }

    public function export_cust_orders(Request $request){
        return Excel::download(new ExportCustOrder($request), 'customer_orders.xlsx');
    }

    public function export_custom_orders(Request $request){
        return Excel::download(new ExportCustomOrder($request), 'custom_orders.xlsx');
    }

    public function export_selected_orders(Request $request){
        return Excel::download(new ExportSelectedOrders($request), 'selected_orders.xlsx');
    }
}
