<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'quantity',
        'unit',
        'expiry_date',
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
