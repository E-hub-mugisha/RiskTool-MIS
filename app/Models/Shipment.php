<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //
    protected $fillable = ['allocation_id', 'tracking_number', 'shipped_by', 'status'];

    public function allocation()
    {
        return $this->belongsTo(ResourceAllocation::class, 'allocation_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'shipped_by');
    }
}
