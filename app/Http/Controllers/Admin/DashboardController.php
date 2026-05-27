<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings'   => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'completed_trips'  => Booking::where('status', 'completed')->count(),
            'total_revenue'    => Payment::where('status', 'paid')->sum('amount'),
            'total_clients'    => User::where('role', 'client')->count(),
            'total_drivers'    => User::where('role', 'driver')->count(),
        ];

        $recentBookings = Booking::with('client', 'serviceType')->latest()->take(5)->get();

        // Bookings per day — last 30 days
        $bookingsByDay = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fill in missing days with 0
        $days     = collect();
        $counts   = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date   = now()->subDays($i)->format('Y-m-d');
            $label  = now()->subDays($i)->format('M d');
            $days->push($label);
            $counts->push($bookingsByDay->get($date, 0));
        }

        // Bookings by status
        $byStatus = Booking::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Calendar bookings — current + next month to cover navigation
        $calendarBookings = Booking::with('client', 'serviceType')
            ->where('scheduled_at', '>=', now()->startOfMonth()->subMonth())
            ->where('scheduled_at', '<=', now()->endOfMonth()->addMonth())
            ->get()
            ->map(fn($b) => [
                'id'             => $b->id,
                'booking_number' => $b->booking_number,
                'date'           => $b->scheduled_at->format('Y-m-d'),
                'time'           => $b->scheduled_at->format('H:i'),
                'client'         => $b->client->name,
                'service'        => $b->serviceType->name,
                'pickup'         => $b->pickup_address,
                'status'         => $b->status,
            ]);

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'days',
            'counts',
            'byStatus',
            'calendarBookings'
        ));
    }
    public function calendar()
    {
        $calendarBookings = Booking::with('client', 'serviceType')
            ->get()
            ->map(fn($b) => [
                'id'             => $b->id,
                'booking_number' => $b->booking_number,
                'date'           => $b->scheduled_at->format('Y-m-d'),
                'time'           => $b->scheduled_at->format('H:i'),
                'client'         => $b->client->name,
                'service'        => $b->serviceType->name,
                'pickup'         => $b->pickup_address,
                'status'         => $b->status,
            ]);

        return view('admin.calendar', compact('calendarBookings'));
    }
}
