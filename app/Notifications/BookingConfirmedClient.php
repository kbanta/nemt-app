<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedClient extends Notification implements ShouldQueue
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
        $isInsurance = $b->payment_method === 'insurance';

        $mail = (new MailMessage)
            ->subject("Booking #{$b->booking_number} Received")
            ->greeting("Hi {$notifiable->name}!")
            ->line('Your booking has been successfully received and is being processed.')
            ->line("**Service:** {$b->serviceType->name}")
            ->line("**Scheduled:** {$b->scheduled_at->format('M d, Y h:i A')}")
            ->line("**Payment Method:** " . ucfirst($b->payment_method))
            ->line("**Total:** $" . number_format($b->final_price, 2));

        // Insurance-specific lines
        if ($isInsurance) {
            $mail->line("**Insurance Provider:** {$b->insurance_provider}")
                ->line("**Member ID:** {$b->insurance_member_id}")
                ->line('Our team will verify your insurance coverage before the trip. You may be contacted if additional information is needed.');
        }

        return $mail
            ->action('View Your Booking', route('client.bookings.show', $b))
            ->line($isInsurance
                ? 'We will notify you once your coverage is verified and a driver is assigned.'
                : 'We will notify you once a driver has been assigned.');
    }

    public function toArray(object $notifiable): array
    {
        $b = $this->booking;
        $isInsurance = $b->payment_method === 'insurance';

        $message = $isInsurance
            ? "Booking #{$b->booking_number} confirmed — insurance verification in progress."
            : "Your booking #{$b->booking_number} has been received.";

        return [
            'booking_id'     => $b->id,
            'booking_number' => $b->booking_number,
            'service'        => $b->serviceType->name,
            'scheduled_at'   => $b->scheduled_at,
            'amount'         => $b->final_price,
            'message'        => $message,
        ];
    }
}
