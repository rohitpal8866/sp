<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'roles';
    protected $fillable = [ 'user_id', 'roles'];
}
