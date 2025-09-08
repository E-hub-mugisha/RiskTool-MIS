<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceRequest extends Model
{
    protected $fillable = ['region_id','item','quantity','status','justification'];

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function allocations() {
        return $this->hasMany(ResourceAllocation::class);
    }
}
