@extends('layouts.app')
@section('title', 'Booking Details')
@section('content')

<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.12s;
    }
    .back-link:hover { color: #0f172a; }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }
    .detail-main  { display: flex; flex-direction: column; gap: 16px; min-width: 0; }
    .detail-aside { display: flex; flex-direction: column; gap: 16px; }

    .detail-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .detail-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .detail-card-header-left { display: flex; align-items: center; gap: 10px; }
    .detail-card-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .detail-card-title { font-size: 13.5px; font-weight: 700; color: #0f172a; }
    .detail-card-body  { padding: 22px; }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .info-label {
        font-size: 11.5px; font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 5px;
    }
    .info-value { font-size: 14px; font-weight: 600; color: #1e293b; line-height: 1.4; }

    /* Hero */
    .booking-hero {
        background: linear-gradient(135deg, #0b1a2e 0%, #1e3a5f 50%, #2563eb 100%);
        border-radius: 14px;
        padding: 24px 26px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .booking-hero-number {
        font-family: 'DM Mono', monospace;
        font-size: 13px; font-weight: 500;
        color: rgba(255,255,255,0.5); margin-bottom: 4px;
    }
    .booking-hero-service {
        font-size: 20px; font-weight: 800; color: #fff;
        letter-spacing: -0.02em; line-height: 1.2;
    }
    .booking-hero-meta {
        display: flex; align-items: center; gap: 14px;
        margin-top: 10px; flex-wrap: wrap;
    }
    .hero-meta-item {
        display: flex; align-items: center; gap: 5px;
        font-size: 12.5px; color: rgba(255,255,255,0.6);
    }
    .booking-hero-price { text-align: right; flex-shrink: 0; }
    .price-label {
        font-size: 11px; color: rgba(255,255,255,0.45);
        text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px;
    }
    .price-value {
        font-size: 28px; font-weight: 800; color: #fff;
        letter-spacing: -0.03em; line-height: 1;
    }
    .price-paid {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11.5px; font-weight: 600; margin-top: 5px;
    }

    /* Route */
    .route-visual { display: flex; flex-direction: column; gap: 0; }
    .route-point  { display: flex; align-items: flex-start; gap: 12px; }
    .route-dot-wrap {
        display: flex; flex-direction: column;
        align-items: center; flex-shrink: 0; padding-top: 2px;
    }
    .route-dot { width: 10px; height: 10px; border-radius: 50%; border: 2px solid; flex-shrink: 0; }
    .route-dot.pickup  { border-color: #2563eb; background: #eff6ff; }
    .route-dot.dropoff { border-color: #16a34a; background: #f0fdf4; }
    .route-line {
        width: 2px; height: 28px;
        background: repeating-linear-gradient(to bottom,#e2e8f0 0,#e2e8f0 4px,transparent 4px,transparent 8px);
        margin: 3px 0;
    }
    .route-point-label {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.07em; color: #94a3b8; margin-bottom: 2px;
    }
    .route-point-value { font-size: 13.5px; font-weight: 500; color: #334155; line-height: 1.4; }
    .route-distance {
        display: inline-flex; align-items: center; gap: 5px; margin-top: 10px;
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 6px 12px; font-size: 12.5px; font-weight: 600; color: #475569;
    }

    /* Timeline */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-item { display: flex; gap: 12px; position: relative; padding-bottom: 18px; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-left {
        display: flex; flex-direction: column;
        align-items: center; flex-shrink: 0; width: 28px;
    }
    .timeline-dot {
        width: 10px; height: 10px; border-radius: 50%;
        background: #2563eb; border: 2px solid #bfdbfe;
        flex-shrink: 0; margin-top: 3px; z-index: 1;
    }
    .timeline-item:last-child .timeline-dot { background: #16a34a; border-color: #bbf7d0; }
    .timeline-connector { width: 2px; flex: 1; background: #e2e8f0; margin-top: 4px; }
    .timeline-item:last-child .timeline-connector { display: none; }
    .timeline-status { font-size: 13px; font-weight: 700; color: #1e293b; line-height: 1.3; }
    .timeline-meta   { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }
    .timeline-notes  {
        font-size: 12.5px; color: #64748b; margin-top: 4px;
        background: #f8fafc; border-radius: 6px; padding: 6px 10px;
        border-left: 2px solid #e2e8f0;
    }

    /* Cancel btn */
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fef2f2; color: #dc2626;
        padding: 9px 18px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        border: 1px solid #fecaca; cursor: pointer;
        transition: all 0.13s; font-family: 'DM Sans', sans-serif;
    }
    .btn-cancel:hover { background: #fee2e2; border-color: #fca5a5; }

    /* Invoice btn */
    .btn-invoice {
        display: inline-flex; align-items: center; gap: 6px;
        background: #16a34a; color: #fff;
        padding: 9px 18px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; text-decoration: none;
        transition: all 0.13s;
        box-shadow: 0 1px 3px rgba(22,163,74,0.25);
    }
    .btn-invoice:hover {
        background: #15803d;
        box-shadow: 0 4px 12px rgba(22,163,74,0.3);
        transform: translateY(-1px);
    }

    @media (max-width: 960px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .booking-hero { flex-direction: column; align-items: flex-start; gap: 16px; }
        .booking-hero-price { text-align: left; }
        .info-grid { grid-template-columns: 1fr; gap: 14px; }
        .detail-card-body { padding: 16px; }
    }
</style>

{{-- Back --}}
<a href="{{ route('client.bookings.index') }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 5l-7 7 7 7"/>
    </svg>
    Back to Bookings
</a>

{{-- ── HERO ─────────────────────────────────────── --}}
<div class="booking-hero">
    <div>
        <div class="booking-hero-number">{{ $booking->booking_number }}</div>
        <div class="booking-hero-service">{{ $booking->serviceType->name }}</div>
        <div class="booking-hero-meta">
            <div class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                     stroke="rgba(255,255,255,0.5)" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
                {{ $booking->scheduled_at->format('M d, Y · H:i') }}
            </div>
            <span class="badge {{ $booking->getStatusBadgeClass() }}">
                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
            </span>
        </div>
    </div>
    <div class="booking-hero-price">
        <div class="price-label">Total Fare</div>
        <div class="price-value">${{ number_format($booking->final_price, 2) }}</div>
        @if($booking->is_paid)
            <div class="price-paid" style="color:#4ade80;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Paid
            </div>
        @else
            <div class="price-paid" style="color:rgba(255,255,255,0.35);">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Payment pending
            </div>
        @endif
    </div>
</div>

{{-- ── TWO-COLUMN LAYOUT ────────────────────────── --}}
<div class="detail-grid">

    {{-- ── MAIN ──────────────────────────────────── --}}
    <div class="detail-main">

        {{-- Trip Details --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#eff6ff;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#2563eb" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="10" r="3"/>
                            <path d="M12 2a8 8 0 0 1 8 8c0 5.25-8 13-8 13S4 15.25 4 10a8 8 0 0 1 8-8z"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Trip Details</span>
                </div>
            </div>
            <div class="detail-card-body">

                {{-- Route --}}
                <div class="route-visual" style="margin-bottom:24px;">
                    <div class="route-point">
                        <div class="route-dot-wrap">
                            <div class="route-dot pickup"></div>
                            <div class="route-line"></div>
                        </div>
                        <div>
                            <div class="route-point-label">Pickup</div>
                            <div class="route-point-value">{{ $booking->pickup_address }}</div>
                        </div>
                    </div>
                    <div class="route-point">
                        <div class="route-dot-wrap">
                            <div class="route-dot dropoff"></div>
                        </div>
                        <div>
                            <div class="route-point-label">Dropoff</div>
                            <div class="route-point-value">{{ $booking->dropoff_address }}</div>
                        </div>
                    </div>
                    <div class="route-distance" style="margin-left:22px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                             stroke="#64748b" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                        </svg>
                        {{ $booking->distance_miles }} miles total
                    </div>
                </div>

                {{-- Info grid --}}
                <div style="border-top:1px solid #f1f5f9; padding-top:20px;">
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Patient Name</div>
                            <div class="info-value">{{ $booking->patient_name }}</div>
                        </div>
                        <div>
                            <div class="info-label">Service Type</div>
                            <div class="info-value">{{ $booking->serviceType->name }}</div>
                        </div>
                        <div>
                            <div class="info-label">Scheduled</div>
                            <div class="info-value">{{ $booking->scheduled_at->format('M d, Y') }}</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                                {{ $booking->scheduled_at->format('H:i') }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Payment Method</div>
                            <div class="info-value">
                                @if($booking->payment_method === 'online')
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                 background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;
                                                 padding:3px 10px;border-radius:999px;font-size:12px;font-weight:600;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                                        </svg>
                                        Online (Stripe)
                                    </span>
                                @elseif($booking->payment_method === 'cash')
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                 background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;
                                                 padding:3px 10px;border-radius:999px;font-size:12px;font-weight:600;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                        </svg>
                                        Cash
                                    </span>
                                @elseif($booking->payment_method === 'check')
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                 background:#fdf4ff;color:#9333ea;border:1px solid #e9d5ff;
                                                 padding:3px 10px;border-radius:999px;font-size:12px;font-weight:600;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                        </svg>
                                        Check
                                    </span>
                                @elseif($booking->payment_method === 'insurance')
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;
                                                padding:3px 10px;border-radius:999px;font-size:12px;font-weight:600;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        </svg>
                                        Insurance
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Assigned Driver</div>
                            @if($booking->driver)
                                <div style="display:flex;align-items:center;gap:7px;margin-top:2px;">
                                    <div style="width:26px;height:26px;border-radius:7px;flex-shrink:0;
                                                background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                                display:flex;align-items:center;justify-content:center;
                                                font-size:10px;font-weight:700;color:#fff;">
                                        {{ strtoupper(substr($booking->driver->name, 0, 1)) }}
                                    </div>
                                    <span class="info-value">{{ $booking->driver->name }}</span>
                                </div>
                            @else
                                <span style="font-size:13px;color:#94a3b8;">Not yet assigned</span>
                            @endif
                        </div>
                        <div>
                            <div class="info-label">Amount</div>
                            <div class="info-value" style="font-size:16px;color:#2563eb;">
                                ${{ number_format($booking->final_price, 2) }}
                            </div>
                        </div>
                        @if($booking->notes)
                        <div style="grid-column:span 2;">
                            <div class="info-label">Notes</div>
                            <div style="font-size:13.5px;color:#475569;background:#f8fafc;
                                        border-radius:8px;padding:10px 14px;margin-top:4px;
                                        border-left:3px solid #e2e8f0;line-height:1.55;">
                                {{ $booking->notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        @if($booking->is_paid || $booking->status === 'pending')
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#f8fafc;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#64748b" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Actions</span>
                </div>
            </div>
            <div class="detail-card-body" style="display:flex;gap:10px;flex-wrap:wrap;">
                @if($booking->is_paid)
                    <a href="{{ route('client.payment.invoice', $booking) }}" class="btn-invoice">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download Invoice
                    </a>
                @endif
                @if($booking->status === 'pending')
                    <form method="POST" action="{{ route('client.bookings.destroy', $booking) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-cancel"
                                onclick="return confirm('Are you sure you want to cancel this booking?')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6"  y1="6" x2="18" y2="18"/>
                            </svg>
                            Cancel Booking
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endif

    </div>

    {{-- ── ASIDE ──────────────────────────────────── --}}
    <div class="detail-aside">

        {{-- Status Timeline --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#fdf4ff;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#9333ea" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="20" x2="12" y2="10"/>
                            <line x1="18" y1="20" x2="18" y2="4"/>
                            <line x1="6"  y1="20" x2="6"  y2="16"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Status History</span>
                </div>
                <span style="font-size:11.5px;font-weight:600;color:#94a3b8;">
                    {{ $booking->statusLogs->count() }} update{{ $booking->statusLogs->count() != 1 ? 's' : '' }}
                </span>
            </div>
            <div class="detail-card-body" style="padding:20px 22px;">
                @if($booking->statusLogs->isEmpty())
                    <p style="font-size:13px;color:#94a3b8;text-align:center;padding:12px 0;">
                        No status updates yet.
                    </p>
                @else
                    <div class="timeline">
                        @foreach($booking->statusLogs as $log)
                        <div class="timeline-item">
                            <div class="timeline-left">
                                <div class="timeline-dot"></div>
                                <div class="timeline-connector"></div>
                            </div>
                            <div style="flex:1;min-width:0;padding-bottom:2px;">
                                <div class="timeline-status">
                                    {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                                </div>
                                <div class="timeline-meta">
                                    {{ $log->created_at->format('M d, Y · H:i') }}
                                </div>
                                @if($log->notes)
                                    <div class="timeline-notes">{{ $log->notes }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Payment Summary --}}
        @if($booking->payment)
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#f0fdf4;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#16a34a" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Payment</span>
                </div>
                <span class="badge"
                      style="{{ $booking->payment->status === 'paid'
                          ? 'background:#f0fdf4;color:#16a34a;'
                          : ($booking->payment->status === 'refunded'
                              ? 'background:#fdf4ff;color:#9333ea;'
                              : 'background:#fef9c3;color:#ca8a04;') }}">
                    {{ ucfirst($booking->payment->status) }}
                </span>
            </div>
            <div class="detail-card-body" style="padding:16px 22px;">
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12.5px;color:#94a3b8;">Amount</span>
                        <span style="font-size:14px;font-weight:700;color:#0f172a;">
                            ${{ number_format($booking->payment->amount, 2) }}
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-top:10px;border-top:1px solid #f1f5f9;">
                        <span style="font-size:12.5px;color:#94a3b8;">Method</span>
                        <span style="font-size:13px;font-weight:600;color:#334155;">
                            {{ ucfirst($booking->payment_method) }}
                        </span>
                    </div>
                    @if($booking->payment->stripe_payment_intent)
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-top:10px;border-top:1px solid #f1f5f9;">
                        <span style="font-size:12.5px;color:#94a3b8;">Transaction</span>
                        <span style="font-family:'DM Mono',monospace;font-size:10px;
                                     color:#64748b;max-width:120px;overflow:hidden;
                                     text-overflow:ellipsis;white-space:nowrap;"
                              title="{{ $booking->payment->stripe_payment_intent }}">
                            {{ $booking->payment->stripe_payment_intent }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
        {{-- Insurance Details --}}
        @if($booking->payment_method === 'insurance' && $booking->insurance_provider)
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#f0fdf4;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="#16a34a" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Insurance Details</span>
                </div>
                <span style="background:#f0fdf4;color:#16a34a;font-size:11px;font-weight:700;
                            padding:3px 9px;border-radius:999px;border:1px solid #bbf7d0;">
                    Active
                </span>
            </div>
            <div class="detail-card-body" style="padding:16px 22px;">
                <div style="display:flex;flex-direction:column;gap:10px;">

                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12.5px;color:#94a3b8;">Provider</span>
                        <span style="font-size:13px;font-weight:700;color:#0f172a;">
                            {{ $booking->insurance_provider }}
                        </span>
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-top:10px;border-top:1px solid #f1f5f9;">
                        <span style="font-size:12.5px;color:#94a3b8;">Member ID</span>
                        <span style="font-family:'DM Mono',monospace;font-size:12px;
                                    font-weight:600;color:#334155;">
                            {{ $booking->insurance_member_id }}
                        </span>
                    </div>

                    @if($booking->insurance_group_number)
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-top:10px;border-top:1px solid #f1f5f9;">
                        <span style="font-size:12.5px;color:#94a3b8;">Group No.</span>
                        <span style="font-family:'DM Mono',monospace;font-size:12px;
                                    font-weight:600;color:#334155;">
                            {{ $booking->insurance_group_number }}
                        </span>
                    </div>
                    @endif

                    <div style="display:flex;align-items:flex-start;gap:8px;margin-top:4px;
                                background:#f0fdf4;border-radius:8px;padding:10px 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                            style="flex-shrink:0;margin-top:1px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <p style="font-size:12px;color:#166534;line-height:1.5;margin:0;">
                            Coverage will be verified before the trip. Our team will contact you if additional information is needed.
                        </p>
                    </div>

                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection