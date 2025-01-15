<?php

use App\Models\Building;
use App\Models\Flat;
function getBuilding($id = null){

    if($id){
        return Building::find($id);
    }else{
        return Building::all();
    }
};


function getFlat($building_id){

    return Flat::where('building_id', $building_id)->get();
};