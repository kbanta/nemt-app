@extends('layouts.app')
@section('title', 'Driver Dashboard')
@section('content')

@php $driverProfile = auth()->user()->driver; @endphp

<style>
    /* ── Hero card ───────────────────────────── */
    .hero-card {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #059669 100%);
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
    .hero-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .hero-toggle {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.3);
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        backdrop-filter: blur(4px);
        font-family: 'DM Sans', sans-serif;
        transition: all 0.13s;
        white-space: nowrap;
    }
    .hero-toggle:hover {
        background: rgba(255,255,255,0.25);
    }

    /* ── Status badge ────────────────────────── */
    .status-online {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }
    .status-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
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

    /* ── Active trip banner ──────────────────── */
    .active-banner {
        background: linear-gradient(135deg, #7c2d12, #ea580c);
        border-radius: 16px;
        padding: 22px 24px;
        margin-bottom: 20px;
        color: #fff;
    }
    .active-banner-label {
        font-size: 11px;
        font-weight: 700;
        opacity: 0.65;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 12px;
    }
    .active-trip-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }
    .active-manage-btn {
        background: #fff;
        color: #ea580c;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.13s;
    }
    .active-manage-btn:hover {
        background: #fff7ed;
    }

    /* ── Trips card ──────────────────────────── */
    .trips-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .trips-header {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .trips-header-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: #f0fdf4;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Trip item ───────────────────────────── */
    .trip-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.12s;
    }
    .trip-item:last-child { border-bottom: none; }
    .trip-item:hover { background: #f8fafc; }

    /* ── Desktop / mobile toggle ─────────────── */
    .desktop-table { display: block; overflow-x: auto; }
    .mobile-list   { display: none; }

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
        .hero-card  { padding: 22px 20px; }
        .hero-inner { flex-direction: column; align-items: flex-start; gap: 0; }
        .hero-name  { font-size: 19px; }
        .hero-actions { width: 100%; }
        .hero-toggle  { flex: 1; justify-content: center; }

        .stats-row  { grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .stat-item  { padding: 14px 10px; gap: 8px; flex-direction: column; align-items: flex-start; }
        .stat-icon-wrap { width: 36px; height: 36px; border-radius: 9px; }
        .stat-value { font-size: 22px; }
        .stat-label { font-size: 11px; }

        .active-trip-row { flex-direction: column; align-items: flex-start; gap: 12px; }
        .active-manage-btn { width: 100%; text-align: center; }

        .trips-header { padding: 14px 16px; }
        .desktop-table { display: none; }
        .mobile-list   { display: block; }
    }

    @media (max-width: 480px) {
        .stats-row  { gap: 8px; }
        .stat-item  { padding: 12px 8px; }
        .stat-value { font-size: 20px; }
    }
</style>

{{-- ── HERO ─────────────────────────────────────── --}}
<div class="hero-card">
    <div class="hero-inner">
        <div style="flex:1;">
            <p class="hero-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}
            </p>
            <h2 class="hero-name">{{ auth()->user()->name }}</h2>
            <p class="hero-sub">Drive safely and complete your trips on time.</p>

            <div class="hero-actions">
                {{-- Availability toggle --}}
                <form method="POST" action="{{ route('driver.toggle-availability') }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="hero-toggle" style="width:100%;">
                        @if($driverProfile?->is_available)
                            <span class="status-dot" style="background:#4ade80;"></span>
                            Go Offline
                        @else
                            <span class="status-dot" style="background:#f87171;"></span>
                            Go Online
                        @endif
                    </button>
                </form>

                {{-- Current status chip --}}
                <div class="status-online">
                    <span class="status-dot"
                          style="background:{{ $driverProfile?->is_available ? '#4ade80' : '#f87171' }};
                                 box-shadow: 0 0 0 2px {{ $driverProfile?->is_available ? 'rgba(74,222,128,0.3)' : 'rgba(248,113,113,0.3)' }};">
                    </span>
                    {{ $driverProfile?->is_available ? 'Online' : 'Offline' }}
                </div>
            </div>
        </div>

        {{-- Decorative icon --}}
        <div style="flex-shrink:0; opacity:0.1;">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white"
                 stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="3" width="15" height="13" rx="2"/>
                <path d="M16 8h4l3 5v3h-7V8z"/>
                <circle cx="5.5" cy="18.5" r="2.5"/>
                <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ───────────────────────────────── --}}
<div class="stats-row">

    <div class="stat-item">
        <div class="stat-icon-wrap" style="background:#eff6ff;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 11l3 3L22 4"/>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#2563eb;">{{ $assignedTrips->count() }}</div>
            <div class="stat-label">Assigned</div>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon-wrap" style="background:#fff7ed;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ea580c"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="3 11 22 2 13 21 11 13 3 11"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#ea580c;">{{ $inTransitTrips->count() }}</div>
            <div class="stat-label">In Transit</div>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon-wrap" style="background:#f0fdf4;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#16a34a;">{{ $completedTrips }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

</div>

{{-- ── ACTIVE / IN TRANSIT TRIPS ───────────────── --}}
@if($inTransitTrips->count() > 0)
<div class="active-banner">
    <p class="active-banner-label">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
             style="display:inline; margin-right:4px; vertical-align:middle;">
            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
        </svg>
        Active Trip{{ $inTransitTrips->count() > 1 ? 's' : '' }}
    </p>
    @foreach($inTransitTrips as $trip)
    <div class="active-trip-row" style="{{ !$loop->first ? 'margin-top:16px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.15);' : '' }}">
        <div style="flex:1; min-width:0;">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px; flex-wrap:wrap;">
                <span style="font-family:'DM Mono',monospace; font-weight:700; font-size:13px;">
                    {{ $trip->booking_number }}
                </span>
                <span style="font-size:11px; font-weight:600; background:rgba(255,255,255,0.15);
                              border-radius:6px; padding:2px 8px; opacity:0.85;">
                    {{ $trip->serviceType->name }}
                </span>
            </div>
            <div style="display:flex; align-items:flex-start; gap:6px; margin-bottom:4px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="flex-shrink:0; margin-top:2px;">
                    <circle cx="12" cy="10" r="3"/>
                    <path d="M12 2a8 8 0 0 1 8 8c0 5.25-8 13-8 13S4 15.25 4 10a8 8 0 0 1 8-8z"/>
                </svg>
                <span style="font-size:13px; opacity:0.85; line-height:1.4;">{{ $trip->pickup_address }}</span>
            </div>
            <div style="display:flex; align-items:flex-start; gap:6px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="flex-shrink:0; margin-top:2px;">
                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span style="font-size:12px; opacity:0.6; line-height:1.4;">{{ $trip->dropoff_address }}</span>
            </div>
        </div>
        <a href="{{ route('driver.trips.show', $trip) }}" class="active-manage-btn">
            Manage →
        </a>
    </div>
    @endforeach
</div>
@endif

{{-- ── ASSIGNED TRIPS ───────────────────────────── --}}
<div class="trips-card">

    <div class="trips-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="trips-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <path d="M16 8h4l3 5v3h-7V8z"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <div>
                <p style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.2;">Assigned Trips</p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $assignedTrips->count() }} trip{{ $assignedTrips->count() != 1 ? 's' : '' }} waiting
                </p>
            </div>
        </div>
    </div>

    @if($assignedTrips->isEmpty())

        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <path d="M16 8h4l3 5v3h-7V8z"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <p style="font-size:15px; font-weight:600; color:#475569;">No assigned trips</p>
            <p style="font-size:13px; color:#94a3b8; margin-top:4px;">
                Make sure you're set to Online to receive trips.
            </p>
        </div>

    @else

        {{-- ── DESKTOP TABLE ─────────────────────────── --}}
        <div class="desktop-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Pickup</th>
                        <th>Scheduled</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedTrips as $trip)
                    <tr>
                        <td>
                            <span style="font-family:'DM Mono',monospace; font-size:11px;
                                         color:#64748b; font-weight:600;">
                                {{ $trip->booking_number }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:7px;">
                                <div style="width:26px; height:26px; border-radius:7px; flex-shrink:0;
                                            background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:10px; font-weight:700; color:#fff;">
                                    {{ strtoupper(substr($trip->client->name, 0, 1)) }}
                                </div>
                                <span style="font-size:13px; font-weight:600; color:#1e293b;">
                                    {{ $trip->client->name }}
                                </span>
                            </div>
                        </td>
                        <td style="font-size:13px; color:#64748b; white-space:nowrap;">
                            {{ $trip->serviceType->name }}
                        </td>
                        <td>
                            <span style="font-size:13px; color:#334155; display:block;
                                         max-width:180px; white-space:nowrap; overflow:hidden;
                                         text-overflow:ellipsis;"
                                  title="{{ $trip->pickup_address }}">
                                {{ $trip->pickup_address }}
                            </span>
                        </td>
                        <td style="white-space:nowrap;">
                            <span style="font-size:13px; color:#334155; font-weight:500;">
                                {{ $trip->scheduled_at->format('M d, Y') }}
                            </span>
                            <span style="display:block; font-size:11.5px; color:#94a3b8; margin-top:1px;">
                                {{ $trip->scheduled_at->format('H:i') }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('driver.trips.show', $trip) }}"
                               style="display:inline-flex; align-items:center; gap:5px;
                                      font-size:12px; font-weight:600; color:#16a34a;
                                      background:#f0fdf4; border-radius:7px; padding:5px 10px;
                                      text-decoration:none; transition:background 0.12s;"
                               onmouseover="this.style.background='#dcfce7'"
                               onmouseout="this.style.background='#f0fdf4'">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── MOBILE LIST ────────────────────────── --}}
        <div class="mobile-list">
            @foreach($assignedTrips as $trip)
            <div style="padding:16px 18px;
                        border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

                {{-- Row 1: booking # + date --}}
                <div style="display:flex; justify-content:space-between; align-items:flex-start;
                             gap:10px; margin-bottom:8px;">
                    <span style="font-family:'DM Mono',monospace; font-size:11px;
                                 color:#64748b; font-weight:600;">
                        {{ $trip->booking_number }}
                    </span>
                    <span style="font-size:12px; color:#94a3b8; white-space:nowrap;">
                        {{ $trip->scheduled_at->format('M d · H:i') }}
                    </span>
                </div>

                {{-- Row 2: client --}}
                <div style="display:flex; align-items:center; gap:7px; margin-bottom:6px;">
                    <div style="width:24px; height:24px; border-radius:6px; flex-shrink:0;
                                background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                display:flex; align-items:center; justify-content:center;
                                font-size:10px; font-weight:700; color:#fff;">
                        {{ strtoupper(substr($trip->client->name, 0, 1)) }}
                    </div>
                    <span style="font-size:13px; font-weight:600; color:#1e293b;">
                        {{ $trip->client->name }}
                    </span>
                    <span style="font-size:12px; color:#94a3b8;">· {{ $trip->serviceType->name }}</span>
                </div>

                {{-- Row 3: route --}}
                <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; margin-bottom:12px;">
                    <div style="display:flex; align-items:flex-start; gap:6px; margin-bottom:5px;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                             style="flex-shrink:0; margin-top:2px;">
                            <circle cx="12" cy="10" r="3"/>
                            <path d="M12 2a8 8 0 0 1 8 8c0 5.25-8 13-8 13S4 15.25 4 10a8 8 0 0 1 8-8z"/>
                        </svg>
                        <span style="font-size:12px; color:#334155; line-height:1.4;">
                            {{ $trip->pickup_address }}
                        </span>
                    </div>
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                             style="flex-shrink:0; margin-top:2px;">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span style="font-size:12px; color:#64748b; line-height:1.4;">
                            {{ $trip->dropoff_address }}
                        </span>
                    </div>
                </div>

                {{-- View button --}}
                <a href="{{ route('driver.trips.show', $trip) }}"
                   style="display:flex; align-items:center; justify-content:center; gap:6px;
                          background:#f0fdf4; color:#16a34a; border-radius:8px;
                          padding:10px 12px; font-size:13px; font-weight:600;
                          text-decoration:none; transition:background 0.12s;"
                   onmouseover="this.style.background='#dcfce7'"
                   onmouseout="this.style.background='#f0fdf4'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    View Trip
                </a>

            </div>
            @endforeach
        </div>

    @endif

</div>

@endsection