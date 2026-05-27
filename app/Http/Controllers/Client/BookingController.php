<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\ServiceType;
use App\Models\User;
use App\Services\BookingService;
use App\Services\StripeService;
use App\Models\Payment;
use App\Notifications\BookingCreatedAdmin;
use App\Notifications\BookingConfirmedClient;
use App\Notifications\BookingAssignedDriver;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private BookingService $bookingService,
        private StripeService $stripeService
    ) {}

    public function index()
    {
        $bookings = auth()->user()->bookingsAsClient()->with('serviceType', 'payment')->latest()->paginate(10);
        return view('client.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $serviceTypes = ServiceType::where('is_active', true)->get();
        return view('client.bookings.create', compact('serviceTypes'));
    }

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        // Cash, Check, or Insurance — save immediately, no Stripe
        if ($data['payment_method'] !== 'online') {
            $booking = $this->bookingService->createBooking($data, auth()->id());

            Payment::create([
                'booking_id' => $booking->id,
                'user_id'    => auth()->id(),
                'amount'     => $booking->final_price,
                'status'     => 'pending',
            ]);

            $this->sendBookingNotifications($booking);

            $message = match ($data['payment_method']) {
                'insurance' => 'Booking confirmed! We will verify your insurance coverage shortly.',
                'cash'      => 'Booking confirmed! Payment due at time of service.',
                'check'     => 'Booking confirmed! Please bring your check at time of service.',
                default     => 'Booking confirmed!',
            };

            return redirect()->route('client.bookings.show', $booking)
                ->with('success', $message);
        }

        // Online — store in session first, don't save to DB yet
        session(['pending_booking' => $data]);

        $serviceType = ServiceType::findOrFail($data['service_type_id']);
        $amount      = $serviceType->calculatePrice((float) $data['distance_miles']);

        $session = $this->stripeService->createCheckoutSessionFromAmount(
            amount: $amount,
            description: $serviceType->name,
            userId: auth()->id(),
        );

        return redirect($session->url);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load('serviceType', 'driver', 'statusLogs.user', 'payment');
        return view('client.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }
        $this->bookingService->updateStatus($booking, 'cancelled', auth()->id(), 'Cancelled by client.');
        return redirect()->route('client.bookings.index')->with('success', 'Booking cancelled.');
    }

    // ─── Private helper ───────────────────────────────────────────────────────

    private function sendBookingNotifications(Booking $booking): void
    {
        // 1. Notify all admins
        User::where('role', 'admin')->each(
            fn($admin) => $admin->notify(new BookingCreatedAdmin($booking))
        );

        // 2. Notify the client
        auth()->user()->notify(new BookingConfirmedClient($booking));

        // 3. Notify assigned driver (if one was already set during booking creation)
        if ($booking->driver_id && $booking->driver) {
            $booking->driver->notify(new BookingAssignedDriver($booking));
        }
    }
}
