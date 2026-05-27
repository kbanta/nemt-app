@extends('layouts.app')
@section('title', 'Payment Successful')
@section('content')
<div class="max-w-md mx-auto text-center">
    <div class="bg-white rounded-xl shadow p-8">
        <div class="text-6xl mb-4">✅</div>
        <h2 class="text-2xl font-bold text-green-700 mb-2">Payment Successful!</h2>
        <p class="text-gray-500 mb-6">Your booking <span class="font-mono font-bold">{{ $booking->booking_number }}</span> has been confirmed.</p>
        <div class="bg-gray-50 rounded-lg p-4 text-left text-sm mb-6">
            <p><span class="text-gray-500">Service:</span> {{ $booking->serviceType->name }}</p>
            <p><span class="text-gray-500">Amount Paid:</span> <strong>${{ number_format($booking->final_price, 2) }}</strong></p>
            <p><span class="text-gray-500">Scheduled:</span> {{ $booking->scheduled_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('client.bookings.show', $booking) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">View Booking</a>
            <a href="{{ route('client.payment.invoice', $booking) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">Download Invoice</a>
        </div>
    </div>
</div>
@endsection