<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'price_per_mile',
        'included_miles',
        'condition_miles',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
        'price_per_mile' => 'decimal:2',
        'included_miles' => 'decimal:2',
        'condition_miles' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // public function calculatePrice(float $miles): float
    // {
    //     return round($this->base_price + ($this->price_per_mile * $miles), 2);
    // }
    public function calculatePrice(float $miles): float
    {
        // Simple mode — no included miles set
        if ($this->included_miles <= 0) {
            return $this->base_price + ($miles * $this->price_per_mile);
        }

        // Tiered mode
        $remainingMiles = max(0, $miles - $this->included_miles);

        // How many full blocks of condition_miles fit in remaining
        $conditionMiles = max(1, $this->condition_miles); // prevent division by zero
        $extraBlocks    = floor($remainingMiles / $conditionMiles);

        return $this->base_price + ($extraBlocks * $this->price_per_mile);
    }
}
