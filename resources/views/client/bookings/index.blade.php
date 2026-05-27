@extends('layouts.app')
@section('title', 'My Bookings')
@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }
    .page-header-left h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .page-header-left p {
        font-size: 13px;
        color: #94a3b8;
        margin-top: 3px;
    }

    .bookings-wrap {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }

    /* Filter chips */
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
        margin-right: 4px;
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
    .filter-chip:hover  { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
    .filter-chip.active { background: #2563eb; color: #fff; border-color: #2563eb; }

    /* Action buttons */
    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 7px;
        text-decoration: none;
        transition: background 0.12s;
        white-space: nowrap;
    }
    .action-view            { color: #2563eb; background: #eff6ff; }
    .action-view:hover      { background: #dbeafe; }
    .action-invoice         { color: #16a34a; background: #f0fdf4; }
    .action-invoice:hover   { background: #dcfce7; }

    /* Empty state */
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

    /* Pagination */
    .pagination-wrap {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    /* ── DESKTOP: show table, hide mobile list ── */
    .desktop-table  { display: block; overflow-x: auto; }
    .mobile-list    { display: none; }

    /* ── MOBILE: hide table, show mobile list ─── */
    @media (max-width: 768px) {
        .page-header            { flex-direction: column; align-items: flex-start; }
        .page-header .btn-primary { width: 100%; justify-content: center; }
        .desktop-table          { display: none; }
        .mobile-list            { display: block; }
        .pagination-wrap        { justify-content: center; }
    }
</style>

{{-- ── PAGE HEADER ──────────────────────────────── --}}
<div class="page-header">
    <div class="page-header-left">
        <h2>My Bookings</h2>
        <p>All your transportation requests in one place</p>
    </div>
    <a href="{{ route('client.bookings.create') }}" class="btn-primary"
       style="display:inline-flex; align-items:center; gap:7px; white-space:nowrap;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="16"/>
            <line x1="8"  y1="12" x2="16" y2="12"/>
        </svg>
        New Booking
    </a>
</div>

{{-- ── MAIN CARD ────────────────────────────────── --}}
<div class="bookings-wrap">

    {{-- Filter bar --}}
    <div class="filter-bar">
        <span class="filter-label">Filter:</span>
        <a href="{{ route('client.bookings.index') }}"
           class="filter-chip {{ !request('status') ? 'active' : '' }}">All</a>
        @foreach([
            'pending'    => 'Pending',
            'approved'   => 'Approved',
            'assigned'   => 'Assigned',
            'in_transit' => 'In Transit',
            'completed'  => 'Completed',
            'cancelled'  => 'Cancelled',
        ] as $val => $label)
            <a href="{{ route('client.bookings.index', ['status' => $val]) }}"
               class="filter-chip {{ request('status') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($bookings->isEmpty())

        {{-- ── EMPTY STATE ──────────────────────── --}}
        <div class="empty-state">
            <div class="empty-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <p style="font-size:15px; font-weight:700; color:#475569; margin-bottom:4px;">
                {{ request('status') ? 'No ' . ucfirst(str_replace('_',' ',request('status'))) . ' bookings' : 'No bookings yet' }}
            </p>
            <p style="font-size:13px; color:#94a3b8; margin-bottom:20px;">
                {{ request('status') ? 'Try a different filter or create a new booking.' : 'Your trips will appear here once you book.' }}
            </p>
            <a href="{{ route('client.bookings.create') }}" class="btn-primary"
               style="display:inline-flex; align-items:center; gap:7px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8"  y1="12" x2="16" y2="12"/>
                </svg>
                Book your first ride
            </a>
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
                        <th>Service</th>
                        <th>Pickup</th>
                        <th>Scheduled</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th style="text-align:right;">Actions</th>
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
                        <td style="font-weight:600; color:#1e293b; white-space:nowrap;">
                            {{ $b->serviceType->name }}
                        </td>
                        <td>
                            <span style="display:block; white-space:nowrap; overflow:hidden;
                                         text-overflow:ellipsis; max-width:180px; font-size:13px;
                                         color:#64748b;" title="{{ $b->pickup_address }}">
                                {{ $b->pickup_address }}
                            </span>
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
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    Paid
                                </span>
                            @else
                                <span style="display:inline-flex; align-items:center; gap:4px;
                                             font-size:12.5px; font-weight:500; color:#94a3b8;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8"  x2="12"   y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    Unpaid
                                </span>
                            @endif
                        </td>
                        <td style="text-align:right; white-space:nowrap;">
                            <a href="{{ route('client.bookings.show', $b) }}"
                               class="action-link action-view">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View
                            </a>
                            @if($b->is_paid)
                            <a href="{{ route('client.payment.invoice', $b) }}"
                               class="action-link action-invoice" style="margin-left:4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                Invoice
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ════════════════════════════════════════
             MOBILE LIST — hidden on desktop
             Each item is a self-contained div,
             NOT nested inside any shared wrapper.
        ════════════════════════════════════════ --}}
        <div class="mobile-list">
            @foreach($bookings as $b)
            <div style="padding:16px 18px;
                        border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

                {{-- Top row: number + status + amount --}}
                <div style="display:flex; justify-content:space-between;
                             align-items:flex-start; gap:12px; margin-bottom:8px;">
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
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Paid
                            </span>
                        @else
                            <span style="font-size:11px; font-weight:500; color:#94a3b8;
                                         margin-top:3px; display:block;">Unpaid</span>
                        @endif
                    </div>
                </div>

                {{-- Service name --}}
                <p style="font-size:14px; font-weight:700; color:#1e293b; margin-bottom:6px;">
                    {{ $b->serviceType->name }}
                </p>

                {{-- Pickup address --}}
                <div style="display:flex; align-items:center; gap:5px; margin-bottom:4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="#94a3b8" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                        <circle cx="12" cy="10" r="3"/>
                        <path d="M12 2a8 8 0 0 1 8 8c0 5.25-8 13-8 13S4 15.25 4 10a8 8 0 0 1 8-8z"/>
                    </svg>
                    <span style="font-size:12px; color:#64748b; overflow:hidden;
                                 text-overflow:ellipsis; white-space:nowrap; max-width:260px;">
                        {{ $b->pickup_address }}
                    </span>
                </div>

                {{-- Date --}}
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
                        {{ $b->scheduled_at->format('M d, Y · H:i') }}
                    </span>
                </div>

                {{-- Action buttons --}}
                <div style="display:flex; gap:8px;">
                    <a href="{{ route('client.bookings.show', $b) }}"
                       class="action-link action-view"
                       style="flex:1; justify-content:center; padding:8px 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        View Details
                    </a>
                    @if($b->is_paid)
                    <a href="{{ route('client.payment.invoice', $b) }}"
                       class="action-link action-invoice"
                       style="flex:1; justify-content:center; padding:8px 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Invoice
                    </a>
                    @endif
                </div>

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