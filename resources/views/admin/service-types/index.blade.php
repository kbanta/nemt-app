@extends('layouts.app')
@section('title', 'Service Types')
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

    /* ── Add button ──────────────────────────── */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #2563eb;
        color: #fff;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.25);
        transition: all 0.13s;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-add:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }

    /* ── Main card ───────────────────────────── */
    .service-types-card {
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

    /* ── Action buttons ──────────────────────── */
    .action-edit {
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

    .action-edit:hover {
        background: #dbeafe;
    }

    .action-delete {
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

    .action-delete:hover {
        background: #fee2e2;
    }

    /* ── Price chip ──────────────────────────── */
    .price-val {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .price-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 400;
        margin-left: 2px;
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
        <h2>Service Types</h2>
        <p>Configure transport services, base pricing, and per-mile rates</p>
    </div>

    <a href="{{ route('admin.service-types.create') }}" class="btn-add">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Add Service Type
    </a>
</div>

{{-- ── MAIN CARD ────────────────────────────────── --}}
<div class="service-types-card">

    {{-- Card header --}}
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14" />
                    <path d="M4.93 4.93a10 10 0 0 0 0 14.14" />
                </svg>
            </div>
            <div>
                <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                    All Service Types
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $serviceTypes->count() }} service type{{ $serviceTypes->count() != 1 ? 's' : '' }} configured
                </p>
            </div>
        </div>
    </div>

    @if($serviceTypes->isEmpty())

    {{-- Empty state --}}
    <div class="empty-state">
        <div class="empty-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3" />
                <path d="M19.07 4.93a10 10 0 0 1 0 14.14" />
                <path d="M4.93 4.93a10 10 0 0 0 0 14.14" />
            </svg>
        </div>
        <p style="font-size:15px; font-weight:600; color:#475569; margin-bottom:4px;">
            No service types found
        </p>
        <p style="font-size:13px; color:#94a3b8; margin-bottom:18px;">
            Add your first service type to start accepting bookings.
        </p>
        <a href="{{ route('admin.service-types.create') }}" class="btn-add"
            style="display:inline-flex;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Service Type
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
                    <th>Service Name</th>
                    <th>Pricing Structure</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceTypes as $st)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                        background:#eff6ff;
                                        display:flex; align-items:center; justify-content:center;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="#2563eb" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13" rx="2" />
                                    <path d="M16 8h4l3 5v3h-7V8z" />
                                    <circle cx="5.5" cy="18.5" r="2.5" />
                                    <circle cx="18.5" cy="18.5" r="2.5" />
                                </svg>
                            </div>
                            <span style="font-size:13px; font-weight:600; color:#1e293b;">
                                {{ $st->name }}
                            </span>
                        </div>
                    </td>
                    <td>
                        @if($st->included_miles > 0)
                        <div style="font-size:13px; font-weight:700; color:#0f172a;">
                            ${{ number_format($st->base_price, 2) }}
                            <span style="font-size:11px; font-weight:500; color:#94a3b8;">
                                / first {{ $st->included_miles }} mi
                            </span>
                        </div>
                        <div style="font-size:12px; color:#64748b; margin-top:3px;">
                            then ${{ number_format($st->price_per_mile, 2) }}
                            per {{ $st->condition_miles }} mi block
                        </div>
                        @else
                        <div style="font-size:13px; font-weight:700; color:#0f172a;">
                            ${{ number_format($st->base_price, 2) }}
                            <span style="font-size:11px; font-weight:500; color:#94a3b8;">base</span>
                        </div>
                        <div style="font-size:12px; color:#64748b; margin-top:3px;">
                            + ${{ number_format($st->price_per_mile, 2) }} / mi
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($st->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                            <a href="{{ route('admin.service-types.edit', $st) }}" class="action-edit">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.service-types.destroy', $st) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-delete"
                                    onclick="return confirm('Delete \'{{ $st->name }}\'? This cannot be undone.')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                        <path d="M9 6V4h6v2" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
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
        @foreach($serviceTypes as $st)
        <div style="padding:16px 18px;
                    border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

            {{-- Row 1: name + status --}}
            <div style="display:flex; justify-content:space-between;
                         align-items:center; gap:10px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                background:#eff6ff;
                                display:flex; align-items:center; justify-content:center;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="#2563eb" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13" rx="2" />
                            <path d="M16 8h4l3 5v3h-7V8z" />
                            <circle cx="5.5" cy="18.5" r="2.5" />
                            <circle cx="18.5" cy="18.5" r="2.5" />
                        </svg>
                    </div>
                    <span style="font-size:13.5px; font-weight:700; color:#1e293b;">
                        {{ $st->name }}
                    </span>
                </div>
                @if($st->is_active)
                <span class="badge badge-success" style="flex-shrink:0;">Active</span>
                @else
                <span class="badge badge-danger" style="flex-shrink:0;">Inactive</span>
                @endif
            </div>

            {{-- Row 2: pricing --}}
            <div style="margin-bottom:14px; background:#f8fafc; border:1px solid #e2e8f0;
            border-radius:9px; padding:10px 12px;">
                @if($st->included_miles > 0)
                <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:4px;">
                    ${{ number_format($st->base_price, 2) }}
                    <span style="font-size:11.5px; font-weight:500; color:#94a3b8;">
                        flat for first {{ $st->included_miles }} miles
                    </span>
                </div>
                <div style="display:flex; align-items:center; gap:5px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                    <span style="font-size:12px; color:#64748b;">
                        then ${{ number_format($st->price_per_mile, 2) }}
                        per {{ $st->condition_miles }} mi block after
                    </span>
                </div>
                @else
                <div style="display:flex; gap:16px;">
                    <div>
                        <p style="font-size:11px; color:#94a3b8; font-weight:500; margin-bottom:2px;">Base</p>
                        <p style="font-size:15px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; line-height:1;">
                            ${{ number_format($st->base_price, 2) }}
                        </p>
                    </div>
                    <div style="width:1px; background:#e2e8f0; flex-shrink:0;"></div>
                    <div>
                        <p style="font-size:11px; color:#94a3b8; font-weight:500; margin-bottom:2px;">Per Mile</p>
                        <p style="font-size:15px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; line-height:1;">
                            ${{ number_format($st->price_per_mile, 2) }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:8px;">
                <a href="{{ route('admin.service-types.edit', $st) }}"
                    style="flex:1; display:flex; align-items:center; justify-content:center;
                           gap:6px; background:#eff6ff; color:#2563eb; border-radius:8px;
                           padding:9px 12px; font-size:13px; font-weight:600;
                           text-decoration:none; transition:background 0.12s;"
                    onmouseover="this.style.background='#dbeafe'"
                    onmouseout="this.style.background='#eff6ff'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.service-types.destroy', $st) }}"
                    style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Delete \'{{ $st->name }}\'? This cannot be undone.')"
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
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4h6v2" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

    @endif

    {{-- Pagination (if paginated) --}}
    @if(method_exists($serviceTypes, 'hasPages') && $serviceTypes->hasPages())
    <div class="pagination-wrap">
        {{ $serviceTypes->links() }}
    </div>
    @endif

</div>

@endsection