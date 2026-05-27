@extends('layouts.app')
@section('title', 'Payments')
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
    .payments-card {
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

    .chip-bar::-webkit-scrollbar { display: none; }

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

    /* ── Refund button ───────────────────────── */
    .action-refund {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 7px;
        color: #dc2626;
        background: #fef2f2;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.12s;
        white-space: nowrap;
    }

    .action-refund:hover { background: #fee2e2; }

    /* ── Desktop / mobile toggle ─────────────── */
    .desktop-table { display: block; overflow-x: auto; }
    .mobile-list   { display: none; }

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

    /* ── Payment status badge colours ────────── */
    .badge-refunded {
        background: #faf5ff;
        color: #7c3aed;
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-form { display: none; }
        .chip-bar    { display: flex; }

        .card-header { padding: 12px 16px; }

        .desktop-table { display: none; }
        .mobile-list   { display: block; }

        .pagination-wrap { justify-content: center; }
    }
</style>

{{-- ── PAGE HEADER ──────────────────────────────── --}}
<div class="page-header">
    <div>
        <h2>Payment Records</h2>
        <p>Track transactions, payment statuses, and issue refunds</p>
    </div>

    <form method="GET" class="filter-form">
        <div style="position:relative;">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                @foreach(['paid' => 'Paid', 'refunded' => 'Refunded', 'failed' => 'Failed'] as $val => $label)
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
        @if(request('status'))
        <a href="{{ route('admin.payments.index') }}"
            style="display:inline-flex; align-items:center; gap:5px; font-size:13px;
                   font-weight:500; color:#64748b; text-decoration:none; padding:8px 12px;
                   border:1.5px solid #e2e8f0; border-radius:9px; transition:all 0.12s;"
            onmouseover="this.style.background='#f1f5f9'"
            onmouseout="this.style.background='transparent'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            Clear
        </a>
        @endif
    </form>
</div>

{{-- ── MAIN CARD ────────────────────────────────── --}}
<div class="payments-card">

    {{-- Card header --}}
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
            </div>
            <div>
                <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                    {{ request('status') ? ucfirst(request('status')) . ' Payments' : 'All Payments' }}
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $payments->total() }} record{{ $payments->total() != 1 ? 's' : '' }} found
                </p>
            </div>
        </div>
        @if(request('status'))
        <span class="badge" style="background:#eff6ff; color:#2563eb; font-size:11.5px;">
            Filtered: {{ ucfirst(request('status')) }}
        </span>
        @endif
    </div>

    {{-- Mobile chip bar --}}
    <div class="chip-bar">
        <a href="{{ route('admin.payments.index') }}"
            class="status-chip {{ !request('status') ? 'active' : '' }}">All</a>
        @foreach(['paid' => 'Paid', 'refunded' => 'Refunded', 'failed' => 'Failed'] as $val => $label)
        <a href="{{ route('admin.payments.index', ['status' => $val]) }}"
            class="status-chip {{ request('status') === $val ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @if($payments->isEmpty())

    <div class="empty-state">
        <div class="empty-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                <line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
        </div>
        <p style="font-size:15px; font-weight:600; color:#475569; margin-bottom:4px;">
            {{ request('status') ? 'No ' . ucfirst(request('status')) . ' payments' : 'No payments found' }}
        </p>
        <p style="font-size:13px; color:#94a3b8;">
            {{ request('status') ? 'Try a different status filter.' : 'Payment records will appear here once bookings are paid.' }}
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
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:right;">Amount</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $p)
                @php
                    $statusClass = match($p->status) {
                        'paid'     => 'badge-success',
                        'refunded' => 'badge-refunded',
                        default    => 'badge-danger',
                    };
                @endphp
                <tr>
                    <td>
                        <span style="font-family:'DM Mono',monospace; font-size:11px;
                                     color:#64748b; font-weight:500;">
                            {{ $p->booking->booking_number }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                        background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:11px; font-weight:700; color:#fff;">
                                {{ strtoupper(substr($p->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span style="font-size:13px; font-weight:600; color:#1e293b;
                                             display:block; white-space:nowrap;">
                                    {{ $p->user->name }}
                                </span>
                                <span style="font-size:11.5px; color:#94a3b8;">
                                    {{ $p->user->email }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td style="white-space:nowrap;">
                        <span style="font-size:13px; color:#334155; font-weight:500;">
                            {{ $p->created_at->format('M d, Y') }}
                        </span>
                        <span style="display:block; font-size:11.5px; color:#94a3b8; margin-top:1px;">
                            {{ $p->created_at->format('H:i') }}
                        </span>
                    </td>
                    <td style="text-align:right; white-space:nowrap;">
                        <span style="font-size:15px; font-weight:800; color:#0f172a;
                                     letter-spacing:-0.02em;">
                            ${{ number_format($p->amount, 2) }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        @if($p->status === 'paid')
                        <form method="POST" action="{{ route('admin.payments.refund', $p) }}">
                            @csrf
                            <button type="submit" class="action-refund"
                                onclick="return confirm('Issue a refund for ${{ number_format($p->amount, 2) }}? This cannot be undone.')">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"/>
                                    <path d="M3.51 15a9 9 0 1 0 .49-3.5"/>
                                </svg>
                                Refund
                            </button>
                        </form>
                        @else
                        <span style="font-size:12px; color:#cbd5e1;">—</span>
                        @endif
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
        @foreach($payments as $p)
        @php
            $statusClass = match($p->status) {
                'paid'     => 'badge-success',
                'refunded' => 'badge-refunded',
                default    => 'badge-danger',
            };
        @endphp
        <div style="padding:16px 18px;
                    border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

            {{-- Row 1: booking # + status + amount --}}
            <div style="display:flex; justify-content:space-between;
                         align-items:flex-start; gap:10px; margin-bottom:8px;">
                <div style="display:flex; align-items:center; gap:7px; flex-wrap:wrap;">
                    <span style="font-family:'DM Mono',monospace; font-size:10.5px;
                                 color:#64748b; font-weight:600;">
                        {{ $p->booking->booking_number }}
                    </span>
                    <span class="badge {{ $statusClass }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
                <p style="font-size:17px; font-weight:800; color:#0f172a;
                           letter-spacing:-0.02em; line-height:1; flex-shrink:0;">
                    ${{ number_format($p->amount, 2) }}
                </p>
            </div>

            {{-- Row 2: client --}}
            <div style="display:flex; align-items:center; gap:7px; margin-bottom:5px;">
                <div style="width:24px; height:24px; border-radius:6px; flex-shrink:0;
                            background:linear-gradient(135deg,#3b82f6,#6d28d9);
                            display:flex; align-items:center; justify-content:center;
                            font-size:10px; font-weight:700; color:#fff;">
                    {{ strtoupper(substr($p->user->name, 0, 1)) }}
                </div>
                <span style="font-size:13px; font-weight:600; color:#1e293b;">
                    {{ $p->user->name }}
                </span>
            </div>

            {{-- Row 3: date --}}
            <div style="display:flex; align-items:center; gap:5px; margin-bottom:12px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                    stroke="#94a3b8" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span style="font-size:12px; color:#64748b;">
                    {{ $p->created_at->format('M d, Y · H:i') }}
                </span>
            </div>

            {{-- Refund button (paid only) --}}
            @if($p->status === 'paid')
            <form method="POST" action="{{ route('admin.payments.refund', $p) }}">
                @csrf
                <button type="submit"
                    onclick="return confirm('Issue a refund for ${{ number_format($p->amount, 2) }}? This cannot be undone.')"
                    style="width:100%; display:flex; align-items:center; justify-content:center;
                           gap:6px; background:#fef2f2; color:#dc2626; border-radius:8px;
                           padding:9px 12px; font-size:13px; font-weight:600;
                           border:none; cursor:pointer; font-family:'DM Sans',sans-serif;
                           transition:background 0.12s;"
                    onmouseover="this.style.background='#fee2e2'"
                    onmouseout="this.style.background='#fef2f2'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10"/>
                        <path d="M3.51 15a9 9 0 1 0 .49-3.5"/>
                    </svg>
                    Issue Refund
                </button>
            </form>
            @endif

        </div>
        @endforeach
    </div>

    @endif

    {{-- Pagination --}}
    @if($payments->hasPages())
    <div class="pagination-wrap">
        {{ $payments->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection