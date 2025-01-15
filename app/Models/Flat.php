<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $table = 'flats';
    protected $fillable = ['building_id','user_id', 'name', 'rent'];


    public function building(){
        return $this->belongsTo(Building::class,'building_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
