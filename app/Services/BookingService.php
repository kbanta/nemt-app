<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\ServiceType;

class BookingService
{
    public function createBooking(array $data, int $clientId): Booking
    {
        $serviceType = ServiceType::findOrFail($data['service_type_id']);
        $estimatedPrice = $serviceType->calculatePrice((float) $data['distance_miles']);

        $booking = Booking::create([
            'booking_number'  => Booking::generateNumber(),
            'client_id'       => $clientId,
            'patient_name'    => $data['patient_name'],
            'service_type_id' => $data['service_type_id'],
            'pickup_address'  => $data['pickup_address'],
            'dropoff_address' => $data['dropoff_address'],
            'distance_miles'  => $data['distance_miles'],
            'scheduled_at'    => $data['scheduled_at'],
            'notes'           => $data['notes'] ?? null,
            'estimated_price' => $estimatedPrice,
            'final_price'     => $estimatedPrice,
            'status'          => 'pending',
            'payment_method' => $data['payment_method'],
            'insurance_provider'     => $data['insurance_provider'] ?? null,    
            'insurance_member_id'    => $data['insurance_member_id'] ?? null,   
            'insurance_group_number' => $data['insurance_group_number'] ?? null,
        ]);

        $this->logStatus($booking, $clientId, 'pending', 'Booking created.');

        return $booking;
    }

    public function updateStatus(Booking $booking, string $status, int $userId, ?string $notes = null): void
    {
        $booking->update(['status' => $status]);
        $this->logStatus($booking, $userId, $status, $notes);
    }

    private function logStatus(Booking $booking, int $userId, string $status, ?string $notes): void
    {
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'user_id'    => $userId,
            'status'     => $status,
            'notes'      => $notes,
        ]);
    }
}
