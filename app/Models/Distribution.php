<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    //
    protected $fillable = ['beneficiary_id', 'allocation_id', 'distribution_point_id', 'quantity', 'delivered_at'];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function allocation()
    {
        return $this->belongsTo(ResourceAllocation::class, 'allocation_id');
    }

    public function distributionPoint()
    {
        return $this->belongsTo(DistributionPoint::class);
    }
}
