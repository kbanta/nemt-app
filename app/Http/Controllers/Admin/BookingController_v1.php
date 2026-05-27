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
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\BookingAssignedDriver;


class BookingController extends Controller
{
    use AuthorizesRequests;  // ← add this

    public function __construct(
        private BookingService $bookingService,
        private StripeService $stripeService
    ) {}

    public function index(Request $request)
    {
        $bookings = Booking::with('client','serviceType','payment')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('client','driver','serviceType','statusLogs.user','payment');
        $drivers = User::where('role','driver')
            ->whereHas('driver', fn($q) => $q->where('status','approved')->where('is_available', true))
            ->get();
        return view('admin.bookings.show', compact('booking','drivers'));
    }

    public function assignDriver(Request $request, Booking $booking)
    {
        $request->validate(['driver_id' => 'required|exists:users,id']);
        $booking->update(['driver_id' => $request->driver_id]);
        $this->bookingService->updateStatus($booking, 'assigned', auth()->id(), 'Driver assigned by admin.');
        $booking->driver->notify(new BookingAssignedDriver($booking));
        return back()->with('success', 'Driver assigned successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,approved,assigned,in_transit,completed,cancelled']);
        $this->bookingService->updateStatus($booking, $request->status, auth()->id(), $request->notes);
        return back()->with('success', 'Booking status updated.');
    }
    public function create()
    {
        $serviceTypes = ServiceType::where('is_active', true)->get();
        return view('client.bookings.create', compact('serviceTypes'));
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking($request->validated(), auth()->id());

        Payment::create([
            'booking_id' => $booking->id,
            'user_id'    => auth()->id(),
            'amount'     => $booking->final_price,
            'status'     => 'pending',
        ]);

        $session = $this->stripeService->createCheckoutSession($booking);
        return redirect($session->url);
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
}