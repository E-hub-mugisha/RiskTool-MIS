<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    //
    protected $fillable = ['name', 'household_id', 'contact', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
