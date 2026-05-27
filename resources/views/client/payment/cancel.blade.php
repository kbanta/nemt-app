@extends('layouts.app')
@section('title', 'Payment Cancelled')
@section('content')
<div class="max-w-md mx-auto text-center">
    <div class="bg-white rounded-xl shadow p-8">
        <div class="text-6xl mb-4">❌</div>
        <h2 class="text-2xl font-bold text-red-700 mb-2">Payment Cancelled</h2>
        <p class="text-gray-500 mb-6">Your payment was not completed. Your booking is still saved but unpaid.</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('client.bookings.show', $booking) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Try Again</a>
            <a href="{{ route('client.bookings.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">My Bookings</a>
        </div>
    </div>
</div>
@endsection