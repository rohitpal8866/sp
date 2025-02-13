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
        $month = $request->get("month") ?? Carbon::now()->month;
        $year = $request->get("year") ?? Carbon::now()->year;
        $building_id = $request->get("building") ;

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
        ->paginate(8);

        $buildings = Building::all();
        $minYear = Bill::orderBy('bill_date', 'asc')->value('bill_date'); // Get the earliest bill_date
        $maxYear = Bill::orderBy('bill_date', 'desc')->value('bill_date'); // Get the latest bill_date
        
        // Extract year values
        $minYear = $minYear ? date('Y', strtotime($minYear)) : date('Y'); // Default to the current year if no data
        $maxYear = $maxYear ? date('Y', strtotime($maxYear)) : date('Y'); 

        return view('admin.bill.index', compact('data','search','month','year','minYear','maxYear','buildings','building_id'));
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
        }elseif($field == 'other'){
            $record->other = $request->amount;
        }elseif($field == 'maintenance'){
            $record->maintenance = $request->amount;
        }  

        if($request->has('notes')){
            $record->notes = $request->notes;
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

        $chunks = $bills->chunk(2);
    
        $pdf = PDF::loadView('admin.bill.pdf.pdf-template', ['data' => $chunks])
                    ->setPaper('a4', 'portrait'); // A4 size paper    


        return $pdf->download(Carbon::now()->format('d-m-Y').'-bills.pdf'); // Forces a PDF download
    }

    public function generateBill($id){
        $building = Building::find($id);

        if (!$building) {
            return response()->json([
                'message' => 'Building not found.',
            ], 404);
        }
    
        $flats = $building->flats;
    
        if ($flats->isEmpty()) {
            return response()->json([
                'message' => 'No flats found for the building.',
            ], 404);
        }
    
        try {
            foreach ($flats as $flat) {
                $lastMonthBill = $flat->bills()->orderBy('bill_date', 'desc')->first();
    
                // Check If current month bill already exit then dont create new bill
                if ($lastMonthBill && $lastMonthBill->bill_date->format('m') == Carbon::now()->format('m')) {
                    return false;
                }

                Bill::create([
                    'flat_id' => $flat->id,
                    'rent' => $flat->rent,
                    'maintenance' => $lastMonthBill->maintenance ?? 0,
                    'light_bill' => $lastMonthBill->light_bill ?? 0,
                    'bill_date' => Carbon::today(),
                ]);
            }
    
            return response()->json([
                'message' => 'Bills generated successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while generating bills.',
                'error' => $e->getMessage(),
            ], 500);
        }
        

    }
    
}
