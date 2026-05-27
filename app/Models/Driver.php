<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['user_id', 'license_number', 'license_expiry', 'status', 'is_available', 'total_earnings'];
    protected $casts = ['is_available' => 'boolean', 'total_earnings' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    public function documents()
    {
        return $this->hasMany(DriverDocument::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driver_id', 'user_id');
    }
}
