<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Models\ServiceType;
use App\Services\StripeService;
use App\Models\Payment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\BookingStatusUpdated;
use App\Notifications\BookingAssignedDriver;

class BookingController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private BookingService $bookingService,
        private StripeService $stripeService
    ) {}

    public function index(Request $request)
    {
        $bookings = Booking::with('client', 'serviceType', 'payment')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $search = '%' . $request->search . '%';
                $q->where(function ($q) use ($search) {
                    $q->where('booking_number', 'like', $search)
                        ->orWhere('pickup_address', 'like', $search)
                        ->orWhere('dropoff_address', 'like', $search)
                        ->orWhere('patient_name', 'like', $search)
                        ->orWhereHas('client', fn($q) => $q->where('name', 'like', $search)
                            ->orWhere('email', 'like', $search));
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        $serviceTypes = ServiceType::where('is_active', true)
            ->orderBy('name')
            ->get();
        $drivers = User::where('role', 'driver')
            ->whereHas('driver', fn($q) => $q->where('status', 'approved'))
            ->orderBy('name')
            ->get();

        return view('admin.bookings.create', compact('clients', 'serviceTypes', 'drivers'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'patient_name'    => 'required|string|max:255',
    //         'service_type_id' => 'required|exists:service_types,id',
    //         'pickup_address'  => 'required|string|max:255',
    //         'dropoff_address' => 'required|string|max:255',
    //         'distance_miles'  => 'required|numeric|min:0.1',
    //         'scheduled_at'    => 'required|date',
    //         'notes'           => 'nullable|string|max:1000',
    //         'payment_method'  => 'required|in:online,cash,check,manual',
    //     ]);

    //     // cash, check, manual — save immediately, no Stripe
    //     if ($validated['payment_method'] !== 'online') {
    //         $booking = $this->bookingService->createBooking($validated, auth()->id());

    //         $isPaid        = $validated['payment_method'] === 'manual';
    //         $paymentStatus = $isPaid ? 'paid' : 'pending';

    //         $booking->update([
    //             'status'  => 'approved',
    //             'is_paid' => $isPaid,
    //         ]);

    //         $this->bookingService->updateStatus(
    //             $booking,
    //             'approved',
    //             auth()->id(),
    //             'Booking created by admin. Payment method: ' . $validated['payment_method']
    //         );

    //         Payment::create([
    //             'booking_id' => $booking->id,
    //             'user_id'    => auth()->id(),
    //             'amount'     => $booking->final_price,
    //             'status'     => $paymentStatus,
    //         ]);

    //         return redirect()->route('admin.bookings.show', $booking)
    //             ->with('success', 'Booking created. Payment method: ' . ucfirst($validated['payment_method']));
    //     }

    //     // stripe — save booking first, then create checkout session
    //     $booking = $this->bookingService->createBooking($validated, auth()->id());

    //     $booking->update(['status' => 'approved']);

    //     $this->bookingService->updateStatus(
    //         $booking,
    //         'approved',
    //         auth()->id(),
    //         'Booking created by admin. Payment method: Stripe'
    //     );

    //     $payment = Payment::create([
    //         'booking_id' => $booking->id,
    //         'user_id'    => auth()->id(),
    //         'amount'     => $booking->final_price,
    //         'status'     => 'pending',
    //     ]);

    //     try {
    //         $session = $this->stripeService->createCheckoutSession($booking);

    //         $payment->update(['stripe_session_id' => $session->id]);

    //         // Store the URL on the booking itself
    //         $booking->update(['stripe_payment_url' => $session->url]);

    //         return redirect()->route('admin.bookings.show', $booking)
    //             ->with('success', 'Booking created. Payment link is ready to share with the client.');
    //     } catch (\Exception $e) {
    //         return back()
    //             ->with('error', 'Booking saved but Stripe link failed: ' . $e->getMessage())
    //             ->withInput();
    //     }
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name'           => 'required|string|max:255',
            'service_type_id'        => 'required|exists:service_types,id',
            'pickup_address'         => 'required|string|max:255',
            'dropoff_address'        => 'required|string|max:255',
            'distance_miles'         => 'required|numeric|min:0.1',
            'scheduled_at'           => 'required|date',
            'notes'                  => 'nullable|string|max:1000',
            'payment_method'         => 'required|in:online,cash,check,manual,insurance',
            'insurance_provider'     => 'required_if:payment_method,insurance|nullable|string|max:100',
            'insurance_member_id'    => 'required_if:payment_method,insurance|nullable|string|max:100',
            'insurance_group_number' => 'nullable|string|max:100',
        ]);

        // cash, check, manual, insurance — save immediately, no Stripe
        if ($validated['payment_method'] !== 'online') {
            $booking = $this->bookingService->createBooking($validated, auth()->id());

            $isPaid        = $validated['payment_method'] === 'manual';
            $paymentStatus = $isPaid ? 'paid' : 'pending';

            $booking->update([
                'status'  => 'approved',
                'is_paid' => $isPaid,
            ]);

            $this->bookingService->updateStatus(
                $booking,
                'approved',
                auth()->id(),
                'Booking created by admin. Payment method: ' . $validated['payment_method']
            );

            Payment::create([
                'booking_id' => $booking->id,
                'user_id'    => auth()->id(),
                'amount'     => $booking->final_price,
                'status'     => $paymentStatus,
            ]);

            $message = match($validated['payment_method']) {
                'insurance' => 'Booking created. Insurance coverage will be verified before the trip.',
                'manual'    => 'Booking created. Payment marked as paid.',
                'cash'      => 'Booking created. Payment due at time of service.',
                'check'     => 'Booking created. Payment by check at time of service.',
                default     => 'Booking created.',
            };

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', $message);
        }

        // stripe — same as before
        $booking = $this->bookingService->createBooking($validated, auth()->id());
        $booking->update(['status' => 'approved']);
        $this->bookingService->updateStatus($booking, 'approved', auth()->id(), 'Booking created by admin. Payment method: Stripe');

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id'    => auth()->id(),
            'amount'     => $booking->final_price,
            'status'     => 'pending',
        ]);

        try {
            $session = $this->stripeService->createCheckoutSession($booking);
            $payment->update(['stripe_session_id' => $session->id]);
            $booking->update(['stripe_payment_url' => $session->url]);

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking created. Payment link is ready to share with the client.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Booking saved but Stripe link failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    // public function show(Booking $booking)
    // {
    //     $booking->load('client', 'driver', 'serviceType', 'statusLogs.user', 'payment');
    //     $drivers = User::where('role', 'driver')
    //         ->whereHas('driver', fn($q) => $q->where('status', 'approved')->where('is_available', true))
    //         ->get();
    //     return view('admin.bookings.show', compact('booking', 'drivers'));
    // }

    public function assignDriver(Request $request, Booking $booking)
    {
        $request->validate(['driver_id' => 'required|exists:users,id']);
        $booking->update(['driver_id' => $request->driver_id]);
        $this->bookingService->updateStatus($booking, 'assigned', auth()->id(), 'Driver assigned by admin.');
        $booking->load('serviceType', 'client', 'driver');

        // 🔔 Notify the client
        $booking->client->notify(new BookingStatusUpdated($booking, 'assigned'));

        // 🔔 Notify the assigned driver
        $booking->driver->notify(new BookingAssignedDriver($booking));
        return back()->with('success', 'Driver assigned successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,approved,assigned,in_transit,completed,cancelled']);
        $this->bookingService->updateStatus($booking, $request->status, auth()->id(), $request->notes ?? null);
        $booking->load('serviceType', 'client');

        // 🔔 Notify the client on every status change
        $booking->client->notify(new BookingStatusUpdated($booking, $request->status));
        return back()->with('success', 'Booking status updated.');
    }
    public function show(Booking $booking)
    {
        $booking->load('client', 'driver', 'serviceType', 'statusLogs.user', 'payment');
        $drivers = User::where('role', 'driver')
            ->whereHas('driver', fn($q) => $q->where('status', 'approved')->where('is_available', true))
            ->get();
        $serviceTypes = ServiceType::where('is_active', true)->orderBy('name')->get(); // ← add this
        return view('admin.bookings.show', compact('booking', 'drivers', 'serviceTypes')); // ← add serviceTypes
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'patient_name'    => 'required|string|max:255',
            'service_type_id' => 'required|exists:service_types,id',
            'pickup_address'  => 'required|string|max:255',
            'dropoff_address' => 'required|string|max:255',
            'scheduled_at'    => 'required|date',
            'distance_miles'  => 'required|numeric|min:0',
            'payment_method'  => 'required|in:online,cash,check,manual',
            'final_price'     => 'required|numeric|min:0',
            'notes'           => 'nullable|string|max:1000',
        ]);

        // Recalculate final price from service type if distance changed
        $serviceType = ServiceType::findOrFail($validated['service_type_id']);
        $validated['final_price'] = $serviceType->base_price
            + ($validated['distance_miles'] * $serviceType->price_per_mile);

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        // Cancel any pending payment first
        if ($booking->payment && $booking->payment->status === 'pending') {
            $booking->payment->update(['status' => 'cancelled']);
        }

        $bookingNumber = $booking->booking_number;
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$bookingNumber} has been deleted.");
    }
    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,refunded,cancelled',
        ]);

        if (!$booking->payment) {
            return back()->with('error', 'No payment record found for this booking.');
        }

        $oldStatus = $booking->payment->status;
        $newStatus = $request->status;

        $booking->payment->update(['status' => $newStatus]);

        // Sync is_paid on the booking itself
        $booking->update([
            'is_paid' => $newStatus === 'paid',
        ]);

        // Log it as a status note
        $this->bookingService->updateStatus(
            $booking,
            $booking->status,
            auth()->id(),
            "Payment status changed from {$oldStatus} to {$newStatus} by admin."
        );

        return back()->with('success', 'Payment status updated to ' . ucfirst($newStatus) . '.');
    }
}
