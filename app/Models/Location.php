<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'ptero_id_location',
        'name',
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'location_plan');
    }
}
