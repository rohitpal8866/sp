<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function index(){
        $data = User::whereHas('roles', function ($query) {
            $query->where('role', 'tenant');
        })->paginate(10);

        return view('admin.tanent.index' ,compact('data'));
    }

    public function create(){
        return view('admin.building.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'flat' => 'required|exists:flats,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'phone'=> $request->phone,
        ]);

        $flat = Flat::findOrFail($request->flat);

        if($flat->user_id != null && $flat->user_id != $user->id){
            return response()->json(['message'=> 'Flat is already rented.'], 422);
        }

        if($flat->user_id != $user->id && $flat->user_id == null){
            $user->flat()->associate($flat);
        }
        
        $user->save();

        
        return response()->json([
            'message' => 'Tenant has been updated successfully.',
            'data' => $user
        ], 200);
    }

    /**
     * Show the specified building.
     */
    public function show($id)
    {
        $data = User::with('flat')->findOrFail($id);

        return response()->json($data);
    }

    /**
     * Update the specified building.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'flat' => 'required|exists:flats,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $flat = Flat::findOrFail($request->flat);

        if($flat->user_id != null && $flat->user_id != $user->id){
            return response()->json(['message'=> 'Flat is already assigned to another tenant'], 422);
        }

        if($flat->user_id != $user->id && $flat->user_id == null){
            $user->flat()->associate($flat);
        }
        
        $user->save();

        
        return response()->json([
            'message' => 'Tenant has been updated successfully.',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified building.
     */
    public function delete($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return response()->json([
            'message' => 'Building has been deleted successfully.',
        ], 200);
    }

    public function getFlats(Request $request)
{
    // Validate the building_id input
    $request->validate([
        'building_id' => 'required|exists:buildings,id'
    ]);

    // Fetch the flats for the selected building
    $flats = Flat::where('building_id', $request->building_id)->get();

    // Return flats as a JSON response
    return response()->json([
        'flats' => $flats
    ]);
}


}
