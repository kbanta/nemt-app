@extends('layouts.app')
@section('title', $driver->user->name . ' — Driver Profile')
@section('content')

<style>
    /* ── Page header ─────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    /* ── Profile hero ────────────────────────── */
    .profile-hero {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        padding: 28px 28px 24px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .avatar-lg {
        width: 64px; height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #3b82f6, #6d28d9);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }

    .hero-body { flex: 1; min-width: 0; }

    .hero-name {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 6px;
    }

    .hero-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: #64748b;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    /* ── Stats row ───────────────────────────── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .mini-stat {
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.07);
        padding: 18px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mini-stat-icon {
        width: 40px; height: 40px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .mini-stat-value {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .mini-stat-label {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 3px;
    }

    /* ── Two-column grid ─────────────────────── */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 18px;
    }

    /* ── Info card ───────────────────────────── */
    .info-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }

    .info-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .info-card-icon {
        width: 28px; height: 28px;
        border-radius: 8px;
        background: #eff6ff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .info-card-title {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: 12.5px;
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
        text-align: right;
    }

    /* ── Avail dot ───────────────────────────── */
    .avail-dot {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        font-weight: 600;
    }
    .avail-dot::before {
        content: '';
        width: 7px; height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .avail-dot.available { color: #16a34a; }
    .avail-dot.available::before { background: #16a34a; }
    .avail-dot.unavailable { color: #94a3b8; }
    .avail-dot.unavailable::before { background: #cbd5e1; }

    /* ── Vehicle / document list ─────────────── */
    .list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
    }
    .list-item:last-child { border-bottom: none; }

    .list-icon-wrap {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .list-body { flex: 1; min-width: 0; }

    .list-name {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .list-sub {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* ── Empty mini ──────────────────────────── */
    .empty-mini {
        padding: 28px 20px;
        text-align: center;
    }

    /* ── Action buttons ──────────────────────── */
    .btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: #2563eb; color: #fff;
        padding: 8px 16px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        text-decoration: none; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.13s;
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(37,99,235,0.25);
    }
    .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: 6px;
        background: transparent; color: #64748b;
        padding: 8px 14px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        text-decoration: none; border: 1.5px solid #e2e8f0; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.13s;
        white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

    .btn-success {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0fdf4; color: #16a34a;
        padding: 8px 14px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.13s;
        white-space: nowrap;
    }
    .btn-success:hover { background: #dcfce7; }

    .btn-danger {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fef2f2; color: #dc2626;
        padding: 8px 14px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.13s;
        white-space: nowrap;
    }
    .btn-danger:hover { background: #fee2e2; }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .profile-hero { padding: 20px 18px; gap: 14px; }
        .hero-actions { width: 100%; }
        .hero-actions .btn-primary,
        .hero-actions .btn-ghost { flex: 1; justify-content: center; }
    }
    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr; }
        .mini-stat-value { font-size: 20px; }
    }
</style>

{{-- ── BACK LINK ────────────────────────────────── --}}
<div class="page-header">
    <div>
        <a href="{{ route('admin.drivers.index') }}"
           style="display:inline-flex; align-items:center; gap:6px;
                  font-size:13px; font-weight:600; color:#64748b;
                  text-decoration:none; margin-bottom:10px;"
           onmouseover="this.style.color='#2563eb'"
           onmouseout="this.style.color='#64748b'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Back to Drivers
        </a>
        <h2 style="font-size:20px; font-weight:800; color:#0f172a;
                   letter-spacing:-0.02em; line-height:1.2;">
            Driver Profile
        </h2>
        <p style="font-size:13px; color:#94a3b8; margin-top:3px;">
            Full details, vehicles and documents for {{ $driver->user->name }}
        </p>
    </div>
</div>

{{-- ── PROFILE HERO ─────────────────────────────── --}}
<div class="profile-hero">
    <div class="avatar-lg">
        {{ strtoupper(substr($driver->user->name, 0, 1)) }}
    </div>

    <div class="hero-body">
        <div class="hero-name">{{ $driver->user->name }}</div>

        {{-- Status badge + availability --}}
        <div style="display:flex; align-items:center; gap:8px; margin-top:4px; flex-wrap:wrap;">
            @php
                $statusClass = match($driver->status) {
                    'approved' => 'badge-success',
                    'pending'  => 'badge-warning',
                    default    => 'badge-danger',
                };
            @endphp
            <span class="badge {{ $statusClass }}">{{ ucfirst($driver->status) }}</span>
            <span class="avail-dot {{ $driver->is_available ? 'available' : 'unavailable' }}">
                {{ $driver->is_available ? 'Available' : 'Unavailable' }}
            </span>
        </div>

        <div class="hero-meta">
            {{-- Email --}}
            <span class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                {{ $driver->user->email }}
            </span>

            {{-- Phone --}}
            @if($driver->user->phone)
            <span class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07
                             A19.5 19.5 0 0 1 4.07 12a19.79 19.79 0 0 1-3.07-8.67
                             A2 2 0 0 1 3 1.18h3a2 2 0 0 1 2 1.72
                             c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.09
                             a16 16 0 0 0 6.29 6.29l1.07-1.07a2 2 0 0 1 2.11-.45
                             c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                {{ $driver->user->phone }}
            </span>
            @endif

            {{-- Joined --}}
            <span class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
                Joined {{ $driver->created_at->format('M d, Y') }}
            </span>
        </div>
    </div>

    {{-- Action buttons --}}
    <div class="hero-actions">
        <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn-primary">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit Driver
        </a>

        {{-- Toggle availability --}}
        <form method="POST" action="{{ route('admin.drivers.toggle-availability', $driver) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-ghost">
                @if($driver->is_available)
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                    </svg>
                    Set Unavailable
                @else
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Set Available
                @endif
            </button>
        </form>

        {{-- Approve / Reject if pending --}}
        @if($driver->status === 'pending')
            <form method="POST" action="{{ route('admin.drivers.approve', $driver) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-success">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Approve
                </button>
            </form>
            <form method="POST" action="{{ route('admin.drivers.reject', $driver) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-danger">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6"  y1="6" x2="18" y2="18"/>
                    </svg>
                    Reject
                </button>
            </form>
        @endif
    </div>
</div>

{{-- ── STATS ROW ────────────────────────────────── --}}
<div class="stats-row">

    <div class="mini-stat">
        <div class="mini-stat-icon" style="background:#f0fdf4;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div>
            <div class="mini-stat-value" style="color:#16a34a;">{{ $completedTrips }}</div>
            <div class="mini-stat-label">Completed Trips</div>
        </div>
    </div>

    <div class="mini-stat">
        <div class="mini-stat-icon"
             style="background:linear-gradient(135deg,#0b1a2e,#2563eb); opacity:1;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="rgba(255,255,255,0.9)" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
        <div>
            <div class="mini-stat-value"
                 style="background:linear-gradient(135deg,#1e3a5f,#2563eb);
                        -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                ${{ number_format($totalEarnings, 0) }}
            </div>
            <div class="mini-stat-label">Total Earnings</div>
        </div>
    </div>

    <div class="mini-stat">
        <div class="mini-stat-icon" style="background:#fefce8;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <div class="mini-stat-value" style="color:#d97706;">{{ $activeBookings }}</div>
            <div class="mini-stat-label">Active Bookings</div>
        </div>
    </div>

</div>

{{-- ── DETAIL GRID ──────────────────────────────── --}}
<div class="detail-grid">

    {{-- Driver Info ──────────────────────────────── --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M5.5 21a8.38 8.38 0 0 1 13 0"/>
                </svg>
            </div>
            <span class="info-card-title">Driver Information</span>
        </div>

        <div class="info-row">
            <span class="info-label">Full Name</span>
            <span class="info-value">{{ $driver->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value" style="font-size:12.5px;">{{ $driver->user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone</span>
            <span class="info-value">{{ $driver->user->phone ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
                @php
                    $statusClass = match($driver->status) {
                        'approved' => 'badge-success',
                        'pending'  => 'badge-warning',
                        default    => 'badge-danger',
                    };
                @endphp
                <span class="badge {{ $statusClass }}">{{ ucfirst($driver->status) }}</span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Availability</span>
            <span class="info-value">
                <span class="avail-dot {{ $driver->is_available ? 'available' : 'unavailable' }}">
                    {{ $driver->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Registered</span>
            <span class="info-value">{{ $driver->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    {{-- License Info ─────────────────────────────── --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon" style="background:#fefce8;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                    <line x1="2" y1="10" x2="22" y2="10"/>
                </svg>
            </div>
            <span class="info-card-title">License Details</span>
        </div>

        <div class="info-row">
            <span class="info-label">License No.</span>
            <span class="info-value" style="font-family:'DM Mono',monospace; font-size:12px;">
                {{ $driver->license_number ?? '—' }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Expiry Date</span>
            <span class="info-value">
                @if($driver->license_expiry)
                    @php $expired = \Carbon\Carbon::parse($driver->license_expiry)->isPast(); @endphp
                    <span style="color:{{ $expired ? '#dc2626' : '#1e293b' }};">
                        {{ \Carbon\Carbon::parse($driver->license_expiry)->format('M d, Y') }}
                    </span>
                    @if($expired)
                        <span class="badge badge-danger" style="margin-left:4px; font-size:10px;">Expired</span>
                    @elseif(\Carbon\Carbon::parse($driver->license_expiry)->diffInDays(now()) <= 30)
                        <span class="badge badge-warning" style="margin-left:4px; font-size:10px;">Expiring soon</span>
                    @endif
                @else
                    —
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Earnings</span>
            <span class="info-value" style="color:#16a34a;">
                ${{ number_format($totalEarnings, 2) }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Completed Trips</span>
            <span class="info-value">{{ $completedTrips }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Active Bookings</span>
            <span class="info-value" style="color:#d97706;">{{ $activeBookings }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Last Updated</span>
            <span class="info-value">{{ $driver->updated_at->format('M d, Y') }}</span>
        </div>
    </div>

    {{-- Vehicles ─────────────────────────────────── --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon" style="background:#f0f9ff;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0284c7"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <path d="M16 8h4l3 5v3h-7V8z"/>
                    <circle cx="5.5"  cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <span class="info-card-title">Vehicles</span>
            <span style="margin-left:auto; font-size:11.5px; color:#94a3b8;">
                {{ $driver->vehicles->count() }} registered
            </span>
        </div>

        @forelse($driver->vehicles as $vehicle)
            <div class="list-item">
                <div class="list-icon-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0284c7"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" rx="2"/>
                        <path d="M16 8h4l3 5v3h-7V8z"/>
                        <circle cx="5.5"  cy="18.5" r="2.5"/>
                        <circle cx="18.5" cy="18.5" r="2.5"/>
                    </svg>
                </div>
                <div class="list-body">
                    <div class="list-name">
                        {{ $vehicle->year ?? '' }} {{ $vehicle->make ?? '' }} {{ $vehicle->model ?? '' }}
                    </div>
                    <div class="list-sub">
                        Plate: <span style="font-family:'DM Mono',monospace;">{{ $vehicle->plate_number ?? '—' }}</span>
                        @if($vehicle->color) · {{ $vehicle->color }} @endif
                    </div>
                </div>
                @if(isset($vehicle->is_active))
                    <span class="badge {{ $vehicle->is_active ? 'badge-success' : '' }}"
                          style="{{ !$vehicle->is_active ? 'background:#f1f5f9; color:#94a3b8;' : '' }}">
                        {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                    </span>
                @endif
            </div>
        @empty
            <div class="empty-mini">
                <p style="font-size:13px; color:#94a3b8;">No vehicles registered yet.</p>
            </div>
        @endforelse
    </div>

    {{-- Documents ────────────────────────────────── --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon" style="background:#fdf4ff;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9333ea"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <span class="info-card-title">Documents</span>
            <span style="margin-left:auto; font-size:11.5px; color:#94a3b8;">
                {{ $driver->documents->count() }} uploaded
            </span>
        </div>

        @forelse($driver->documents as $doc)
            <div class="list-item">
                <div class="list-icon-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9333ea"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="list-body">
                    <div class="list-name">{{ $doc->type ?? $doc->name ?? 'Document' }}</div>
                    <div class="list-sub">
                        Uploaded {{ $doc->created_at->format('M d, Y') }}
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    @if(isset($doc->status))
                        @php
                            $docBadge = match($doc->status) {
                                'approved' => 'badge-success',
                                'pending'  => 'badge-warning',
                                default    => 'badge-danger',
                            };
                        @endphp
                        <span class="badge {{ $docBadge }}">{{ ucfirst($doc->status) }}</span>
                    @endif
                    @if(isset($doc->file_path))
                        <a href="{{ Storage::url($doc->file_path) }}"
                           target="_blank"
                           style="display:inline-flex; align-items:center; gap:4px;
                                  font-size:12px; font-weight:600; color:#2563eb;
                                  text-decoration:none; padding:4px 8px;
                                  background:#eff6ff; border-radius:6px;
                                  transition:background 0.12s;"
                           onmouseover="this.style.background='#dbeafe'"
                           onmouseout="this.style.background='#eff6ff'">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.5"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                <polyline points="15 3 21 3 21 9"/>
                                <line x1="10" y1="14" x2="21" y2="3"/>
                            </svg>
                            View
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-mini">
                <p style="font-size:13px; color:#94a3b8;">No documents uploaded yet.</p>
            </div>
        @endforelse
    </div>

</div>

{{-- ── DANGER ZONE ──────────────────────────────── --}}
<div class="info-card" style="margin-bottom:8px;">
    <div class="info-card-header">
        <div class="info-card-icon" style="background:#fef2f2;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9"  x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <span class="info-card-title" style="color:#dc2626;">Danger Zone</span>
    </div>
    <div style="padding:16px 20px; display:flex; align-items:center;
                justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div>
            <p style="font-size:13px; font-weight:600; color:#1e293b; margin-bottom:2px;">
                Delete this driver
            </p>
            <p style="font-size:12px; color:#94a3b8;">
                Permanently removes the driver account and all associated data. This cannot be undone.
            </p>
        </div>
        <form method="POST" action="{{ route('admin.drivers.destroy', $driver) }}"
              onsubmit="return confirm('Are you sure you want to delete {{ addslashes($driver->user->name) }}? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                Delete Driver
            </button>
        </form>
    </div>
</div>

@endsection