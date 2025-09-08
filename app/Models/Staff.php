<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'position', 'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
