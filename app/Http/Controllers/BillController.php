<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Building;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function index(Request $request)
    {
      
        $search = $request->get("search");
        $month = $request->get("month");
        $year = $request->get("year");
        $building_id = $request->get("building") ?? 1;

        $data = Bill::when($search, function ($query, $search) {
            return $query->whereHas('flat', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })
        ->when($building_id, function ($query, $building_id) {
            return $query->whereHas('flat', function ($query) use ($building_id) {
                    $query->where('building_id', $building_id);
                });
        })
        ->when($month && $month !== '0', function ($query) use ($month) {
            return $query->whereMonth('bill_date', '=', $month);
        })
        ->when($year && $year !== '0', function ($query) use ($year) {
            return $query->whereYear('bill_date', '=', $year);
        })
        ->latest('created_at')
        ->paginate(10);

        $buildings = Building::all();
        $minYear = Bill::orderBy('bill_date', 'asc')->value('bill_date'); // Get the earliest bill_date
        $maxYear = Bill::orderBy('bill_date', 'desc')->value('bill_date'); // Get the latest bill_date
        
        // Extract year values
        $minYear = $minYear ? date('Y', strtotime($minYear)) : date('Y'); // Default to the current year if no data
        $maxYear = $maxYear ? date('Y', strtotime($maxYear)) : date('Y'); 

        return view('admin.bill.index', compact('data','search','month','minYear','maxYear','buildings','building_id'));
    }

    public function update(Request $request)
    {
        $record = Bill::findOrFail($request->id);
    
        if (!$record) {
            return response()->json([
                'message' => 'Bill Not found',
            ], 404);
        }
        $field = $request->field;

        if($field == 'rent'){
            $record->rent = $request->amount;
        }elseif($field == 'light_bill'){
            $record->light_bill = $request->amount;
        }else{
            $record->maintenance = $request->amount;
        }    

        $record->save();
        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $record->toArray(),
        ], 200);
    }

    public function billPrint(Request $request)
    {
        $selectedBills = $request->input('select_bills', []);
        $bills = Bill::whereIn('id', $selectedBills)->get();
    
        $pdf = PDF::loadView('admin.bill.pdf-template', ['bills' => $bills])
                    ->setPaper('a4', 'portrait'); // A4 size paper
    
        return $pdf->download('bills.pdf'); // Forces a PDF download
    }
    
}
