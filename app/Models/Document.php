<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = [ 'model_type', 'model_id', 'uuid', 'document', 'type'];
}
