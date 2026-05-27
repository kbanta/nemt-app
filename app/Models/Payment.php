<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'stripe_session_id',
        'stripe_payment_intent',
        'stripe_charge_id',
        'amount',
        'currency',
        'status',
        'refund_id'
    ];
    protected $casts = ['amount' => 'decimal:2'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
