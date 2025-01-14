<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConfiguration extends Model
{
    protected $table = 'site_configurations';
    protected $fillable = ['site_name', 'logo'];
}
