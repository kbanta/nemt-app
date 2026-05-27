<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, function ($q) use ($request) {
                $search = '%' . $request->search . '%';
                $q->where(fn($q) => $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search));
            })
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('driver');
        $bookingCount = 0;
        if ($user->role === 'client') {
            $bookingCount = $user->bookings()->count();
        } elseif ($user->role === 'driver' && $user->driver) {
            $bookingCount = $user->driver->bookings()->count();
        }

        return view('admin.users.show', compact('user', 'bookingCount'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,driver,client',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'User updated successfully.');
    }

    public function toggleActive(User $user)
    {
        // Prevent locking yourself out
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'User ' . ($user->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,driver,client',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'role'      => $validated['role'],
            'password'  => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // If role is driver, also create the Driver profile record
        if ($validated['role'] === 'driver') {
            \App\Models\Driver::create([
                'user_id'        => $user->id,
                'license_number' => null,
                'license_expiry' => null,
                'status'         => 'pending',
                'is_available'   => false,
                'total_earnings' => 0,
            ]);
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User created successfully.');
    }
}
