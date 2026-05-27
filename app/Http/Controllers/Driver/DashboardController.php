<?php
namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = auth()->user();
        $assignedTrips   = Booking::where('driver_id', $driver->id)->where('status','assigned')->with('client','serviceType')->get();
        $completedTrips  = Booking::where('driver_id', $driver->id)->where('status','completed')->count();
        $inTransitTrips  = Booking::where('driver_id', $driver->id)->where('status','in_transit')->with('client','serviceType')->get();
        return view('driver.dashboard', compact('assignedTrips','completedTrips','inTransitTrips'));
    }
}