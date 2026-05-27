<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Notifications\BookingStatusUpdated;

class TripController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index(Request $request)
    {
        $trips = Booking::where('driver_id', auth()->id())
            ->with('client', 'serviceType')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('driver.trips.index', compact('trips'));
    }

    public function show(Booking $booking)
    {
        abort_if($booking->driver_id !== auth()->id(), 403);
        $booking->load('client', 'serviceType', 'statusLogs', 'payment');
        return view('driver.trips.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        abort_if($booking->driver_id !== auth()->id(), 403);
        $request->validate(['status' => 'required|in:in_transit,completed']);
        $this->bookingService->updateStatus($booking, $request->status, auth()->id(), $request->notes);
        $booking->load('serviceType', 'client');

        // 🔔 Notify the client
        $booking->client->notify(new BookingStatusUpdated($booking, $request->status));
        if ($request->status === 'completed') {
            $driver = auth()->user()->driver;
            $driver->increment('total_earnings', $booking->final_price);
        }

        return back()->with('success', 'Trip status updated.');
    }

    public function toggleAvailability()
    {
        $driver = auth()->user()->driver;
        $driver->update(['is_available' => !$driver->is_available]);
        return back()->with('success', 'Availability updated.');
    }
}
