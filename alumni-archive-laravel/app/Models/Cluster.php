<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $guarded = [];

    public function campuses()
    {
        return $this->hasMany(Campus::class, 'campus_id');
    }
}
