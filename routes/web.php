<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Client;
use App\Http\Controllers\Driver;
use App\Http\Controllers\Setting;

Route::get('/', function () {
    // return view('welcome', [
    //     'isLoggedIn' => auth()->check(),
    //     'user'       => auth()->user(),
    // ]);
    $isLoggedIn   = auth()->check();
    $user         = auth()->user();
    $serviceTypes = \App\Models\ServiceType::where('is_active', true)
                        ->orderBy('base_price')
                        ->get();

    return view('welcome', compact('isLoggedIn', 'user', 'serviceTypes'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Stripe Webhook (no CSRF)
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->name('stripe.webhook');

// Auth Routes
require __DIR__ . '/auth.php';

// Redirect after login based on role
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin'  => redirect()->route('admin.dashboard'),
        'driver' => redirect()->route('driver.dashboard'),
        'client'  => redirect()->route('client.dashboard'),
        'superadmin' => redirect()->route('admin.dashboard'),
    };
})->name('dashboard');

// ─── ADMIN ROUTES ────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/calendar', [Admin\DashboardController::class, 'calendar'])->name('calendar');
    // Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    //user
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/create',  [Admin\UserController::class, 'create'])->name('create');
        Route::post('/',       [Admin\UserController::class, 'store'])->name('store');
        Route::get('/',             [Admin\UserController::class, 'index'])->name('index');
        Route::get('/{user}',       [Admin\UserController::class, 'show'])->name('show');
        Route::put('/{user}',       [Admin\UserController::class, 'update'])->name('update');
        Route::post('/{user}/toggle-active', [Admin\UserController::class, 'toggleActive'])->name('toggle-active');
        Route::delete('/{user}',    [Admin\UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::get('/',                    [Admin\DriverController::class, 'index'])->name('index');
        Route::get('/create',              [Admin\DriverController::class, 'create'])->name('create');
        Route::post('/',                   [Admin\DriverController::class, 'store'])->name('store');
        Route::get('/{driver}',            [Admin\DriverController::class, 'show'])->name('show');
        Route::get('/{driver}/edit',       [Admin\DriverController::class, 'edit'])->name('edit');
        Route::put('/{driver}',            [Admin\DriverController::class, 'update'])->name('update');
        Route::delete('/{driver}',         [Admin\DriverController::class, 'destroy'])->name('destroy');
        Route::post('/{driver}/approve',   [Admin\DriverController::class, 'approve'])->name('approve');
        Route::post('/{driver}/reject',    [Admin\DriverController::class, 'reject'])->name('reject');
        Route::post('/{driver}/toggle-availability', [Admin\DriverController::class, 'toggleAvailability'])->name('toggle-availability');
    });

    Route::prefix('bookings')->name('bookings.')->group(function () {
        // Route::get('/', [Admin\BookingController::class, 'index'])->name('index');
        // Route::get('/{booking}', [Admin\BookingController::class, 'show'])->name('show');
        // Route::post('/{booking}/assign-driver', [Admin\BookingController::class, 'assignDriver'])->name('assign-driver');
        // Route::post('/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('update-status');

        Route::get('/', [Admin\BookingController::class, 'index'])->name('index');
        Route::get('/create', [Admin\BookingController::class, 'create'])->name('create');
        Route::post('/', [Admin\BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [Admin\BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/assign-driver', [Admin\BookingController::class, 'assignDriver'])->name('assign-driver');
        Route::post('/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('update-status');
        Route::put('/bookings/{booking}', [Admin\BookingController::class, 'update'])->name('update');
        Route::delete('/bookings/{booking}', [Admin\BookingController::class, 'destroy'])->name('destroy');
        Route::patch('/bookings/{booking}/payment-status', [Admin\BookingController::class, 'updatePaymentStatus'])->name('update-payment-status');

        // ↓ pending routes FIRST — before any {booking} wildcard
        Route::get('/payment/success/pending', [Admin\PaymentController::class, 'successPending'])->name('payment.success.pending');
        Route::get('/payment/cancel/pending',  [Admin\PaymentController::class, 'cancelPending'])->name('payment.cancel.pending');

        // ↓ wildcard routes AFTER
        Route::get('/payment/success/{booking}', [Admin\PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/cancel/{booking}',  [Admin\PaymentController::class, 'cancel'])->name('payment.cancel');
        Route::get('/payment/invoice/{booking}', [Admin\PaymentController::class, 'invoice'])->name('payment.invoice');
    });

    Route::resource('service-types', Admin\ServiceTypeController::class);

    Route::get('/payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/refund', [Admin\PaymentController::class, 'refund'])->name('payments.refund');
    Route::get('/payment/success/{booking}', [Client\PaymentController::class, 'success'])->name('client.payment.success');
    // ── Superadmin only ───────────────────────────────────
    Route::middleware('superadmin')->group(function () {
        Route::get('/settings',              [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings',             [Admin\SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/create',      [Admin\SettingController::class, 'store'])->name('settings.store');
        Route::delete('/settings/{setting}', [Admin\SettingController::class, 'destroy'])->name('settings.destroy');
        Route::post('/settings/test-mail',   [Admin\SettingController::class, 'testMail'])->name('settings.test-mail');
    });
});

// ─── CLIENT ROUTES ───────────────────────────────────────
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [Client\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('bookings', Client\BookingController::class)->except(['edit', 'update']);

    // ↓ pending routes FIRST — before any {booking} wildcard
    Route::get('/payment/success/pending', [Client\PaymentController::class, 'successPending'])->name('payment.success.pending');
    Route::get('/payment/cancel/pending',  [Client\PaymentController::class, 'cancelPending'])->name('payment.cancel.pending');

    // ↓ wildcard routes AFTER
    Route::get('/payment/success/{booking}', [Client\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{booking}',  [Client\PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/invoice/{booking}', [Client\PaymentController::class, 'invoice'])->name('payment.invoice');
});

// ─── DRIVER ROUTES ───────────────────────────────────────
Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/dashboard', [Driver\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/trips', [Driver\TripController::class, 'index'])->name('trips.index');
    Route::get('/trips/{booking}', [Driver\TripController::class, 'show'])->name('trips.show');
    Route::post('/trips/{booking}/status', [Driver\TripController::class, 'updateStatus'])->name('trips.update-status');
    Route::post('/toggle-availability', [Driver\TripController::class, 'toggleAvailability'])->name('toggle-availability');

    Route::post('/documents', [Driver\DocumentController::class, 'store'])->name('documents.store');
});
Route::patch('/notifications/mark-all-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth')->name('notifications.markAllRead');

Route::get('/notifications', function () {
    $notifications = auth()->user()->notifications()->paginate(20);
    return view('notifications.index', compact('notifications'));
})->middleware('auth')->name('notifications.index');
Route::post('/notifications/{id}/read', function (string $id) {
    auth()->user()->notifications()->findOrFail($id)->markAsRead();
    return response()->json(['ok' => true]);
})->middleware('auth')->name('notifications.markRead');
