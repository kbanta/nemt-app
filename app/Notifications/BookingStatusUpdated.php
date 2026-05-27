<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking, public string $status) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast']; 
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;
        $statusLabel = ucfirst(str_replace('_', ' ', $this->status));

        $statusMessages = [
            'approved'   => 'Your booking has been approved and is being processed.',
            'assigned'   => 'A driver has been assigned to your booking.',
            'in_transit' => 'Your driver is on the way!',
            'completed'  => 'Your trip has been completed. Thank you for riding with us!',
            'cancelled'  => 'Your booking has been cancelled.',
        ];

        $line = $statusMessages[$this->status] ?? "Your booking status has been updated to {$statusLabel}.";

        return (new MailMessage)
            ->subject("Booking #{$b->booking_number} — {$statusLabel}")
            ->greeting("Hi {$notifiable->name}!")
            ->line($line)
            ->line("**Booking:** #{$b->booking_number}")
            ->line("**Service:** {$b->serviceType->name}")
            ->line("**Status:** {$statusLabel}")
            ->when($this->status === 'assigned' && $b->driver, function($mail) use ($b) {
                return $mail->line("**Driver:** {$b->driver->name}");
            })
            ->action('View Booking', route('client.bookings.show', $b))
            ->line('Thank you for choosing MedRide!');
    }

    public function toArray(object $notifiable): array
    {
        $statusMessages = [
            'approved'   => "Booking #{$this->booking->booking_number} has been approved.",
            'assigned'   => "A driver has been assigned to booking #{$this->booking->booking_number}.",
            'in_transit' => "Your driver is on the way for booking #{$this->booking->booking_number}!",
            'completed'  => "Booking #{$this->booking->booking_number} has been completed.",
            'cancelled'  => "Booking #{$this->booking->booking_number} has been cancelled.",
        ];

        return [
            'booking_id'     => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'service'        => $this->booking->serviceType->name,
            'amount'         => $this->booking->final_price,
            'status'         => $this->status,
            'message'        => $statusMessages[$this->status] ?? "Booking #{$this->booking->booking_number} status updated to " . ucfirst($this->status) . ".",
        ];
    }
}