<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking;

        return (new MailMessage)
            ->subject('New Booking #' . $booking->booking_number . ' Received')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new booking has been placed.')
            ->line('**Service:** ' . $booking->serviceType->name)
            ->line('**Date:** ' . $booking->scheduled_at->format('M d, Y h:i A'))
            ->line('**Status:** ' . ucfirst($booking->status))
            ->line('**Amount:** $' . number_format($booking->final_price, 2))
            ->action('View Booking', route('client.bookings.show', $booking))
            ->line('Thank you for using our service!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id'   => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'service'      => $this->booking->serviceType->name,
            'scheduled_at' => $this->booking->scheduled_at,
            'amount'       => $this->booking->final_price,
            'message'      => 'New booking #' . $this->booking->booking_number . ' has been placed.',
        ];
    }
}