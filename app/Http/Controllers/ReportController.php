<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        $billMonthly = Bill::select(
            DB::raw('MONTH(bill_date) as month'), 
            DB::raw('YEAR(bill_date) as year'), 
            DB::raw('SUM(rent + maintenance + light_bill + other) as total')
        )
        ->groupBy('month', 'year')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();
    
        $billYearly = Bill::select(
            DB::raw('YEAR(bill_date) as year'), 
            DB::raw('SUM(rent + maintenance + light_bill + other) as total')
        )
        ->groupBy('year')
        ->orderBy('year', 'asc')
        ->get();
    
        return view('admin.report.index', compact('billMonthly', 'billYearly'));
    }
}
