<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'client_id',
        'driver_id',
        'service_type_id',
        'pickup_address',
        'pickup_lat',
        'pickup_lng',
        'dropoff_address',
        'dropoff_lat',
        'dropoff_lng',
        'distance_miles',
        'scheduled_at',
        'notes',
        'estimated_price',
        'final_price',
        'status',
        'is_paid',
        'patient_name',
        'payment_method',
        'stripe_payment_url',
        'insurance_provider',
        'insurance_member_id',
        'insurance_group_number',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_paid' => 'boolean',
        'estimated_price' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function statusLogs()
    {
        return $this->hasMany(BookingStatusLog::class)->latest();
    }

    public static function generateNumber(): string
    {
        return 'NEMT-' . strtoupper(uniqid());
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-amber-100 text-amber-800',
            'approved'   => 'bg-blue-100 text-blue-800',
            'assigned'   => 'bg-violet-100 text-violet-800',
            'in_transit' => 'bg-orange-100 text-orange-800',
            'completed'  => 'bg-emerald-100 text-emerald-800',
            'cancelled'  => 'bg-red-100 text-red-800',
            default      => 'bg-gray-100 text-gray-600',
        };
    }
}
