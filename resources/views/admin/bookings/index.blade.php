@extends('layouts.app')
@section('title', 'Manage Bookings')
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

    /* ── Filter bar ──────────────────────────── */
    .filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 8px 34px 8px 12px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        background: #fff;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        cursor: pointer;
        outline: none;
        transition: border-color 0.13s, box-shadow 0.13s;
        font-family: 'DM Sans', sans-serif;
    }

    .filter-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #2563eb;
        color: #fff;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.13s;
        font-family: 'DM Sans', sans-serif;
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.25);
    }

    .filter-btn:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }

    /* ── Main card ───────────────────────────── */
    .bookings-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, 0.07);
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
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ── Status chip filter (mobile) ─────────── */
    .chip-bar {
        padding: 12px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: none;
        gap: 7px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .chip-bar::-webkit-scrollbar {
        display: none;
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        background: #fff;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.12s;
        flex-shrink: 0;
    }

    .status-chip:hover {
        border-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
    }

    .status-chip.active {
        background: #2563eb;
        color: #fff;
        border-color: #2563eb;
    }

    /* ── Action links ────────────────────────── */
    .action-view {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 7px;
        text-decoration: none;
        color: #2563eb;
        background: #eff6ff;
        transition: background 0.12s;
        white-space: nowrap;
    }

    .action-view:hover {
        background: #dbeafe;
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

    /* ── Pagination ──────────────────────────── */
    .pagination-wrap {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-form {
            display: none;
        }

        /* replaced by chip bar on mobile */
        .chip-bar {
            display: flex;
        }

        .card-header {
            padding: 12px 16px;
        }

        .desktop-table {
            display: none;
        }

        .mobile-list {
            display: block;
        }

        .pagination-wrap {
            justify-content: center;
        }
    }
</style>

{{-- ── PAGE HEADER ──────────────────────────────── --}}
<div class="page-header">
    <div>
        <h2>Manage Bookings</h2>
        <p>Review, assign drivers, and track all transport requests</p>
    </div>

    {{-- New Booking button --}}
    <a href="{{ route('admin.bookings.create') }}"
       class="filter-btn"
       style="display:inline-flex; align-items:center; gap:6px; text-decoration:none; margin-left:auto;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Booking
    </a>

    {{-- Desktop filter form --}}
    <form method="GET" class="filter-form">

    {{-- Search --}}
    <div style="position:relative;">
        <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </span>
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search booking, client, address..."
            style="border:1.5px solid #e2e8f0; border-radius:9px; padding:8px 12px 8px 34px;
                   font-size:13px; font-weight:500; color:#334155; background:#fff;
                   outline:none; transition:border-color 0.13s, box-shadow 0.13s;
                   font-family:'DM Sans',sans-serif; width:240px;"
            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
        >
    </div>

    {{-- Status filter --}}
    <div style="position:relative;">
        <select name="status" class="filter-select">
            <option value="">All Statuses</option>
            @foreach([
                'pending'    => 'Pending',
                'approved'   => 'Approved',
                'assigned'   => 'Assigned',
                'in_transit' => 'In Transit',
                'completed'  => 'Completed',
                'cancelled'  => 'Cancelled',
            ] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                {{ $label }}
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="filter-btn">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
        Filter
    </button>

    @if(request('status') || request('search'))
    <a href="{{ route('admin.bookings.index') }}"
       style="display:inline-flex; align-items:center; gap:5px; font-size:13px;
              font-weight:500; color:#64748b; text-decoration:none; padding:8px 12px;
              border:1.5px solid #e2e8f0; border-radius:9px; transition:all 0.12s;"
       onmouseover="this.style.background='#f1f5f9'"
       onmouseout="this.style.background='transparent'">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6"  y1="6" x2="18" y2="18"/>
        </svg>
        Clear
    </a>
    @endif

</form>
</div>

{{-- ── MAIN CARD ────────────────────────────────── --}}
<div class="bookings-card">

    {{-- Card header --}}
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
            </div>
            <div>
                <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                    {{ request('status') ? ucfirst(str_replace('_',' ',request('status'))) . ' Bookings' : 'All Bookings' }}
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $bookings->total() }} booking{{ $bookings->total() != 1 ? 's' : '' }} found
                </p>
            </div>
        </div>
        @if(request('status'))
        <span class="badge" style="background:#eff6ff; color:#2563eb; font-size:11.5px;">
            Filtered: {{ ucfirst(str_replace('_',' ',request('status'))) }}
        </span>
        @endif
    </div>

    {{-- Mobile chip filter bar --}}
    <div class="chip-bar">
        <a href="{{ route('admin.bookings.index') }}"
            class="status-chip {{ !request('status') ? 'active' : '' }}">All</a>
        @foreach([
        'pending' => 'Pending',
        'approved' => 'Approved',
        'assigned' => 'Assigned',
        'in_transit' => 'In Transit',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        ] as $val => $label)
        <a href="{{ route('admin.bookings.index', ['status' => $val]) }}"
            class="status-chip {{ request('status') === $val ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @if($bookings->isEmpty())

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
            {{ request('status') ? 'No ' . ucfirst(str_replace('_',' ',request('status'))) . ' bookings' : 'No bookings found' }}
        </p>
        <p style="font-size:13px; color:#94a3b8;">
            {{ request('status') ? 'Try a different status filter.' : 'Bookings will appear here once clients start booking.' }}
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
                    <th>Payment</th>
                    <th style="text-align:right;">Amount</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                <tr>
                    <td>
                        <span style="font-family:'DM Mono',monospace; font-size:11px;
                                         color:#64748b; font-weight:500;">
                            {{ $b->booking_number }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                            background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:11px; font-weight:700; color:#fff;">
                                {{ strtoupper(substr($b->client->name, 0, 1)) }}
                            </div>
                            <div>
                                <span style="font-size:13px; font-weight:600; color:#1e293b;
                                                 display:block; white-space:nowrap;">
                                    {{ $b->client->name }}
                                </span>
                                <span style="font-size:11.5px; color:#94a3b8;">
                                    {{ $b->client->email }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px; color:#64748b; white-space:nowrap;">
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
                    <td style="font-weight:700; color:#0f172a; text-align:right;
                                   white-space:nowrap;">
                        ${{ number_format($b->final_price, 2) }}
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.bookings.show', $b) }}" class="action-view">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
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
             Own @foreach, every item renders.
        ════════════════════════════════════════ --}}
    <div class="mobile-list">
        @foreach($bookings as $b)
        <div style="padding:16px 18px;
                        border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

            {{-- Row 1: booking # + status + amount --}}
            <div style="display:flex; justify-content:space-between;
                             align-items:flex-start; gap:10px; margin-bottom:8px;">
                <div style="display:flex; align-items:center; gap:7px; flex-wrap:wrap;">
                    <span style="font-family:'DM Mono',monospace; font-size:10.5px;
                                     color:#64748b; font-weight:600;">
                        {{ $b->booking_number }}
                    </span>
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

            {{-- Row 2: client --}}
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
                          padding:9px 12px; font-size:13px; font-weight:600;
                          text-decoration:none; transition:background 0.12s;"
                onmouseover="this.style.background='#dbeafe'"
                onmouseout="this.style.background='#eff6ff'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
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

    {{-- Pagination --}}
    @if($bookings->hasPages())
    <div class="pagination-wrap">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection