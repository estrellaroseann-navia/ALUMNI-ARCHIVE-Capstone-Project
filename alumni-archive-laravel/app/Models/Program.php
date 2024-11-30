<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $guarded = [];

    public function college()
    {
        return $this->belongsTo(Colleges::class, 'college_id');
    }
}
