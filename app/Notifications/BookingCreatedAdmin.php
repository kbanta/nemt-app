<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

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

        return (new MailMessage)
            ->subject("New Booking #{$b->booking_number} Received")
            ->greeting("Hello {$notifiable->name}!")
            ->line("A new booking has been submitted by **{$b->client->name}**.")
            ->line("**Service:** {$b->serviceType->name}")
            ->line("**Scheduled:** {$b->scheduled_at->format('M d, Y h:i A')}")
            ->line("**Payment Method:** " . ucfirst($b->payment_method))
            ->line("**Amount:** $" . number_format($b->final_price, 2))
            ->action('View Booking', route('admin.bookings.show', $b))
            ->line('Please assign a driver as soon as possible.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id'   => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'client'       => $this->booking->client->name,
            'service'      => $this->booking->serviceType->name,
            'scheduled_at' => $this->booking->scheduled_at,
            'amount'       => $this->booking->final_price,
            'message'      => "New booking #{$this->booking->booking_number} from {$this->booking->client->name}.",
        ];
    }
}