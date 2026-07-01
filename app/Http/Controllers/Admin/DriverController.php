<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $drivers = Driver::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $search = '%' . $request->search . '%';
                $q->whereHas('user', fn($q) => $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search))
                  ->orWhere('license_number', 'like', $search);
            })
            ->latest()
            ->paginate(15);

        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'phone'           => 'nullable|string|max:20',
            'password'        => 'required|string|min:8|confirmed',
            'license_number'  => 'required|string|max:100|unique:drivers,license_number',
            'license_expiry'  => 'required|date|after:today',
            'status'          => 'required|in:pending,approved,rejected',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role'     => 'driver',
            ]);

            Driver::create([
                'user_id'        => $user->id,
                'license_number' => $validated['license_number'],
                'license_expiry' => $validated['license_expiry'],
                'status'         => $validated['status'],
                'is_available'   => false,
                'total_earnings' => 0,
            ]);
        });

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    public function show(Driver $driver)
    {
        $driver->load('user', 'vehicles', 'documents');
        $completedTrips  = $driver->bookings()->where('status', 'completed')->count();
        $totalEarnings   = $driver->total_earnings;
        $activeBookings  = $driver->bookings()->whereIn('status', ['assigned', 'in_transit'])->count();

        return view('admin.drivers.show', compact('driver', 'completedTrips', 'totalEarnings', 'activeBookings'));
    }

    public function edit(Driver $driver)
    {
        $driver->load('user');
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $driver->load('user');

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $driver->user->id,
            'phone'          => 'nullable|string|max:20',
            'password'       => 'nullable|string|min:8|confirmed',
            'license_number' => 'required|string|max:100|unique:drivers,license_number,' . $driver->id,
            'license_expiry' => 'required|date',
            'status'         => 'required|in:pending,approved,rejected',
            'is_available'   => 'boolean',
        ]);

        $isAvailable = $request->boolean('is_available');

        DB::transaction(function () use ($validated, $driver, $isAvailable) {
            $userData = [
                'name'  => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ];
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $driver->user->update($userData);

            $driver->update([
                'license_number' => $validated['license_number'],
                'license_expiry' => $validated['license_expiry'],
                'status'         => $validated['status'],
                'is_available'   => $isAvailable,
            ]);
        });

        return redirect()->route('admin.drivers.show', $driver)
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $driver->load('user');
        DB::transaction(function () use ($driver) {
            $driver->delete();
            $driver->user->delete();
        });

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }

    public function approve(Driver $driver)
    {
        $driver->update(['status' => 'approved']);
        return back()->with('success', 'Driver approved.');
    }

    public function reject(Driver $driver)
    {
        $driver->update(['status' => 'rejected']);
        return back()->with('success', 'Driver rejected.');
    }

    public function toggleAvailability(Driver $driver)
    {
        $driver->update(['is_available' => !$driver->is_available]);
        return back()->with('success', 'Availability updated.');
    }
}