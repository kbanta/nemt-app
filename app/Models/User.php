<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'is_active' => 'boolean'];

    public function isAdmin(): bool
    {
        // return $this->role === 'admin';
        return in_array($this->role, ['admin', 'superadmin']);
    }
    public function isClient(): bool
    {
        return $this->role === 'client';
    }
    public function isDriver(): bool
    {
        return $this->role === 'driver';
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
    public function bookingsAsClient()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }
    public function bookingsAsDriver()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function bookings()        // for clients
    {
        return $this->hasMany(\App\Models\Booking::class, 'client_id');
    }

    public function driverBookings()  // for drivers
    {
        return $this->hasMany(\App\Models\Booking::class, 'driver_id');
    }
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }
}
