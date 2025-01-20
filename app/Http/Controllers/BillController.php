<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get("search");
        $month = $request->get("month");

        $data = Bill::when($search, function ($query, $search) {
            return $query->whereHas('flat', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })
        ->when($month, function ($query, $month) {
            if ($month != '0') {
                return $query->whereMonth('created_at', $month);
            }
        })
        ->latest('created_at')
        ->paginate(10);

        return view('admin.bill.index', compact('data','search','month'));
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

    public function pdfprint(Request $request)
{
    // Get the selected bills data
    $selectedBills = json_decode($request->input('selected_bills'), true);

    // Pass the data to the view and generate the PDF
    $pdf = PDF::loadView('admin.bill.pdf', ['selectedBills' => $selectedBills]);

    // Return the PDF as a download or inline
    return $pdf->download('bills.pdf');  // For download
    // return $pdf->stream('bills.pdf');   // For inline view
}
    
    
}
