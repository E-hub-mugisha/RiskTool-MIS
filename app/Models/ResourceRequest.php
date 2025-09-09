<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceRequest extends Model
{
    protected $fillable = ['region_id', 'resource_id', 'quantity', 'status', 'justification'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function allocations()
    {
        return $this->hasMany(ResourceAllocation::class);
    }
}
