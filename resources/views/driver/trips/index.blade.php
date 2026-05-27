@extends('layouts.app')
@section('title', 'My Trips')
@section('content')

<style>
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
        flex-wrap: wrap;
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

    /* ── Filter chips ────────────────────────── */
    .filter-bar {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .filter-bar::-webkit-scrollbar { display: none; }
    .filter-label {
        font-size: 11.5px;
        font-weight: 600;
        color: #94a3b8;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .filter-chip {
        display: inline-flex;
        align-items: center;
        padding: 5px 13px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        background: #fff;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.13s;
        flex-shrink: 0;
    }
    .filter-chip:hover  { border-color: #16a34a; color: #16a34a; background: #f0fdf4; }
    .filter-chip.active { background: #16a34a; color: #fff; border-color: #16a34a; }

    /* ── Main card ───────────────────────────── */
    .trips-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .card-header-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #f0fdf4;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Action link ─────────────────────────── */
    .action-view {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 7px;
        text-decoration: none;
        color: #16a34a;
        background: #f0fdf4;
        transition: background 0.12s;
        white-space: nowrap;
    }
    .action-view:hover { background: #dcfce7; }

    /* ── Empty state ─────────────────────────── */
    .empty-state {
        padding: 56px 24px;
        text-align: center;
    }
    .empty-icon-wrap {
        width: 60px; height: 60px;
        border-radius: 16px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }

    /* ── Pagination ──────────────────────────── */
    .pagination-wrap {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    /* ── Desktop / mobile toggle ─────────────── */
    .desktop-table { display: block; overflow-x: auto; }
    .mobile-list   { display: none; }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 768px) {
        .page-header  { flex-direction: column; align-items: flex-start; }
        .card-header  { padding: 12px 16px; }
        .desktop-table { display: none; }
        .mobile-list   { display: block; }
        .pagination-wrap { justify-content: center; }
    }
</style>

{{-- ── PAGE HEADER ──────────────────────────────── --}}
<div class="page-header">
    <div>
        <h2>My Trips</h2>
        <p>All your assigned and completed transport trips</p>
    </div>
</div>

{{-- ── MAIN CARD ────────────────────────────────── --}}
<div class="trips-card">

    {{-- Card header --}}
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <path d="M16 8h4l3 5v3h-7V8z"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <div>
                <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                    All Trips
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $trips->total() }} trip{{ $trips->total() != 1 ? 's' : '' }} found
                </p>
            </div>
        </div>
    </div>

    {{-- Filter chips --}}
    <div class="filter-bar">
        <span class="filter-label">Filter:</span>
        <a href="{{ route('driver.trips.index') }}"
           class="filter-chip {{ !request('status') ? 'active' : '' }}">All</a>
        @foreach([
            'assigned'   => 'Assigned',
            'in_transit' => 'In Transit',
            'completed'  => 'Completed',
            'cancelled'  => 'Cancelled',
        ] as $val => $label)
        <a href="{{ route('driver.trips.index', ['status' => $val]) }}"
           class="filter-chip {{ request('status') === $val ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @if($trips->isEmpty())

        {{-- Empty state --}}
        <div class="empty-state">
            <div class="empty-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <path d="M16 8h4l3 5v3h-7V8z"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <p style="font-size:15px; font-weight:700; color:#475569; margin-bottom:4px;">
                {{ request('status') ? 'No ' . ucfirst(str_replace('_',' ',request('status'))) . ' trips' : 'No trips yet' }}
            </p>
            <p style="font-size:13px; color:#94a3b8;">
                {{ request('status') ? 'Try a different filter.' : 'Trips will appear here once you are assigned.' }}
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
                        <th>Booking #</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Scheduled</th>
                        <th>Status</th>
                        <th style="text-align:right;">Amount</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $t)
                    <tr>
                        <td>
                            <span style="font-family:'DM Mono',monospace; font-size:11px;
                                         color:#64748b; font-weight:500;">
                                {{ $t->booking_number }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                            background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:11px; font-weight:700; color:#fff;">
                                    {{ strtoupper(substr($t->client->name, 0, 1)) }}
                                </div>
                                <span style="font-size:13px; font-weight:600; color:#1e293b;">
                                    {{ $t->client->name }}
                                </span>
                            </div>
                        </td>
                        <td style="font-size:13px; color:#64748b; white-space:nowrap;">
                            {{ $t->serviceType->name }}
                        </td>
                        <td style="white-space:nowrap;">
                            <span style="font-size:13px; color:#334155; font-weight:500;">
                                {{ $t->scheduled_at->format('M d, Y') }}
                            </span>
                            <span style="display:block; font-size:11.5px; color:#94a3b8; margin-top:1px;">
                                {{ $t->scheduled_at->format('H:i') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $t->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $t->status)) }}
                            </span>
                        </td>
                        <td style="font-weight:700; color:#0f172a; text-align:right; white-space:nowrap;">
                            ${{ number_format($t->final_price, 2) }}
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('driver.trips.show', $t) }}" class="action-view">
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

        {{-- ════════════════════════════════════════
             MOBILE LIST — hidden on desktop
        ════════════════════════════════════════ --}}
        <div class="mobile-list">
            @foreach($trips as $t)
            <div style="padding:16px 18px;
                        border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

                {{-- Row 1: booking # + status + amount --}}
                <div style="display:flex; justify-content:space-between;
                             align-items:flex-start; gap:10px; margin-bottom:8px;">
                    <div style="display:flex; align-items:center; gap:7px; flex-wrap:wrap;">
                        <span style="font-family:'DM Mono',monospace; font-size:10.5px;
                                     color:#64748b; font-weight:600;">
                            {{ $t->booking_number }}
                        </span>
                        <span class="badge {{ $t->getStatusBadgeClass() }}">
                            {{ ucfirst(str_replace('_', ' ', $t->status)) }}
                        </span>
                    </div>
                    <p style="font-size:17px; font-weight:800; color:#0f172a;
                               letter-spacing:-0.02em; line-height:1; flex-shrink:0;">
                        ${{ number_format($t->final_price, 2) }}
                    </p>
                </div>

                {{-- Row 2: client --}}
                <div style="display:flex; align-items:center; gap:7px; margin-bottom:5px;">
                    <div style="width:24px; height:24px; border-radius:6px; flex-shrink:0;
                                background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                display:flex; align-items:center; justify-content:center;
                                font-size:10px; font-weight:700; color:#fff;">
                        {{ strtoupper(substr($t->client->name, 0, 1)) }}
                    </div>
                    <span style="font-size:13px; font-weight:600; color:#1e293b;">
                        {{ $t->client->name }}
                    </span>
                </div>

                {{-- Row 3: service + date --}}
                <p style="font-size:13px; color:#64748b; margin-bottom:4px;">
                    {{ $t->serviceType->name }}
                </p>
                <div style="display:flex; align-items:center; gap:5px; margin-bottom:12px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="#94a3b8" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                        <line x1="3"  y1="10" x2="21" y2="10"/>
                    </svg>
                    <span style="font-size:12px; color:#64748b;">
                        {{ $t->scheduled_at->format('M d, Y · H:i') }}
                    </span>
                </div>

                {{-- View button --}}
                <a href="{{ route('driver.trips.show', $t) }}"
                   style="display:flex; align-items:center; justify-content:center; gap:6px;
                          background:#f0fdf4; color:#16a34a; border-radius:8px;
                          padding:9px 12px; font-size:13px; font-weight:600;
                          text-decoration:none; transition:background 0.12s;"
                   onmouseover="this.style.background='#dcfce7'"
                   onmouseout="this.style.background='#f0fdf4'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
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

    {{-- Pagination --}}
    @if($trips->hasPages())
    <div class="pagination-wrap">
        {{ $trips->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection