@extends('layouts.app')
@section('title', 'Users')
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

    .search-wrap {
        position: relative;
    }

    .search-wrap svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .search-input {
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 8px 12px 8px 32px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        background: #fff;
        outline: none;
        width: 200px;
        font-family: 'DM Sans', sans-serif;
        transition: border-color 0.13s, box-shadow 0.13s;
    }

    .search-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .users-card {
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

    .desktop-table {
        display: block;
        overflow-x: auto;
    }

    .mobile-list {
        display: none;
    }

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

    .pagination-wrap {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    .active-dot {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .active-dot::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .active-dot.yes {
        color: #16a34a;
    }

    .active-dot.yes::before {
        background: #16a34a;
    }

    .active-dot.no {
        color: #94a3b8;
    }

    .active-dot.no::before {
        background: #cbd5e1;
    }

    .role-admin {
        background: #faf5ff;
        color: #7c3aed;
    }

    .role-driver {
        background: #eff6ff;
        color: #2563eb;
    }

    .role-client {
        background: #f0fdf4;
        color: #16a34a;
    }

    .role-other {
        background: #f8fafc;
        color: #64748b;
    }

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
        <h2>All Users</h2>
        <p>View and manage all registered accounts across every role</p>
    </div>

    <form method="GET" class="filter-form">
        <a href="{{ route('admin.users.create') }}" class="filter-btn"
            style="text-decoration:none;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add User
        </a>
        {{-- Search --}}
        <div class="search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" name="search" class="search-input"
                placeholder="Name or email…"
                value="{{ request('search') }}">
        </div>

        {{-- Role filter --}}
        <select name="role" class="filter-select">
            <option value="">All Roles</option>
            @foreach(['admin' => 'Admin', 'driver' => 'Driver', 'client' => 'Client'] as $val => $label)
            <option value="{{ $val }}" {{ request('role') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="filter-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            </svg>
            Filter
        </button>

        @if(request('role') || request('search'))
        <a href="{{ route('admin.users.index') }}"
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
<div class="users-card">

    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div>
                <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                    {{ request('role') ? ucfirst(request('role')).' Users' : 'All Users' }}
                </p>
                <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                    {{ $users->total() }} user{{ $users->total() != 1 ? 's' : '' }} found
                </p>
            </div>
        </div>
        @if(request('role') || request('search'))
        <span class="badge" style="background:#eff6ff; color:#2563eb; font-size:11.5px;">
            {{ request('search') ? 'Search: '.request('search') : 'Role: '.ucfirst(request('role')) }}
        </span>
        @endif
    </div>

    {{-- Mobile chip bar --}}
    <div class="chip-bar">
        <a href="{{ route('admin.users.index') }}"
            class="status-chip {{ !request('role') ? 'active' : '' }}">All</a>
        @foreach(['admin' => 'Admin', 'driver' => 'Driver', 'client' => 'Client'] as $val => $label)
        <a href="{{ route('admin.users.index', ['role' => $val]) }}"
            class="status-chip {{ request('role') === $val ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    @if($users->isEmpty())
    <div class="empty-state">
        <div class="empty-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
            </svg>
        </div>
        <p style="font-size:15px; font-weight:600; color:#475569; margin-bottom:4px;">No users found</p>
        <p style="font-size:13px; color:#94a3b8;">Try adjusting your search or filter.</p>
    </div>
    @else

    {{-- DESKTOP TABLE --}}
    <div class="desktop-table">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                @php
                $roleClass = match($u->role) {
                'admin' => 'role-admin',
                'driver' => 'role-driver',
                'client' => 'role-client',
                default => 'role-other',
                };
                @endphp
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                        background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:11px; font-weight:700; color:#fff;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <span style="font-size:13px; font-weight:600; color:#1e293b; display:block; white-space:nowrap;">
                                    {{ $u->name }}
                                </span>
                                <span style="font-size:11.5px; color:#94a3b8;">{{ $u->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge {{ $roleClass }}">{{ ucfirst($u->role) }}</span></td>
                    <td>
                        <span class="active-dot {{ $u->is_active ? 'yes' : 'no' }}">
                            {{ $u->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td style="white-space:nowrap; font-size:13px; color:#334155; font-weight:500;">
                        {{ $u->created_at->format('M d, Y') }}
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                            <a href="{{ route('admin.users.show', $u) }}" class="action-view">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                View
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE LIST --}}
    <div class="mobile-list">
        @foreach($users as $u)
        @php
        $roleClass = match($u->role) {
        'admin' => 'role-admin',
        'driver' => 'role-driver',
        'client' => 'role-client',
        default => 'role-other',
        };
        @endphp
        <div style="padding:16px 18px; border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px; margin-bottom:8px;">
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:28px; height:28px; border-radius:8px; flex-shrink:0;
                                background:linear-gradient(135deg,#3b82f6,#6d28d9);
                                display:flex; align-items:center; justify-content:center;
                                font-size:11px; font-weight:700; color:#fff;">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div>
                        <span style="font-size:13px; font-weight:600; color:#1e293b; display:block;">{{ $u->name }}</span>
                        <span style="font-size:11.5px; color:#94a3b8;">{{ $u->email }}</span>
                    </div>
                </div>
                <span class="badge {{ $roleClass }}" style="flex-shrink:0;">{{ ucfirst($u->role) }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <span class="active-dot {{ $u->is_active ? 'yes' : 'no' }}">
                        {{ $u->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <span style="font-size:12px; color:#64748b;">{{ $u->created_at->format('M d, Y') }}</span>
                </div>
                <a href="{{ route('admin.users.show', $u) }}" class="action-view">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    View
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @endif

    @if($users->hasPages())
    <div class="pagination-wrap">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection