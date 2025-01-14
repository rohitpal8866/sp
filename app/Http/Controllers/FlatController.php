<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlatController extends Controller
{
    public function index($id){

        $flat = Flat::orderBy("id","desc")->where("building_id",$id)->paginate(10);
        return view("admin.flat.index", compact("flat" , 'id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'building_id' => 'required|exists:buildings,id',
            'rent' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $flat = Flat::create($request->all());

        return response()->json([
            'message' => 'Building has been added successfully.',
            'flat' => $flat
        ], 200);
    }


    public function show($id)
    {
        $data = Flat::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified building.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'building_id' => 'required|exists:buildings,id',
            'rent' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $flat = Flat::updateOrCreate(
            ['id' => $id],
            $validator->validated()
        );

        return response()->json([
            'message' => 'Flat has been updated successfully.',
            'building' => $flat
        ], 200);
    }

    /**
     * Remove the specified building.
     */
    public function delete($id)
    {
        $data = Flat::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Flat has been deleted successfully.',
        ], 200);
    }

}
