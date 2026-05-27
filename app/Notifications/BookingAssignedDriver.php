<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingAssignedDriver extends Notification implements ShouldQueue
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
            ->subject("You Have Been Assigned to Booking #{$b->booking_number}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("You have been assigned to a new booking.")
            ->line("**Client:** {$b->client->name}")
            ->line("**Service:** {$b->serviceType->name}")
            ->line("**Scheduled:** {$b->scheduled_at->format('M d, Y h:i A')}")
            ->line("**Pickup:** {$b->pickup_address}")
            ->line("**Dropoff:** {$b->dropoff_address}")
            ->action('View Booking Details', route('driver.trips.show', $b))
            ->line('Please confirm your availability.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id'   => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'client'       => $this->booking->client->name,
            'service'      => $this->booking->serviceType->name,
            'scheduled_at' => $this->booking->scheduled_at,
            'message'      => "You've been assigned to booking #{$this->booking->booking_number}.",
        ];
    }
    
}