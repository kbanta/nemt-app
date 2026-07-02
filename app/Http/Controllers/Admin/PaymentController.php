<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Services\StripeService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private StripeService $stripeService) {}

    public function index()
    {
        $payments = Payment::with('booking.client', 'user')->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function refund(Payment $payment)
    {
        try {
            $this->stripeService->refundPayment($payment);
            return back()->with('success', 'Refund issued successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Refund failed: ' . $e->getMessage());
        }
    }
    public function invoice(Booking $booking)
    {
        $booking->load('serviceType', 'client', 'driver', 'payment');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('client.payment.invoice', compact('booking'));
        return $pdf->download('invoice-' . $booking->booking_number . '.pdf');
    }
}
