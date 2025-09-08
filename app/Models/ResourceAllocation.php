<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceAllocation extends Model
{
    //
    protected $fillable = ['request_id','resource_id','allocated_quantity','status'];

    public function request() {
        return $this->belongsTo(ResourceRequest::class, 'request_id');
    }

    public function resource() {
        return $this->belongsTo(Resource::class);
    }
}
