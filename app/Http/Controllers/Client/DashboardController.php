<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $recentBookings = $user->bookingsAsClient()->with('serviceType','payment')->latest()->take(5)->get();
        $stats = [
            'total'     => $user->bookingsAsClient()->count(),
            'pending'   => $user->bookingsAsClient()->where('status','pending')->count(),
            'completed' => $user->bookingsAsClient()->where('status','completed')->count(),
        ];
        return view('client.dashboard', compact('recentBookings','stats'));
    }
}