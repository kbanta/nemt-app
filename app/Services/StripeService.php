<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Refund;
use App\Models\User;
use App\Notifications\BookingCreatedAdmin;
use App\Notifications\BookingConfirmedClient;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession(Booking $booking): Session
    {
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => 'NEMT Booking #' . $booking->booking_number,
                        'description' => $booking->serviceType->name . ' — ' . $booking->pickup_address . ' to ' . $booking->dropoff_address,
                    ],
                    'unit_amount' => (int) ($booking->final_price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('client.payment.success', ['booking' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('client.payment.cancel', ['booking' => $booking->id]),
            'metadata'    => ['booking_id' => $booking->id],
        ]);
    }

    public function handleWebhook(string $payload, string $sigHeader): void
    {
        $event = \Stripe\Webhook::constructEvent(
            $payload,
            $sigHeader,
            config('services.stripe.webhook_secret')
        );

        if ($event->type === 'checkout.session.completed') {
            $session   = $event->data->object;
            $bookingId = $session->metadata->booking_id ?? null;

            if (!$bookingId) return;

            $booking = Booking::find($bookingId);
            if (!$booking) return;

            // Update payment record
            Payment::where('booking_id', $booking->id)->update([
                'stripe_session_id'     => $session->id,
                'stripe_payment_intent' => $session->payment_intent,
                'status'                => 'paid',
            ]);

            // Mark booking as paid and approved
            $booking->update([
                'is_paid' => true,
                'status'  => 'approved',
            ]);

            // Log the status change
            \App\Models\BookingStatusLog::create([
                'booking_id' => $booking->id,
                'user_id'    => $booking->client_id,
                'status'     => 'approved',
                'notes'      => 'Payment confirmed via Stripe.',
            ]);
            // 🔔 Notify all admins
            User::where('role', 'admin')->each(
                fn($admin) => $admin->notify(new BookingCreatedAdmin($booking))
            );

            // 🔔 Notify the client
            $booking->client->notify(new BookingConfirmedClient($booking));
        }
    }

    public function refundPayment(Payment $payment): Refund
    {
        $refund = Refund::create(['payment_intent' => $payment->stripe_payment_intent]);
        $payment->update(['status' => 'refunded', 'refund_id' => $refund->id]);
        return $refund;
    }
    public function syncSessionPayment(string $sessionId, Booking $booking): bool
    {
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                Payment::where('booking_id', $booking->id)->update([
                    'stripe_session_id'     => $session->id,
                    'stripe_payment_intent' => $session->payment_intent,
                    'status'                => 'paid',
                ]);

                $booking->update([
                    'is_paid' => true,
                    'status'  => 'approved',
                ]);

                if (!$booking->statusLogs()->where('status', 'approved')->exists()) {
                    \App\Models\BookingStatusLog::create([
                        'booking_id' => $booking->id,
                        'user_id'    => $booking->client_id,
                        'status'     => 'approved',
                        'notes'      => 'Payment confirmed via Stripe session sync.',
                    ]);
                }

                return true;
            }
        } catch (\Exception $e) {
            \Log::error('Stripe sync failed: ' . $e->getMessage());
        }

        return false;
    }
    public function createCheckoutSessionFromAmount(float $amount, string $description, int $userId): \Stripe\Checkout\Session
    {
        return \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'unit_amount'  => (int) round($amount * 100), // cents
                    'product_data' => [
                        'name' => $description,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('client.payment.success.pending'),
            'cancel_url'  => route('client.payment.cancel.pending'),
            'metadata'    => ['user_id' => $userId],
        ]);
    }
}
