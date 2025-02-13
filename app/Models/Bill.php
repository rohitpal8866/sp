<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = ['flat_id', 'rent', 'maintenance', 'light_bill', 'bill_date', 'paid', 'notes','other'];

    protected $casts = [
        'bill_date' => 'date'
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
}
