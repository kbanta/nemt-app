<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\StripeService;
use App\Services\BookingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Notifications\BookingCreatedAdmin;
use App\Notifications\BookingConfirmedClient;
use App\Models\User;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private StripeService $stripeService, private BookingService $bookingService,) {}

    public function success(Request $request, Booking $booking)
    {
        $booking->load('payment', 'serviceType');

        // If booking is not yet marked paid, sync directly from Stripe
        if (!$booking->is_paid) {
            $sessionId = $request->query('session_id');

            if ($sessionId) {
                $this->stripeService->syncSessionPayment($sessionId, $booking);
                // Reload after sync
                $booking->refresh()->load('payment', 'serviceType');
            }
        }

        return view('client.payment.success', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        return view('client.payment.cancel', compact('booking'));
    }

    public function invoice(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load('serviceType', 'client', 'driver', 'payment');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('client.payment.invoice', compact('booking'));
        return $pdf->download('invoice-' . $booking->booking_number . '.pdf');
    }
    // Stripe confirmed payment — NOW save the booking
    public function successPending(Request $request)
    {
        $data = session('pending_booking');

        if (!$data) {
            return redirect()->route('client.bookings.index')
                ->with('error', 'Booking session expired. Please try again.');
        }

        $booking = $this->bookingService->createBooking($data, auth()->id());

        Payment::create([
            'booking_id' => $booking->id,
            'user_id'    => auth()->id(),
            'amount'     => $booking->final_price,
            'status'     => 'paid',        // already paid via Stripe
        ]);

        $booking->update(['is_paid' => true]);

        session()->forget('pending_booking');

        // 🔔 Notify admins
        User::where('role', 'admin')->each(
            fn($admin) => $admin->notify(new BookingCreatedAdmin($booking))
        );

        // 🔔 Notify client
        auth()->user()->notify(new BookingConfirmedClient($booking));

        return redirect()->route('client.bookings.show', $booking)
            ->with('success', 'Payment successful! Your booking is confirmed.');
    }

    // User cancelled on Stripe — discard, let them try again
    public function cancelPending(Request $request)
    {
        session()->forget('pending_booking');

        return redirect()->route('client.bookings.create')
            ->with('error', 'Payment cancelled. Your booking was not saved.');
    }
}
