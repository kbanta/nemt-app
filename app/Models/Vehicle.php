<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['driver_id', 'make', 'model', 'year', 'plate_number', 'color', 'type', 'is_active'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
