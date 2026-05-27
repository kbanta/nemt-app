@extends('layouts.app')
@section('title', 'Manage Drivers')
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
    .drivers-card {
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

    .action-approve {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 7px;
        color: #16a34a;
        background: #f0fdf4;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.12s;
        white-space: nowrap;
    }

    .action-approve:hover {
        background: #dcfce7;
    }

    .action-reject {
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

    .action-reject:hover {
        background: #fee2e2;
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

    /* ── Availability dot ────────────────────── */
    .avail-dot {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .avail-dot::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .avail-dot.available {
        color: #16a34a;
    }

    .avail-dot.available::before {
        background: #16a34a;
    }

    .avail-dot.unavailable {
        color: #94a3b8;
    }

    .avail-dot.unavailable::before {
        background: #cbd5e1;
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
        <h2>Manage Drivers</h2>
        <p>Review applications, approve drivers, and monitor availability</p>
    </div>

    {{-- Desktop filter form --}}
    <form method="GET" class="filter-form">
        <a href="{{ route('admin.drivers.create') }}" class="filter-btn"
            style="display:inline-flex; align-items:center; gap:6px; text-decoration:none;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Driver
        </a>
        <div style="position:relative;">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
                <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="filter-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            </svg>
            Filter
        </button>
        @if(request('status'))
        <a href="{{ route('admin.drivers.index') }}"
            style="display:inline-flex; align-items:center; gap:5px; font-size:13px;
                   font-weight:500; color:#64748b; text-decoration:none; padding:8px 12px;
                   border:1.5px solid #e2e8f0; border-radius:9px; transition:all 0.12s;"
            onmouseover="this.style.background='#f1f5f9'"
            onmouseout="this.style.background='transparent'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
            Clear
        </a>
        @endif
    </form>
</div>

{{-- ── MAIN CARD ────────────────────────────────── --}}
<div class="drivers-card">

    {{-- Card header --}}
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4" />
                    <path d="M5.5 21a8.38 8.38 0 0 1 13 0" />
                    <path d="M15 17l2 2 4-4" />
                </svg>
            </div>
            <div>
                <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                    {{ request('status') ? ucfirst(request('status')) . ' Drivers' : 'All Drivers' }}
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $drivers->total() }} driver{{ $drivers->total() != 1 ? 's' : '' }} found
                </p>
            </div>
        </div>
        @if(request('status'))
        <span class="badge" style="background:#eff6ff; color:#2563eb; font-size:11.5px;">
            Filtered: {{ ucfirst(request('status')) }}
        </span>
        @endif
    </div>

    {{-- Mobile chip filter bar --}}
    <div class="chip-bar">
        <a href="{{ route('admin.drivers.index') }}"
            class="status-chip {{ !request('status') ? 'active' : '' }}">All</a>
        @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
        <a href="{{ route('admin.drivers.index', ['status' => $val]) }}"
            class="status-chip {{ request('status') === $val ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @if($drivers->isEmpty())

    {{-- Empty state --}}
    <div class="empty-state">
        <div class="empty-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="7" r="4" />
                <path d="M5.5 21a8.38 8.38 0 0 1 13 0" />
            </svg>
        </div>
        <p style="font-size:15px; font-weight:600; color:#475569; margin-bottom:4px;">
            {{ request('status') ? 'No ' . ucfirst(request('status')) . ' drivers' : 'No drivers found' }}
        </p>
        <p style="font-size:13px; color:#94a3b8;">
            {{ request('status') ? 'Try a different status filter.' : 'Drivers will appear here once they register.' }}
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
                    <th>Driver</th>
                    <th>License #</th>
                    <th>Status</th>
                    <th>Availability</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $d)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                        background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:11px; font-weight:700; color:#fff;">
                                {{ strtoupper(substr($d->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span style="font-size:13px; font-weight:600; color:#1e293b;
                                             display:block; white-space:nowrap;">
                                    {{ $d->user->name }}
                                </span>
                                <span style="font-size:11.5px; color:#94a3b8;">
                                    {{ $d->user->email }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-family:'DM Mono',monospace; font-size:11.5px;
                                     color:#64748b; font-weight:500;">
                            {{ $d->license_number ?? '—' }}
                        </span>
                    </td>
                    <td>
                        @php
                        $statusClass = match($d->status) {
                        'approved' => 'badge-success',
                        'pending' => 'badge-warning',
                        default => 'badge-danger',
                        };
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($d->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="avail-dot {{ $d->is_available ? 'available' : 'unavailable' }}">
                            {{ $d->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                            <a href="{{ route('admin.drivers.show', $d) }}" class="action-view">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                View
                            </a>
                            @if($d->status == 'pending')
                            <form method="POST" action="{{ route('admin.drivers.approve', $d) }}">
                                @csrf
                                <button type="submit" class="action-approve">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.drivers.reject', $d) }}">
                                @csrf
                                <button type="submit" class="action-reject">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                    Reject
                                </button>
                            </form>
                            @endif
                        </div>
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
        @foreach($drivers as $d)
        <div style="padding:16px 18px;
                    border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

            {{-- Row 1: name + status --}}
            <div style="display:flex; justify-content:space-between;
                         align-items:flex-start; gap:10px; margin-bottom:8px;">
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                display:flex; align-items:center; justify-content:center;
                                font-size:11px; font-weight:700; color:#fff;">
                        {{ strtoupper(substr($d->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span style="font-size:13px; font-weight:600; color:#1e293b; display:block;">
                            {{ $d->user->name }}
                        </span>
                        <span style="font-size:11.5px; color:#94a3b8;">
                            {{ $d->user->email }}
                        </span>
                    </div>
                </div>
                @php
                $statusClass = match($d->status) {
                'approved' => 'badge-success',
                'pending' => 'badge-warning',
                default => 'badge-danger',
                };
                @endphp
                <span class="badge {{ $statusClass }}" style="flex-shrink:0;">
                    {{ ucfirst($d->status) }}
                </span>
            </div>

            {{-- Row 2: license --}}
            <div style="display:flex; align-items:center; gap:5px; margin-bottom:5px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                    stroke="#94a3b8" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
                <span style="font-family:'DM Mono',monospace; font-size:12px; color:#64748b;">
                    {{ $d->license_number ?? 'No license on file' }}
                </span>
            </div>

            {{-- Row 3: availability --}}
            <div style="margin-bottom:12px;">
                <span class="avail-dot {{ $d->is_available ? 'available' : 'unavailable' }}">
                    {{ $d->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a href="{{ route('admin.drivers.show', $d) }}"
                    style="flex:1; display:flex; align-items:center; justify-content:center;
                           gap:6px; background:#eff6ff; color:#2563eb; border-radius:8px;
                           padding:9px 12px; font-size:13px; font-weight:600;
                           text-decoration:none; transition:background 0.12s;"
                    onmouseover="this.style.background='#dbeafe'"
                    onmouseout="this.style.background='#eff6ff'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    View
                </a>

                @if($d->status == 'pending')
                <form method="POST" action="{{ route('admin.drivers.approve', $d) }}" style="flex:1;">
                    @csrf
                    <button type="submit"
                        style="width:100%; display:flex; align-items:center; justify-content:center;
                               gap:6px; background:#f0fdf4; color:#16a34a; border-radius:8px;
                               padding:9px 12px; font-size:13px; font-weight:600;
                               border:none; cursor:pointer; font-family:'DM Sans',sans-serif;
                               transition:background 0.12s;"
                        onmouseover="this.style.background='#dcfce7'"
                        onmouseout="this.style.background='#f0fdf4'">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.drivers.reject', $d) }}" style="flex:1;">
                    @csrf
                    <button type="submit"
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
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Reject
                    </button>
                </form>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    @endif

    {{-- Pagination --}}
    @if($drivers->hasPages())
    <div class="pagination-wrap">
        {{ $drivers->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection