<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    public function index(){
        $building = Building::latest("created_at")->paginate(10);
        return view('admin.building.index' ,compact('building'));
    }

    public function create(){
        return view('admin.building.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'building_name' => 'required|string|max:255|unique:buildings,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $building = new Building();
        $building->name = $request->building_name;
        $building->save();

        return response()->json([
            'message' => 'Building has been added successfully.',
            'building' => $building
        ], 200);
    }

    /**
     * Show the specified building.
     */
    public function show($id)
    {
        $building = Building::findOrFail($id);
        return response()->json($building);
    }

    /**
     * Update the specified building.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'building_name' => 'required|string|max:255|unique:buildings,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $building = Building::findOrFail($id);
        $building->name = $request->building_name;
        $building->save();

        return response()->json([
            'message' => 'Building has been updated successfully.',
            'building' => $building
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
    
}
