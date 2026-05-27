@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    /* ── Stat grid ───────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, 0.07);
        padding: 22px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.15s, box-shadow 0.15s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    }

    .stat-card.revenue {
        background: linear-gradient(135deg, #0b1a2e 0%, #1e3a5f 50%, #2563eb 100%);
        border-color: transparent;
    }

    .stat-icon-wrap {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-body {
        min-width: 0;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 4px;
    }

    /* ── Bookings card ───────────────────────── */
    .bookings-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .card-header-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ── Desktop / mobile toggle ─────────────── */
    .desktop-table {
        display: block;
        overflow-x: auto;
    }

    .mobile-list {
        display: none;
    }

    /* ── Empty state ─────────────────────────── */
    .empty-state {
        padding: 52px 24px;
        text-align: center;
    }

    .empty-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-card {
            padding: 16px 14px;
            gap: 11px;
        }

        .stat-icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 10px;
        }

        .stat-value {
            font-size: 22px;
        }

        .stat-label {
            font-size: 11px;
        }

        .card-header {
            padding: 14px 16px;
        }

        .desktop-table {
            display: none;
        }

        .mobile-list {
            display: block;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .stat-card {
            padding: 14px 12px;
        }

        .stat-value {
            font-size: 20px;
        }
    }
    .page-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-header p {
        font-size: 13px;
        color: #94a3b8;
        margin-top: 3px;
    }
</style>
<div class="page-header">
    <div>
        <h2>Operations Dashboard</h2>
        <p class="header-sub">Real-time metrics &amp; performance intelligence</p>
    </div>
</div>
<br>
{{-- ── STAT CARDS ───────────────────────────────── --}}
<div class="stats-grid">
    
    {{-- Total Bookings --}}
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:#eff6ff;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
    </div>

    {{-- Pending --}}
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:#fefce8;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#d97706"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-value" style="color:#d97706;">{{ $stats['pending_bookings'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    {{-- Completed --}}
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:#f0fdf4;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-value" style="color:#16a34a;">{{ $stats['completed_trips'] }}</div>
            <div class="stat-label">Completed Trips</div>
        </div>
    </div>

    {{-- Revenue — accent card --}}
    <div class="stat-card revenue">
        <div class="stat-icon-wrap" style="background:rgba(255,255,255,0.12);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="rgba(255,255,255,0.85)" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23" />
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-value" style="color:#fff;">
                ${{ number_format($stats['total_revenue'], 0) }}
            </div>
            <div class="stat-label" style="color:rgba(255,255,255,0.5);">Total Revenue</div>
        </div>
    </div>

    {{-- Clients --}}
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:#fdf4ff;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9333ea"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-value" style="color:#9333ea;">{{ $stats['total_clients'] }}</div>
            <div class="stat-label">Clients</div>
        </div>
    </div>

    {{-- Drivers --}}
    <div class="stat-card">
        <div class="stat-icon-wrap" style="background:#f0f9ff;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0284c7"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="3" width="15" height="13" rx="2" />
                <path d="M16 8h4l3 5v3h-7V8z" />
                <circle cx="5.5" cy="18.5" r="2.5" />
                <circle cx="18.5" cy="18.5" r="2.5" />
            </svg>
        </div>
        <div class="stat-body">
            <div class="stat-value" style="color:#0284c7;">{{ $stats['total_drivers'] }}</div>
            <div class="stat-label">Drivers</div>
        </div>
    </div>

</div>
{{-- ── CHARTS ────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:1fr 340px; gap:16px; margin-bottom:24px;">

    {{-- Line chart: Bookings over 30 days --}}
    <div style="background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,0.07); padding:22px 24px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <p style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.2;">Bookings Trend</p>
                <p style="font-size:12px; color:#94a3b8; margin-top:2px;">Last 30 days</p>
            </div>
            <div style="display:inline-flex; align-items:center; gap:5px; background:#eff6ff;
                        border-radius:8px; padding:5px 10px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                    <polyline points="17 6 23 6 23 12" />
                </svg>
                <span style="font-size:12px; font-weight:600; color:#2563eb;">
                    {{ $counts->sum() }} total
                </span>
            </div>
        </div>
        <canvas id="bookingsTrendChart" height="110"></canvas>
    </div>

    {{-- Donut chart: by status --}}
    <div style="background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,0.07); padding:22px 24px;">
        <div style="margin-bottom:20px;">
            <p style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.2;">By Status</p>
            <p style="font-size:12px; color:#94a3b8; margin-top:2px;">All time breakdown</p>
        </div>
        <canvas id="statusDonutChart" height="180"></canvas>
        {{-- Legend --}}
        <div style="margin-top:16px; display:flex; flex-direction:column; gap:6px;">
            @php
            $statusColors = [
            'pending' => '#f59e0b',
            'approved' => '#3b82f6',
            'assigned' => '#8b5cf6',
            'in_transit' => '#06b6d4',
            'completed' => '#16a34a',
            'cancelled' => '#ef4444',
            ];
            @endphp
            @foreach($byStatus as $status => $count)
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:10px; height:10px; border-radius:3px; flex-shrink:0;
                                background:{{ $statusColors[$status] ?? '#94a3b8' }};"></div>
                    <span style="font-size:12px; color:#64748b; font-weight:500;">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </div>
                <span style="font-size:12px; font-weight:700; color:#0f172a;">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
{{-- ── BOOKING CALENDAR ────────────────────────── --}}
<div style="background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,0.07);
            padding:22px 24px; margin-bottom:24px;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <div>
            <p style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.2;">Booking Calendar</p>
            <p style="font-size:12px; color:#94a3b8; margin-top:2px;">Scheduled trips at a glance</p>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <button id="cal-prev" style="width:32px; height:32px; border-radius:8px; border:1.5px solid #e2e8f0;
                    background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
                    transition:all 0.13s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>
            <span id="cal-title" style="font-size:14px; font-weight:700; color:#0f172a; min-width:140px; text-align:center;"></span>
            <button id="cal-next" style="width:32px; height:32px; border-radius:8px; border:1.5px solid #e2e8f0;
                    background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
                    transition:all 0.13s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
            </button>
            <button id="cal-today" style="font-size:12px; font-weight:600; color:#2563eb; background:#eff6ff;
                    border:1.5px solid #bfdbfe; border-radius:8px; padding:6px 12px; cursor:pointer;
                    transition:all 0.13s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                Today
            </button>
        </div>
    </div>

    {{-- Day headers --}}
    <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:4px; margin-bottom:4px;">
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
        <div style="text-align:center; font-size:11px; font-weight:700; color:#94a3b8;
                    text-transform:uppercase; letter-spacing:0.05em; padding:6px 0;">
            {{ $day }}
        </div>
        @endforeach
    </div>

    {{-- Calendar grid --}}
    <div id="cal-grid" style="display:grid; grid-template-columns:repeat(7,1fr); gap:4px;"></div>

    {{-- Selected day bookings panel --}}
    <div id="cal-panel" style="display:none; margin-top:16px; border-top:1px solid #f1f5f9; padding-top:16px;">
        <p id="cal-panel-title" style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:10px;"></p>
        <div id="cal-panel-list" style="display:flex; flex-direction:column; gap:8px;"></div>
    </div>

</div>

{{-- ── RECENT BOOKINGS ──────────────────────────── --}}
<div class="bookings-card">

    {{-- Header --}}
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
            </div>
            <div>
                <p style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.2;">
                    Recent Bookings
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    Latest {{ count($recentBookings) }} booking{{ count($recentBookings) != 1 ? 's' : '' }}
                </p>
            </div>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn-ghost btn-sm"
            style="display:inline-flex; align-items:center; gap:6px; white-space:nowrap;">
            View all
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    @if($recentBookings->isEmpty())

    {{-- Empty state --}}
    <div class="empty-state">
        <div class="empty-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
            </svg>
        </div>
        <p style="font-size:15px; font-weight:600; color:#475569; margin-bottom:4px;">
            No bookings yet
        </p>
        <p style="font-size:13px; color:#94a3b8;">
            Bookings will appear here once clients start booking rides.
        </p>
    </div>

    @else

    {{-- ════════════════════════════════════════
             DESKTOP TABLE — hidden on mobile
        ════════════════════════════════════════ --}}
    <div class="desktop-table">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Booking</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Scheduled</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $b)
                <tr>
                    <td>
                        <a href="{{ route('admin.bookings.show', $b) }}"
                            style="font-family:'DM Mono',monospace; font-size:11px;
                                      color:#2563eb; font-weight:500; text-decoration:none;
                                      white-space:nowrap;">
                            {{ $b->booking_number }}
                        </a>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px;
                                            background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:11px; font-weight:700; color:#fff;
                                            flex-shrink:0;">
                                {{ strtoupper(substr($b->client->name, 0, 1)) }}
                            </div>
                            <span style="font-weight:600; color:#1e293b; font-size:13px;">
                                {{ $b->client->name }}
                            </span>
                        </div>
                    </td>
                    <td style="color:#64748b; font-size:13px; white-space:nowrap;">
                        {{ $b->serviceType->name }}
                    </td>
                    <td style="white-space:nowrap;">
                        <span style="font-size:13px; color:#334155; font-weight:500;">
                            {{ $b->scheduled_at->format('M d, Y') }}
                        </span>
                        <span style="display:block; font-size:11.5px; color:#94a3b8; margin-top:1px;">
                            {{ $b->scheduled_at->format('H:i') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $b->getStatusBadgeClass() }}">
                            {{ ucfirst(str_replace('_', ' ', $b->status)) }}
                        </span>
                    </td>
                    <td>
                        @if($b->is_paid)
                        <span style="display:inline-flex; align-items:center; gap:4px;
                                             font-size:12.5px; font-weight:600; color:#16a34a;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Paid
                        </span>
                        @else
                        <span style="display:inline-flex; align-items:center; gap:4px;
                                             font-size:12.5px; font-weight:500; color:#94a3b8;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            Unpaid
                        </span>
                        @endif
                    </td>
                    <td style="font-weight:700; color:#0f172a; text-align:right; white-space:nowrap;">
                        ${{ number_format($b->final_price, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ════════════════════════════════════════
             MOBILE LIST — hidden on desktop
             Own @foreach, independent of the table.
        ════════════════════════════════════════ --}}
    <div class="mobile-list">
        @foreach($recentBookings as $b)
        <div style="padding:16px 18px;
                        border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

            {{-- Row 1: booking number + status + amount --}}
            <div style="display:flex; justify-content:space-between;
                             align-items:flex-start; gap:10px; margin-bottom:7px;">
                <div style="display:flex; align-items:center; gap:7px; flex-wrap:wrap;">
                    <a href="{{ route('admin.bookings.show', $b) }}"
                        style="font-family:'DM Mono',monospace; font-size:10.5px;
                                  color:#2563eb; font-weight:600; text-decoration:none;">
                        {{ $b->booking_number }}
                    </a>
                    <span class="badge {{ $b->getStatusBadgeClass() }}">
                        {{ ucfirst(str_replace('_', ' ', $b->status)) }}
                    </span>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <p style="font-size:17px; font-weight:800; color:#0f172a;
                                  letter-spacing:-0.02em; line-height:1;">
                        ${{ number_format($b->final_price, 2) }}
                    </p>
                    @if($b->is_paid)
                    <span style="display:inline-flex; align-items:center; gap:3px;
                                         font-size:11px; font-weight:600; color:#16a34a; margin-top:3px;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Paid
                    </span>
                    @else
                    <span style="font-size:11px; font-weight:500; color:#94a3b8;
                                         margin-top:3px; display:block;">Unpaid</span>
                    @endif
                </div>
            </div>

            {{-- Row 2: client avatar + name --}}
            <div style="display:flex; align-items:center; gap:7px; margin-bottom:5px;">
                <div style="width:24px; height:24px; border-radius:6px; flex-shrink:0;
                                background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                display:flex; align-items:center; justify-content:center;
                                font-size:10px; font-weight:700; color:#fff;">
                    {{ strtoupper(substr($b->client->name, 0, 1)) }}
                </div>
                <span style="font-size:13px; font-weight:600; color:#1e293b;">
                    {{ $b->client->name }}
                </span>
            </div>

            {{-- Row 3: service type --}}
            <p style="font-size:13px; color:#64748b; margin-bottom:5px;">
                {{ $b->serviceType->name }}
            </p>

            {{-- Row 4: date --}}
            <div style="display:flex; align-items:center; gap:5px; margin-bottom:12px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                    stroke="#94a3b8" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                <span style="font-size:12px; color:#64748b;">
                    {{ $b->scheduled_at->format('M d, Y · H:i') }}
                </span>
            </div>

            {{-- View button --}}
            <a href="{{ route('admin.bookings.show', $b) }}"
                style="display:flex; align-items:center; justify-content:center; gap:6px;
                          background:#eff6ff; color:#2563eb; border-radius:8px;
                          padding:8px 12px; font-size:12.5px; font-weight:600;
                          text-decoration:none; transition:background 0.12s;"
                onmouseover="this.style.background='#dbeafe'"
                onmouseout="this.style.background='#eff6ff'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                View Booking
            </a>

        </div>
        @endforeach
    </div>

    @endif

</div>
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ── Line chart ────────────────────────────
        const trendCtx = document.getElementById('bookingsTrendChart').getContext('2d');
        const gradient = trendCtx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(37,99,235,0.15)');
        gradient.addColorStop(1, 'rgba(37,99,235,0)');

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json($days),
                datasets: [{
                    label: 'Bookings',
                    data: @json($counts),
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#94a3b8',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            title: ctx => ctx[0].label,
                            label: ctx => ' ' + ctx.parsed.y + ' booking' + (ctx.parsed.y !== 1 ? 's' : ''),
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11
                            },
                            maxTicksLimit: 8,
                            maxRotation: 0,
                        },
                        border: {
                            display: false
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11
                            },
                            stepSize: 1,
                            precision: 0,
                        },
                        grid: {
                            color: '#f1f5f9'
                        },
                        border: {
                            display: false
                        },
                    }
                }
            }
        });

        // ── Donut chart ───────────────────────────
        const donutCtx = document.getElementById('statusDonutChart').getContext('2d');
        const statusColors = {
            pending: '#f59e0b',
            approved: '#3b82f6',
            assigned: '#8b5cf6',
            in_transit: '#06b6d4',
            completed: '#16a34a',
            cancelled: '#ef4444',
        };
        const byStatus = @json($byStatus);
        const labels = Object.keys(byStatus);
        const values = Object.values(byStatus);
        const colors = labels.map(s => statusColors[s] ?? '#94a3b8');

        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: labels.map(s => s.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())),
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#94a3b8',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 8,
                    }
                }
            }
        });

    });
</script>

{{-- Responsive: stack charts on mobile --}}
<style>
    @media (max-width: 768px) {
        [style*="grid-template-columns:1fr 340px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<script>
    (function() {
        // All bookings passed from controller
        const bookings = @json($calendarBookings);

        // Group by date string YYYY-MM-DD
        const byDate = {};
        bookings.forEach(b => {
            const d = b.date;
            if (!byDate[d]) byDate[d] = [];
            byDate[d].push(b);
        });

        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const statusColors = {
            pending: '#f59e0b',
            approved: '#3b82f6',
            assigned: '#8b5cf6',
            in_transit: '#06b6d4',
            completed: '#16a34a',
            cancelled: '#ef4444',
        };

        let current = new Date();
        let activeDay = null;

        function render() {
            const year = current.getFullYear();
            const month = current.getMonth();

            document.getElementById('cal-title').textContent =
                monthNames[month] + ' ' + year;

            const grid = document.getElementById('cal-grid');
            grid.innerHTML = '';

            const firstDay = new Date(year, month, 1).getDay();
            const daysIn = new Date(year, month + 1, 0).getDate();
            const today = new Date();

            // Empty cells before month starts
            for (let i = 0; i < firstDay; i++) {
                grid.appendChild(Object.assign(document.createElement('div'), {
                    style: 'min-height:68px;'
                }));
            }

            for (let d = 1; d <= daysIn; d++) {
                const dateStr = year + '-' +
                    String(month + 1).padStart(2, '0') + '-' +
                    String(d).padStart(2, '0');

                const isToday = today.getFullYear() === year &&
                    today.getMonth() === month &&
                    today.getDate() === d;
                const isActive = activeDay === dateStr;
                const dayBookings = byDate[dateStr] || [];
                const hasBookings = dayBookings.length > 0;

                const cell = document.createElement('div');
                cell.style.cssText = `
                min-height:68px; border-radius:10px; padding:8px;
                border:1.5px solid ${isActive ? '#2563eb' : (hasBookings ? '#e2e8f0' : 'transparent')};
                background:${isActive ? '#eff6ff' : (hasBookings ? '#fafafa' : '#fff')};
                cursor:${hasBookings ? 'pointer' : 'default'};
                transition:all 0.13s; position:relative;
            `;

                // Day number
                const num = document.createElement('div');
                num.style.cssText = `
                font-size:13px; font-weight:${isToday ? '800' : '600'};
                color:${isToday ? '#fff' : (isActive ? '#2563eb' : '#334155')};
                width:24px; height:24px; border-radius:7px; display:flex;
                align-items:center; justify-content:center; margin-bottom:4px;
                background:${isToday ? '#2563eb' : 'transparent'};
            `;
                num.textContent = d;
                cell.appendChild(num);

                // Booking dots / count
                if (hasBookings) {
                    if (dayBookings.length <= 3) {
                        const dots = document.createElement('div');
                        dots.style.cssText = 'display:flex; flex-direction:column; gap:3px;';
                        dayBookings.slice(0, 3).forEach(b => {
                            const dot = document.createElement('div');
                            dot.style.cssText = `
                            font-size:10px; font-weight:600; color:#fff;
                            background:${statusColors[b.status] ?? '#94a3b8'};
                            border-radius:4px; padding:2px 5px;
                            white-space:nowrap; overflow:hidden;
                            text-overflow:ellipsis; max-width:100%;
                        `;
                            dot.textContent = b.time + ' ' + b.client;
                            cell.appendChild(dot);
                        });
                    } else {
                        const badge = document.createElement('div');
                        badge.style.cssText = `
                        font-size:11px; font-weight:700; color:#2563eb;
                        background:#eff6ff; border-radius:6px; padding:3px 7px;
                        display:inline-block; margin-top:2px;
                    `;
                        badge.textContent = dayBookings.length + ' bookings';
                        cell.appendChild(badge);
                    }

                    cell.addEventListener('click', () => {
                        activeDay = isActive ? null : dateStr;
                        render();
                        renderPanel(dateStr, dayBookings);
                    });

                    cell.addEventListener('mouseover', () => {
                        if (!isActive) cell.style.background = '#f0f4ff';
                    });
                    cell.addEventListener('mouseout', () => {
                        if (!isActive) cell.style.background = hasBookings ? '#fafafa' : '#fff';
                    });
                }

                grid.appendChild(cell);
            }
        }

        function renderPanel(dateStr, dayBookings) {
            const panel = document.getElementById('cal-panel');
            const title = document.getElementById('cal-panel-title');
            const list = document.getElementById('cal-panel-list');

            if (!activeDay) {
                panel.style.display = 'none';
                return;
            }

            const [y, m, d] = dateStr.split('-');
            const dateObj = new Date(y, m - 1, d);
            title.textContent = dateObj.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) + ' — ' + dayBookings.length + ' booking' + (dayBookings.length !== 1 ? 's' : '');

            list.innerHTML = '';
            dayBookings.forEach(b => {
                const item = document.createElement('a');
                item.href = `/admin/bookings/${b.id}`;
                item.style.cssText = `
                display:flex; align-items:center; gap:12px; padding:10px 14px;
                border:1.5px solid #e2e8f0; border-radius:10px; text-decoration:none;
                transition:all 0.13s; background:#fff;
            `;
                item.onmouseover = () => item.style.background = '#f8fafc';
                item.onmouseout = () => item.style.background = '#fff';
                item.innerHTML = `
                <div style="width:4px; height:40px; border-radius:4px; flex-shrink:0;
                             background:${statusColors[b.status] ?? '#94a3b8'};"></div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:12.5px; font-weight:700; color:#0f172a; margin-bottom:2px;">
                        ${b.booking_number}
                        <span style="font-size:11px; font-weight:500; color:#94a3b8; margin-left:6px;">${b.time}</span>
                    </div>
                    <div style="font-size:12px; color:#64748b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        ${b.client} · ${b.service}
                    </div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        ${b.pickup}
                    </div>
                </div>
                <span style="flex-shrink:0; font-size:11px; font-weight:700; color:#fff;
                             background:${statusColors[b.status] ?? '#94a3b8'};
                             border-radius:6px; padding:3px 8px;">
                    ${b.status.replace('_', ' ')}
                </span>
            `;
                list.appendChild(item);
            });

            panel.style.display = 'block';
        }

        document.getElementById('cal-prev').addEventListener('click', () => {
            current.setMonth(current.getMonth() - 1);
            activeDay = null;
            document.getElementById('cal-panel').style.display = 'none';
            render();
        });

        document.getElementById('cal-next').addEventListener('click', () => {
            current.setMonth(current.getMonth() + 1);
            activeDay = null;
            document.getElementById('cal-panel').style.display = 'none';
            render();
        });

        document.getElementById('cal-today').addEventListener('click', () => {
            current = new Date();
            activeDay = null;
            document.getElementById('cal-panel').style.display = 'none';
            render();
        });

        render();
    })();
</script>
@endsection