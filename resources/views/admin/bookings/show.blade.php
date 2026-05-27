@extends('layouts.app')
@section('title', 'Booking Details')
@section('content')

<style>
    /* ── Back link ───────────────────────────── */
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

    /* ── Layout grid ─────────────────────────── */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }
    .detail-main { display: flex; flex-direction: column; gap: 16px; min-width: 0; }
    .detail-aside { display: flex; flex-direction: column; gap: 16px; }

    /* ── Shared card ─────────────────────────── */
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
    .detail-card-header-left {
        display: flex; align-items: center; gap: 10px;
    }
    .detail-card-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .detail-card-title { font-size: 13.5px; font-weight: 700; color: #0f172a; }
    .detail-card-body { padding: 22px; }

    /* ── Info grid ───────────────────────────── */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .info-label {
        font-size: 11.5px; font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 5px;
    }
    .info-value { font-size: 14px; font-weight: 600; color: #1e293b; line-height: 1.4; }

    /* ── Hero ────────────────────────────────── */
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
        margin-bottom: 0;
    }
    .booking-hero-number {
        font-family: 'DM Mono', monospace; font-size: 13px;
        font-weight: 500; color: rgba(255,255,255,0.5); margin-bottom: 4px;
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

    /* ── Route visual ────────────────────────── */
    .route-visual { display: flex; flex-direction: column; gap: 0; }
    .route-point { display: flex; align-items: flex-start; gap: 12px; }
    .route-dot-wrap {
        display: flex; flex-direction: column; align-items: center;
        flex-shrink: 0; padding-top: 2px;
    }
    .route-dot { width: 10px; height: 10px; border-radius: 50%; border: 2px solid; flex-shrink: 0; }
    .route-dot.pickup { border-color: #2563eb; background: #eff6ff; }
    .route-dot.dropoff { border-color: #16a34a; background: #f0fdf4; }
    .route-line {
        width: 2px; height: 28px;
        background: repeating-linear-gradient(to bottom,#e2e8f0 0px,#e2e8f0 4px,transparent 4px,transparent 8px);
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

    /* ── Form controls ───────────────────────── */
    .panel-select {
        flex: 1; border: 1.5px solid #e2e8f0; border-radius: 9px;
        padding: 9px 34px 9px 12px; font-size: 13px; font-weight: 500;
        color: #334155; background: #fff; appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center;
        outline: none; transition: border-color 0.13s, box-shadow 0.13s;
        font-family: 'DM Sans', sans-serif; min-width: 0;
    }
    .panel-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .panel-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: 9px; font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; transition: all 0.13s;
        font-family: 'DM Sans', sans-serif; white-space: nowrap; flex-shrink: 0;
    }
    .panel-btn-blue { background: #2563eb; color: #fff; box-shadow: 0 1px 3px rgba(37,99,235,0.25); }
    .panel-btn-blue:hover { background: #1d4ed8; transform: translateY(-1px); }
    .panel-btn-green { background: #16a34a; color: #fff; box-shadow: 0 1px 3px rgba(22,163,74,0.25); }
    .panel-btn-green:hover { background: #15803d; transform: translateY(-1px); }

    /* ── Edit card ───────────────────────────── */
    .edit-card {
        background: #fff;
        border-radius: 14px;
        border: 1.5px solid #2563eb;
        overflow: hidden;
        display: none;
    }
    .edit-card.open { display: block; }
    .edit-card-header {
        padding: 14px 20px;
        background: #eff6ff;
        border-bottom: 1px solid #bfdbfe;
        display: flex; align-items: center; justify-content: space-between;
    }
    .edit-card-title {
        font-size: 13px; font-weight: 700; color: #1e40af;
        display: flex; align-items: center; gap: 8px;
    }
    .edit-card-body { padding: 22px; }

    .edit-field { margin-bottom: 18px; }
    .edit-field:last-child { margin-bottom: 0; }
    .edit-field label {
        display: block; font-size: 11.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.06em;
        color: #64748b; margin-bottom: 6px;
    }
    .edit-input {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #e2e8f0; border-radius: 9px;
        font-size: 13.5px; font-weight: 500; color: #1e293b;
        background: #f8fafc; outline: none;
        transition: border-color 0.13s, box-shadow 0.13s, background 0.13s;
        font-family: 'DM Sans', sans-serif;
    }
    .edit-input:focus {
        border-color: #3b82f6; background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .edit-input-select {
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center;
        padding-right: 36px; cursor: pointer;
    }
    .edit-input-textarea { resize: vertical; min-height: 80px; line-height: 1.55; }

    .edit-field-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
    }

    .edit-actions {
        display: flex; gap: 10px; align-items: center;
        padding-top: 18px; border-top: 1px solid #f1f5f9; margin-top: 20px;
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 20px; border-radius: 9px; font-size: 13px; font-weight: 600;
        background: #2563eb; color: #fff; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; transition: all 0.13s;
        box-shadow: 0 1px 3px rgba(37,99,235,0.25);
    }
    .btn-save:hover { background: #1d4ed8; transform: translateY(-1px); }
    .btn-cancel-edit {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 16px; border-radius: 9px; font-size: 13px; font-weight: 600;
        background: #f1f5f9; color: #64748b; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; transition: all 0.13s;
    }
    .btn-cancel-edit:hover { background: #e2e8f0; color: #334155; }

    /* Edit trigger button */
    .btn-edit-trigger {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600;
        background: #f8fafc; color: #475569;
        border: 1.5px solid #e2e8f0; cursor: pointer;
        font-family: 'DM Sans', sans-serif; transition: all 0.13s;
    }
    .btn-edit-trigger:hover { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
    .btn-edit-trigger.active { background: #eff6ff; color: #2563eb; border-color: #2563eb; }

    /* ── Timeline ────────────────────────────── */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-item { display: flex; gap: 12px; position: relative; padding-bottom: 18px; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-left {
        display: flex; flex-direction: column; align-items: center;
        flex-shrink: 0; width: 28px;
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
    .timeline-meta { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }
    .timeline-notes {
        font-size: 12.5px; color: #64748b; margin-top: 4px;
        background: #f8fafc; border-radius: 6px; padding: 6px 10px;
        border-left: 2px solid #e2e8f0;
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 960px) {
        .detail-grid { grid-template-columns: 1fr; }
        .detail-aside { order: 2; }
    }
    @media (max-width: 640px) {
        .booking-hero { flex-direction: column; align-items: flex-start; gap: 16px; }
        .booking-hero-price { text-align: left; }
        .info-grid { grid-template-columns: 1fr; gap: 14px; }
        .detail-card-body { padding: 16px; }
        .edit-field-row { grid-template-columns: 1fr; }
    }
</style>

{{-- Back link --}}
<a href="{{ route('admin.bookings.index') }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 5l-7 7 7 7"/>
    </svg>
    Back to Bookings
</a>

{{-- ── BOOKING HERO ─────────────────────────────── --}}
<div class="booking-hero" style="margin-bottom:20px;">
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
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                {{ $booking->scheduled_at->format('M d, Y · H:i') }}
            </div>
            <div class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="rgba(255,255,255,0.5)" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M5.5 21a7 7 0 0 1 13 0"/>
                </svg>
                {{ $booking->client->name }}
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

{{-- ── TWO-COLUMN LAYOUT ───────────────────────── --}}
<div class="detail-grid">

    {{-- ── MAIN COLUMN ──────────────────────── --}}
    <div class="detail-main">

        {{-- Trip details --}}
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
                {{-- Edit trigger --}}
                <button type="button" class="btn-edit-trigger" id="editTripBtn"
                    onclick="toggleEdit('editTripForm', 'editTripBtn')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit
                </button>
            </div>
            <div class="detail-card-body">

                {{-- Route visual --}}
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
                        <div class="info-item">
                            <div class="info-label">Client</div>
                            <div class="info-value">{{ $booking->client->name }}</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                                {{ $booking->client->email }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Patient Name</div>
                            <div class="info-value">{{ $booking->patient_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Service Type</div>
                            <div class="info-value">{{ $booking->serviceType->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Payment Method</div>
                            <div class="info-value">{{ ucfirst($booking->payment_method) }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Scheduled</div>
                            <div class="info-value">{{ $booking->scheduled_at->format('M d, Y') }}</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                                {{ $booking->scheduled_at->format('H:i') }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Assigned Driver</div>
                            @if($booking->driver)
                                <div style="display:flex; align-items:center; gap:7px; margin-top:2px;">
                                    <div style="width:26px; height:26px; border-radius:7px; flex-shrink:0;
                                        background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:10px; font-weight:700; color:#fff;">
                                        {{ strtoupper(substr($booking->driver->name, 0, 1)) }}
                                    </div>
                                    <span class="info-value">{{ $booking->driver->name }}</span>
                                </div>
                            @else
                                <span style="font-size:13px; color:#94a3b8;">Not yet assigned</span>
                            @endif
                        </div>
                        @if($booking->notes)
                        <div class="info-item" style="grid-column: span 2;">
                            <div class="info-label">Notes</div>
                            <div style="font-size:13.5px; color:#475569; background:#f8fafc;
                                border-radius:8px; padding:10px 14px; margin-top:4px;
                                border-left:3px solid #e2e8f0; line-height:1.55;">
                                {{ $booking->notes }}
                            </div>
                        </div>
                        @endif
                        @if($booking->stripe_payment_url)
                        <div class="info-item" style="grid-column: span 2;">
                            <div class="info-label">Stripe Payment</div>
                            <div style="display:flex; align-items:center; gap:10px; margin-top:6px;
                                background:#f8fafc; border:1px solid #e2e8f0;
                                border-radius:9px; padding:10px 14px;">
                                <button type="button"
                                    onclick="navigator.clipboard.writeText('{{ $booking->stripe_payment_url }}'); this.innerText='Copied!'; setTimeout(() => this.innerText='Copy Link', 2000)"
                                    style="font-size:12px; font-weight:600; color:#2563eb;
                                        background:#eff6ff; border:1px solid #bfdbfe;
                                        border-radius:7px; padding:5px 12px; cursor:pointer;">
                                    Copy Link
                                </button>
                                <a href="{{ $booking->stripe_payment_url }}" target="_blank"
                                    style="font-size:12px; font-weight:600; color:#fff;
                                        background:#2563eb; border-radius:7px;
                                        padding:5px 12px; text-decoration:none;">
                                    Open Checkout
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── EDIT TRIP FORM ──────────────────── --}}
        <div class="edit-card" id="editTripForm">
            <div class="edit-card-header">
                <span class="edit-card-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit Booking
                </span>
                <button type="button" class="btn-cancel-edit"
                    onclick="toggleEdit('editTripForm', 'editTripBtn')"
                    style="padding:5px 10px; font-size:12px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Close
                </button>
            </div>
            <div class="edit-card-body">
                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                    @csrf
                    @method('PUT')

                    <div class="edit-field-row">
                        <div class="edit-field">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" class="edit-input"
                                value="{{ old('patient_name', $booking->patient_name) }}" required>
                        </div>
                        <div class="edit-field">
                            <label>Service Type</label>
                            <select name="service_type_id" class="edit-input edit-input-select" required>
                                @foreach($serviceTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $booking->service_type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="edit-field">
                        <label>Pickup Address</label>
                        <input type="text" name="pickup_address" class="edit-input"
                            value="{{ old('pickup_address', $booking->pickup_address) }}" required>
                    </div>

                    <div class="edit-field">
                        <label>Dropoff Address</label>
                        <input type="text" name="dropoff_address" class="edit-input"
                            value="{{ old('dropoff_address', $booking->dropoff_address) }}" required>
                    </div>

                    <div class="edit-field-row">
                        <div class="edit-field">
                            <label>Scheduled Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" class="edit-input"
                                value="{{ old('scheduled_at', $booking->scheduled_at->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        <div class="edit-field">
                            <label>Distance (miles)</label>
                            <input type="number" name="distance_miles" class="edit-input"
                                step="0.01" min="0"
                                value="{{ old('distance_miles', $booking->distance_miles) }}" required>
                        </div>
                    </div>

                    <div class="edit-field-row">
                        <div class="edit-field">
                            <label>Payment Method</label>
                            <select name="payment_method" class="edit-input edit-input-select">
                                @foreach(['online' => 'Online (Stripe)', 'cash' => 'Cash', 'check' => 'Check', 'manual' => 'Manual', 'insurance' => 'Insurance'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ $booking->payment_method == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="edit-field">
                            <label>Final Price ($)</label>
                            <input type="number" name="final_price" class="edit-input"
                                step="0.01" min="0"
                                value="{{ old('final_price', $booking->final_price) }}" required>
                        </div>
                    </div>
                    {{-- Insurance fields (shown/hidden via JS) --}}
                    <div id="editInsuranceFields"
                        style="{{ $booking->payment_method === 'insurance' ? '' : 'display:none;' }}">
                        <div class="edit-field-row">
                            <div class="edit-field">
                                <label>Insurance Provider</label>
                                <input type="text" name="insurance_provider" class="edit-input"
                                    placeholder="e.g. Medicaid, Medicare"
                                    value="{{ old('insurance_provider', $booking->insurance_provider) }}">
                            </div>
                            <div class="edit-field">
                                <label>Member / Policy ID</label>
                                <input type="text" name="insurance_member_id" class="edit-input"
                                    placeholder="e.g. 123456789A"
                                    value="{{ old('insurance_member_id', $booking->insurance_member_id) }}">
                            </div>
                        </div>
                        <div class="edit-field">
                            <label>Group Number <span style="font-weight:400; color:#94a3b8;">(optional)</span></label>
                            <input type="text" name="insurance_group_number" class="edit-input"
                                placeholder="e.g. GRP-00123"
                                value="{{ old('insurance_group_number', $booking->insurance_group_number) }}">
                        </div>
                    </div>
                    <div class="edit-field">
                        <label>Notes</label>
                        <textarea name="notes" class="edit-input edit-input-textarea"
                            placeholder="Additional notes...">{{ old('notes', $booking->notes) }}</textarea>
                    </div>

                    <div class="edit-actions">
                        <button type="submit" class="btn-save">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Save Changes
                        </button>
                        <button type="button" class="btn-cancel-edit"
                            onclick="toggleEdit('editTripForm', 'editTripBtn')">
                            Cancel
                        </button>
                        <span style="font-size:12px; color:#94a3b8; margin-left:auto;">
                            Changes are saved immediately.
                        </span>
                    </div>
                </form>
            </div>
        </div>

        {{-- Assign Driver --}}
        @if(in_array($booking->status, ['approved', 'pending']))
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#eff6ff;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="#2563eb" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M5.5 21a7 7 0 0 1 13 0"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Assign Driver</span>
                </div>
            </div>
            <div class="detail-card-body">
                @if($drivers->isEmpty())
                <div style="display:flex; align-items:center; gap:10px; background:#fefce8;
                    border:1px solid #fde68a; border-radius:10px; padding:12px 16px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#d97706" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span style="font-size:13px; color:#92400e; font-weight:500;">
                        No approved, available drivers at this time.
                    </span>
                </div>
                @else
                <form method="POST"
                    action="{{ route('admin.bookings.assign-driver', $booking) }}"
                    style="display:flex; gap:10px;">
                    @csrf
                    <select name="driver_id" class="panel-select" required>
                        <option value="">Select a driver...</option>
                        @foreach($drivers as $d)
                            <option value="{{ $d->id }}"
                                {{ $booking->driver_id == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="panel-btn panel-btn-blue">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Assign
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif

        {{-- Update Status --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#f0fdf4;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="#16a34a" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="17 1 21 5 17 9"/>
                            <path d="M3 11V9a4 4 0 0 1 4-4h14"/>
                            <polyline points="7 23 3 19 7 15"/>
                            <path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Update Status</span>
                </div>
                <span class="badge {{ $booking->getStatusBadgeClass() }}">
                    Current: {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>
            <div class="detail-card-body">
                <form method="POST"
                    action="{{ route('admin.bookings.update-status', $booking) }}"
                    style="display:flex; gap:10px;">
                    @csrf
                    <select name="status" class="panel-select">
                        @foreach([
                            'pending'    => 'Pending',
                            'approved'   => 'Approved',
                            'assigned'   => 'Assigned',
                            'in_transit' => 'In Transit',
                            'completed'  => 'Completed',
                            'cancelled'  => 'Cancelled',
                        ] as $val => $label)
                            <option value="{{ $val }}"
                                {{ $booking->status == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="panel-btn panel-btn-green">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Update
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- ── ASIDE COLUMN ──────────────────────── --}}
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
                            <line x1="6" y1="20" x2="6" y2="16"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Status History</span>
                </div>
                <span style="font-size:11.5px; font-weight:600; color:#94a3b8;">
                    {{ $booking->statusLogs->count() }} update{{ $booking->statusLogs->count() != 1 ? 's' : '' }}
                </span>
            </div>
            <div class="detail-card-body" style="padding:20px 22px;">
                @if($booking->statusLogs->isEmpty())
                    <p style="font-size:13px; color:#94a3b8; text-align:center; padding:12px 0;">
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
                        <div style="flex:1; min-width:0; padding-bottom:2px;">
                            <div class="timeline-status">
                                {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                            </div>
                            <div class="timeline-meta">
                                {{ $log->created_at->format('M d, Y · H:i') }}
                                · {{ $log->user?->name ?? 'System' }}
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

        {{-- Payment summary --}}
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
                {{-- Live status badge --}}
                @php
                    $pStatus = $booking->payment->status;
                    $pStyle  = match($pStatus) {
                        'paid'      => 'background:#f0fdf4; color:#16a34a;',
                        'refunded'  => 'background:#fdf4ff; color:#9333ea;',
                        'failed'    => 'background:#fef2f2; color:#dc2626;',
                        'cancelled' => 'background:#f1f5f9; color:#64748b;',
                        default     => 'background:#fffbeb; color:#d97706;',
                    };
                @endphp
                <span class="badge" style="{{ $pStyle }}">{{ ucfirst($pStatus) }}</span>
            </div>
            <div class="detail-card-body" style="padding:16px 22px;">
                <div style="display:flex; flex-direction:column; gap:12px;">

                    {{-- Amount row --}}
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:12.5px; color:#94a3b8;">Amount</span>
                        <span style="font-size:15px; font-weight:700; color:#0f172a;">
                            ${{ number_format($booking->payment->amount, 2) }}
                        </span>
                    </div>

                    {{-- Transaction ID --}}
                    @if($booking->payment->stripe_payment_intent)
                    <div style="display:flex; justify-content:space-between; align-items:center;
                        padding-top:10px; border-top:1px solid #f1f5f9;">
                        <span style="font-size:12.5px; color:#94a3b8;">Transaction</span>
                        <span style="font-family:'DM Mono',monospace; font-size:10px;
                            color:#64748b; max-width:120px; overflow:hidden;
                            text-overflow:ellipsis; white-space:nowrap;"
                            title="{{ $booking->payment->stripe_payment_intent }}">
                            {{ $booking->payment->stripe_payment_intent }}
                        </span>
                    </div>
                    @endif

                    {{-- Stripe session --}}
                    @if($booking->payment->stripe_session_id)
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:12.5px; color:#94a3b8;">Session</span>
                        <span style="font-family:'DM Mono',monospace; font-size:10px;
                            color:#64748b; max-width:120px; overflow:hidden;
                            text-overflow:ellipsis; white-space:nowrap;"
                            title="{{ $booking->payment->stripe_session_id }}">
                            {{ $booking->payment->stripe_session_id }}
                        </span>
                    </div>
                    @endif

                    {{-- Update payment status form --}}
                    <div style="padding-top:12px; border-top:1px solid #f1f5f9;">
                        <div style="font-size:11.5px; font-weight:700; text-transform:uppercase;
                            letter-spacing:0.06em; color:#94a3b8; margin-bottom:8px;">
                            Update Payment Status
                        </div>
                        <form method="POST"
                            action="{{ route('admin.bookings.update-payment-status', $booking) }}"
                            style="display:flex; gap:8px;">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="panel-select" style="font-size:12.5px;">
                                @foreach([
                                    'pending'   => 'Pending',
                                    'paid'      => 'Paid',
                                    'failed'    => 'Failed',
                                    'refunded'  => 'Refunded',
                                    'cancelled' => 'Cancelled',
                                ] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ $booking->payment->status === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="panel-btn panel-btn-blue"
                                style="font-size:12.5px; padding:8px 14px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Save
                            </button>
                        </form>
                    </div>

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

        {{-- Danger zone --}}
        <div class="detail-card" style="border-color:#fee2e2;">
            <div class="detail-card-header" style="background:#fff5f5; border-bottom-color:#fee2e2;">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#fef2f2;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="#dc2626" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <span class="detail-card-title" style="color:#dc2626;">Danger Zone</span>
                </div>
            </div>
            <div class="detail-card-body" style="padding:16px 22px;">
                <p style="font-size:12.5px; color:#94a3b8; margin-bottom:14px; line-height:1.55;">
                    Permanently delete this booking. This action cannot be undone.
                </p>
                <form method="POST"
                    action="{{ route('admin.bookings.destroy', $booking) }}"
                    onsubmit="return confirm('Delete booking {{ $booking->booking_number }}? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px;
                            padding:9px 16px; border-radius:9px; font-size:13px;
                            font-weight:600; background:#fef2f2; color:#dc2626;
                            border:1.5px solid #fecaca; cursor:pointer;
                            font-family:'DM Sans',sans-serif; transition:all 0.13s;
                            width:100%; justify-content:center;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                        </svg>
                        Delete Booking
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
function toggleEdit(formId, btnId) {
    const form = document.getElementById(formId);
    const btn  = document.getElementById(btnId);
    const isOpen = form.classList.contains('open');

    form.classList.toggle('open');
    btn.classList.toggle('active', !isOpen);

    if (!isOpen) {
        // Smooth scroll to edit form
        setTimeout(() => {
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 50);
    }
}

// Re-open edit form if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editTripForm');
        const btn  = document.getElementById('editTripBtn');
        form.classList.add('open');
        btn.classList.add('active');
    });
@endif
document.addEventListener('DOMContentLoaded', function () {
    const paySelect = document.querySelector('select[name="payment_method"]');
    const insFields = document.getElementById('editInsuranceFields');

    if (paySelect && insFields) {
        paySelect.addEventListener('change', function () {
            insFields.style.display = this.value === 'insurance' ? 'block' : 'none';
        });
    }
});
</script>

@endsection