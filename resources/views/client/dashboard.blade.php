@extends('layouts.app')
@section('title', 'My Dashboard')
@section('content')

<style>
    /* ── Hero card ───────────────────────────── */
    .hero-card {
        background: linear-gradient(135deg, #0b1a2e 0%, #1e3a5f 50%, #2563eb 100%);
        border-radius: 18px;
        padding: 32px;
        margin-bottom: 24px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .hero-card::after {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-card::before {
        content: '';
        position: absolute;
        bottom: -40px; right: 80px;
        width: 140px; height: 140px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: relative;
        z-index: 1;
    }
    .hero-greeting {
        font-size: 12.5px;
        font-weight: 500;
        color: rgba(255,255,255,0.55);
        letter-spacing: 0.01em;
    }
    .hero-name {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        margin-top: 4px;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .hero-sub {
        font-size: 13px;
        color: rgba(255,255,255,0.45);
        margin-top: 6px;
        line-height: 1.5;
    }
    .hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #1d4ed8;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        margin-top: 20px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
        transition: all 0.15s;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .hero-cta:hover {
        background: #eff6ff;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        transform: translateY(-1px);
    }

    /* ── Stat cards ──────────────────────────── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-item {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.07);
    }
    .stat-icon-wrap {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-value {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1;
    }
    .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 3px;
    }

    /* ── Bookings card ───────────────────────── */
    .bookings-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .bookings-header {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .bookings-header-left {
        display: flex; align-items: center; gap: 10px;
    }
    .bookings-header-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: #eff6ff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Desktop table ───────────────────────── */
    .desktop-table { display: block; }

    /* ── Mobile booking rows ─────────────────── */
    .booking-row-mobile { display: none; }

    /* ── Empty state ─────────────────────────── */
    .empty-state {
        padding: 52px 24px;
        text-align: center;
    }
    .empty-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 768px) {
        .hero-card { padding: 22px 20px; }
        .hero-inner { flex-direction: column; align-items: flex-start; gap: 0; }
        .hero-name { font-size: 19px; }
        .hero-cta { margin-top: 18px; width: 100%; justify-content: center; }

        .stats-row { grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .stat-item { padding: 14px 12px; gap: 10px; flex-direction: column; align-items: flex-start; }
        .stat-icon-wrap { width: 36px; height: 36px; border-radius: 9px; }
        .stat-value { font-size: 22px; }
        .stat-label { font-size: 11px; }

        .bookings-header { padding: 14px 16px; }

        /* Hide table on mobile, show card rows instead */
        .desktop-table { display: none; }
        .booking-row-mobile { display: block; }

        .mobile-booking-item {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .mobile-booking-item:last-child { border-bottom: none; }
    }

    @media (max-width: 480px) {
        .stats-row { grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .stat-item { padding: 12px 10px; }
        .stat-value { font-size: 20px; }
    }
</style>

{{-- ── HERO ─────────────────────────────────────── --}}
<div class="hero-card">
    <div class="hero-inner">
        <div>
            <p class="hero-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}
            </p>
            <h2 class="hero-name">{{ auth()->user()->name }}</h2>
            <p class="hero-sub">Manage your medical transportation bookings.</p>
            <a href="{{ route('client.bookings.create') }}" class="hero-cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Book a Ride
            </a>
        </div>

        {{-- Decorative pulse icon — hidden on small screens --}}
        <div style="flex-shrink:0; opacity:0.12;" class="hidden md:block">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12h4l3-9 4 18 3-9h4"/>
            </svg>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ───────────────────────────────── --}}
<div class="stats-row">

    <div class="stat-item">
        <div class="stat-icon-wrap" style="background:#eff6ff;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#1e293b;">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon-wrap" style="background:#fefce8;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#d97706;">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon-wrap" style="background:#f0fdf4;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#16a34a;">{{ $stats['completed'] }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

</div>

{{-- ── RECENT BOOKINGS ──────────────────────────── --}}
<div class="bookings-card">

    <div class="bookings-header">
        <div class="bookings-header-left">
            <div class="bookings-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div>
                <p style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.2;">Recent Bookings</p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">Your last {{ count($recentBookings) }} trip{{ count($recentBookings) != 1 ? 's' : '' }}</p>
            </div>
        </div>
        <a href="{{ route('client.bookings.index') }}" class="btn-ghost btn-sm" style="display:inline-flex; align-items:center; gap:6px; white-space:nowrap;">
            View all
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @if($recentBookings->isEmpty())

        {{-- ── EMPTY STATE ─────────────────────── --}}
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <p style="font-size:15px; font-weight:600; color:#475569;">No bookings yet</p>
            <p style="font-size:13px; color:#94a3b8; margin-top:4px; margin-bottom:20px;">
                Your trip history will appear here once you make a booking.
            </p>
            <a href="{{ route('client.bookings.create') }}" class="btn-primary" style="display:inline-flex;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Book your first ride
            </a>
        </div>

    @else

        {{-- ── DESKTOP TABLE (own loop) ────────────────────── --}}
        <div class="desktop-table" style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Service</th>
                        <th>Scheduled</th>
                        <th>Status</th>
                        <th>Paid</th>
                        <th style="text-align:right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $b)
                    <tr>
                        <td>
                            <a href="{{ route('client.bookings.show', $b) }}"
                               style="font-family:'DM Mono',monospace; font-size:11.5px; color:#2563eb; font-weight:500; text-decoration:none; white-space:nowrap;">
                                {{ $b->booking_number }}
                            </a>
                        </td>
                        <td style="font-weight:500; color:#1e293b; white-space:nowrap;">
                            {{ $b->serviceType->name }}
                        </td>
                        <td style="color:#64748b; font-size:13px; white-space:nowrap;">
                            {{ $b->scheduled_at->format('M d, Y') }}
                            <span style="color:#cbd5e1; margin:0 2px;">·</span>
                            {{ $b->scheduled_at->format('H:i') }}
                        </td>
                        <td>
                            <span class="badge {{ $b->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $b->status)) }}
                            </span>
                        </td>
                        <td>
                            @if($b->is_paid)
                                <span style="display:inline-flex; align-items:center; gap:4px; color:#16a34a; font-size:12.5px; font-weight:600;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Paid
                                </span>
                            @else
                                <span style="display:inline-flex; align-items:center; gap:4px; color:#94a3b8; font-size:12.5px; font-weight:500;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td style="font-weight:700; color:#0f172a; text-align:right;">
                            ${{ number_format($b->final_price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── MOBILE CARDS (own separate loop) ───────────── --}}
        <div class="booking-row-mobile">
            @foreach($recentBookings as $b)
            <div class="mobile-booking-item">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                            <a href="{{ route('client.bookings.show', $b) }}"
                               style="font-family:'DM Mono',monospace; font-size:11px; color:#2563eb; font-weight:600; text-decoration:none;">
                                {{ $b->booking_number }}
                            </a>
                            <span class="badge {{ $b->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $b->status)) }}
                            </span>
                        </div>
                        <p style="font-size:14px; font-weight:600; color:#1e293b; margin-top:5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $b->serviceType->name }}
                        </p>
                        <div style="display:flex; align-items:center; gap:5px; margin-top:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span style="font-size:12px; color:#64748b;">
                                {{ $b->scheduled_at->format('M d, Y · H:i') }}
                            </span>
                        </div>
                    </div>
                    <div style="text-align:right; flex-shrink:0;">
                        <p style="font-size:16px; font-weight:800; color:#0f172a; letter-spacing:-0.02em;">
                            ${{ number_format($b->final_price, 2) }}
                        </p>
                        @if($b->is_paid)
                            <span style="display:inline-flex; align-items:center; gap:3px; color:#16a34a; font-size:11.5px; font-weight:600; margin-top:4px;">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Paid
                            </span>
                        @else
                            <span style="font-size:11.5px; color:#94a3b8; font-weight:500; margin-top:4px; display:block;">
                                Unpaid
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    @endif

</div>

@endsection