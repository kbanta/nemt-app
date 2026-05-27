<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} · @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,700;1,9..144,300&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body, * { font-family: 'DM Sans', sans-serif; }
        code, .font-mono { font-family: 'DM Mono', monospace; }

        :root {
            --sidebar-w:        248px;
            --sidebar-w-mini:   68px;
            --sidebar-bg:       #08111f;
            --sidebar-border:   rgba(255,255,255,0.055);
            --sidebar-hover:    rgba(255,255,255,0.055);
            --sidebar-active:   rgba(255,255,255,0.08);
            --sidebar-accent:   #3b82f6;
            --nav-text:         rgba(255,255,255,0.5);
            --nav-text-hover:   rgba(255,255,255,0.88);
            --nav-label:        rgba(255,255,255,0.2);
            --bg:               #eef2f7;
            --surface:          #ffffff;
            --border:           rgba(0,0,0,0.07);
            --blue:             #2563eb;
            --blue-lt:          #eff6ff;
            --muted:            #64748b;
            --text:             #0f172a;
            --radius-sm:        8px;
            --radius-md:        12px;
            --radius-lg:        16px;
            --topbar-h:         60px;
        }

        html, body { height: 100%; margin: 0; padding: 0; }
        body { background: var(--bg); -webkit-font-smoothing: antialiased; }

        /* ── SHELL ───────────────────────────────── */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: relative;
            border-right: 1px solid var(--sidebar-border);
            transition: width 0.22s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            z-index: 30;
        }

        /* Collapsed state (desktop) */
        .sidebar.is-collapsed {
            width: var(--sidebar-w-mini);
        }

        /* ── Sidebar logo row ────────────────────── */
        .sidebar-logo-row {
            padding: 0 14px;
            height: 60px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .sidebar-logo-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }
        .logo-mark {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .logo-texts {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.15s, width 0.22s;
        }
        .logo-name {
            font-family: 'Fraunces', serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .logo-role {
            font-size: 10px;
            font-weight: 500;
            color: var(--nav-label);
            letter-spacing: 0.02em;
        }

        /* Collapse toggle button */
        .collapse-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.25);
            flex-shrink: 0;
            transition: background 0.12s, color 0.12s;
        }
        .collapse-btn:hover {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
        }

        /* ── Sidebar nav ─────────────────────────── */
        .sidebar-nav {
            flex: 1;
            padding: 12px 8px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar-nav::-webkit-scrollbar { width: 0; }

        .nav-section { margin-bottom: 4px; }

        .nav-label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.11em;
            color: var(--nav-label);
            padding: 10px 10px 5px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.15s;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            color: var(--nav-text);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.12s, color 0.12s;
            margin-bottom: 1px;
            position: relative;
            white-space: nowrap;
        }
        .nav-item:hover {
            background: var(--sidebar-hover);
            color: var(--nav-text-hover);
        }
        .nav-item.active {
            background: var(--sidebar-active);
            color: #fff;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 6px; bottom: 6px;
            width: 3px;
            background: var(--sidebar-accent);
            border-radius: 0 3px 3px 0;
        }
        .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.12s;
        }
        .nav-item.active .nav-icon  { background: rgba(59,130,246,0.18); }
        .nav-item:hover .nav-icon   { background: rgba(255,255,255,0.08); }

        .nav-text { overflow: hidden; transition: opacity 0.15s; }

        /* Tooltip for collapsed state */
        .nav-item .nav-tooltip {
            display: none;
            position: absolute;
            left: calc(var(--sidebar-w-mini) - 4px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 7px;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 100;
        }

        /* ── Sidebar footer ──────────────────────── */
        .sidebar-footer {
            padding: 10px 8px;
            border-top: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }
        .user-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            background: rgba(255,255,255,0.04);
            border-radius: var(--radius-md);
            overflow: hidden;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg,#3b82f6,#6d28d9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }
        .user-texts {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            transition: opacity 0.15s;
        }
        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.88);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-role {
            font-size: 10.5px;
            color: var(--nav-label);
            margin-top: 1px;
        }
        .logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 7px;
            color: rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.12s, color 0.12s;
            flex-shrink: 0;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.12); color: #f87171; }

        /* ── Collapsed sidebar styles ────────────── */
        .sidebar.is-collapsed .logo-texts,
        .sidebar.is-collapsed .nav-label,
        .sidebar.is-collapsed .nav-text,
        .sidebar.is-collapsed .user-texts,
        .sidebar.is-collapsed .logout-btn {
            opacity: 0;
            pointer-events: none;
            width: 0;
            overflow: hidden;
        }
        .sidebar.is-collapsed .nav-item {
            justify-content: center;
            padding: 9px 0;
        }
        .sidebar.is-collapsed .nav-item.active::before { display: none; }
        .sidebar.is-collapsed .user-row { justify-content: center; }
        .sidebar.is-collapsed .sidebar-logo-link { flex: 0; }
        .sidebar.is-collapsed .collapse-btn { margin-left: 0; }
        .sidebar.is-collapsed .sidebar-logo-row { justify-content: center; padding: 0; }

        /* Show tooltips only when collapsed on desktop */
        .sidebar.is-collapsed .nav-item:hover .nav-tooltip {
            display: block;
        }

        /* ── MAIN AREA ───────────────────────────── */
        .main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        /* ── TOP BAR ─────────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            height: var(--topbar-h);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 20;
            flex-shrink: 0;
        }
        .topbar-left  { display: flex; align-items: center; gap: 12px; }
        .topbar-right { display: flex; align-items: center; gap: 8px; }

        .topbar-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 7px;
            border-radius: var(--radius-sm);
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.12s;
        }
        .topbar-icon-btn:hover { background: #f1f5f9; }

        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg,#3b82f6,#6d28d9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: #fff;
        }

        /* ── PAGE BODY ───────────────────────────── */
        .page-body {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px;
        }

        /* ── MOBILE OVERLAY ──────────────────────── */
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 29;
        }
        .mobile-overlay.open { display: block; }

        /* ── MOBILE: sidebar as drawer ───────────── */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0; left: 0;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.22s cubic-bezier(0.4,0,0.2,1), width 0.22s;
                width: var(--sidebar-w) !important; /* always full width on mobile */
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            /* On mobile, never collapse — always show full labels */
            .sidebar .logo-texts,
            .sidebar .nav-label,
            .sidebar .nav-text,
            .sidebar .user-texts,
            .sidebar .logout-btn {
                opacity: 1 !important;
                pointer-events: auto !important;
                width: auto !important;
            }
            .sidebar .nav-item { justify-content: flex-start !important; padding: 9px 10px !important; }
            .sidebar .nav-item.active::before { display: block !important; }
            .sidebar .user-row { justify-content: flex-start !important; }
            .sidebar .sidebar-logo-row { justify-content: flex-start !important; padding: 0 14px !important; }
            .sidebar .sidebar-logo-link { flex: 1 !important; }
            /* Hide desktop collapse btn on mobile */
            .collapse-btn.desktop-only { display: none; }
            .page-body { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
        }

        /* ── ALERTS ──────────────────────────────── */
        .alert {
            display: flex; align-items: center; gap: 10px;
            padding: 13px 16px; border-radius: var(--radius-md);
            font-size: 13.5px; font-weight: 500; margin-bottom: 20px;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        /* ── CARDS ───────────────────────────────── */
        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }
        .stat-card {
            background: var(--surface); border-radius: var(--radius-lg);
            border: 1px solid var(--border); padding: 22px 24px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.07); }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }

        /* ── BADGES ──────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 999px;
            font-size: 11.5px; font-weight: 600; letter-spacing: 0.01em;
        }

        /* ── DATA TABLE ──────────────────────────── */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            font-size: 10.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.07em; color: #94a3b8;
            padding: 11px 16px; text-align: left;
            background: #f8fafc; border-bottom: 1px solid #e2e8f0;
        }
        .data-table td {
            padding: 13px 16px; border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px; color: #334155;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #f8fafc; }

        /* ── BUTTONS ─────────────────────────────── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--blue); color: #fff;
            padding: 9px 18px; border-radius: 9px;
            font-size: 13px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.13s; box-shadow: 0 1px 3px rgba(37,99,235,0.25);
        }
        .btn-primary:hover { background: #1d4ed8; box-shadow: 0 4px 14px rgba(37,99,235,0.3); transform: translateY(-1px); }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 6px;
            background: transparent; color: var(--muted);
            padding: 9px 16px; border-radius: 9px;
            font-size: 13px; font-weight: 500; text-decoration: none;
            cursor: pointer; border: 1px solid #e2e8f0; transition: all 0.13s;
        }
        .btn-ghost:hover { background: #f1f5f9; color: #334155; border-color: #cbd5e1; }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 7px; }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fef2f2; color: #dc2626;
            padding: 9px 16px; border-radius: 9px;
            font-size: 13px; font-weight: 600; text-decoration: none;
            border: 1px solid #fecaca; cursor: pointer; transition: all 0.13s;
        }
        .btn-danger:hover { background: #fee2e2; border-color: #fca5a5; }

        /* ── FORM ────────────────────────────────── */
        .form-input {
            width: 100%; border: 1.5px solid #e2e8f0; border-radius: 9px;
            padding: 10px 13px; font-size: 13.5px; color: #1e293b;
            background: #fff; outline: none;
            transition: border-color 0.13s, box-shadow 0.13s;
            font-family: 'DM Sans', sans-serif;
        }
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 5px; }

        .logo-img { height: 36px; width: auto; display: block; }
    </style>
</head>

<body class="h-full">
<div class="app-shell">

    {{-- Mobile overlay --}}
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobile()"></div>

    {{-- ── SIDEBAR ────────────────────────────── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo row --}}
        <div class="sidebar-logo-row">
            <a href="/" class="sidebar-logo-link">
                <div class="logo-mark">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white"
                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h4l3-9 4 18 3-9h4"/>
                    </svg>
                </div>
                <div class="logo-texts">
                    <div class="logo-name">Advocate Transport</div>
                    <div class="logo-role">{{ ucfirst(auth()->user()->role) }} Portal</div>
                </div>
            </a>
            {{-- Desktop collapse button --}}
            <button class="collapse-btn desktop-only" id="collapseBtn"
                title="Collapse sidebar" aria-label="Collapse sidebar">
                <svg id="collapseIcon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 19l-7-7 7-7"/>
                    <path d="M21 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav">

            @if(auth()->user()->isAdmin())
            <div class="nav-section">
                <span class="nav-label">Overview</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                    <span class="nav-tooltip">Dashboard</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">Operations</span>
                <a href="{{ route('admin.bookings.index') }}"
                    class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <span class="nav-text">Bookings</span>
                    <span class="nav-tooltip">Bookings</span>
                </a>
                <a href="{{ route('admin.calendar') }}"
                    class="nav-item {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                    <span class="nav-text">Calendar</span>
                    <span class="nav-tooltip">Calendar</span>
                </a>
                <a href="{{ route('admin.drivers.index') }}"
                    class="nav-item {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a7 7 0 0 1 13 0"/></svg>
                    </span>
                    <span class="nav-text">Drivers</span>
                    <span class="nav-tooltip">Drivers</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <span class="nav-text">Users</span>
                    <span class="nav-tooltip">Users</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">Config</span>
                <a href="{{ route('admin.service-types.index') }}"
                    class="nav-item {{ request()->routeIs('admin.service-types.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    </span>
                    <span class="nav-text">Service Types</span>
                    <span class="nav-tooltip">Service Types</span>
                </a>
                <a href="{{ route('admin.payments.index') }}"
                    class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </span>
                    <span class="nav-text">Payments</span>
                    <span class="nav-tooltip">Payments</span>
                </a>
                @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.settings.index') }}"
                    class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    </span>
                    <span class="nav-text">Settings</span>
                    <span class="nav-tooltip">Settings</span>
                </a>
                @endif
            </div>

            @elseif(auth()->user()->isClient())
            <div class="nav-section">
                <span class="nav-label">My Account</span>
                <a href="{{ route('client.dashboard') }}"
                    class="nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                    <span class="nav-tooltip">Dashboard</span>
                </a>
                <a href="{{ route('client.bookings.index') }}"
                    class="nav-item {{ request()->routeIs('client.bookings.index') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <span class="nav-text">My Bookings</span>
                    <span class="nav-tooltip">My Bookings</span>
                </a>
                <a href="{{ route('client.bookings.create') }}"
                    class="nav-item {{ request()->routeIs('client.bookings.create') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    </span>
                    <span class="nav-text">New Booking</span>
                    <span class="nav-tooltip">New Booking</span>
                </a>
            </div>

            @elseif(auth()->user()->isDriver())
            <div class="nav-section">
                <span class="nav-label">My Work</span>
                <a href="{{ route('driver.dashboard') }}"
                    class="nav-item {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                    <span class="nav-tooltip">Dashboard</span>
                </a>
                <a href="{{ route('driver.trips.index') }}"
                    class="nav-item {{ request()->routeIs('driver.trips.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                    </span>
                    <span class="nav-text">My Trips</span>
                    <span class="nav-tooltip">My Trips</span>
                </a>
            </div>
            @endif

        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <div class="user-row">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-texts">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Sign out">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- ── MAIN ────────────────────────────────── --}}
    <div class="main-wrap">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">

                {{-- Mobile hamburger --}}
                <button class="topbar-icon-btn" id="mobileMenuBtn"
                    aria-label="Open menu" onclick="openMobile()"
                    style="display:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>

                <a href="/">
                    <img src="{{ asset('images/lg-black.png') }}" alt="{{ config('app.name') }}" class="logo-img">
                </a>
            </div>

            <div class="topbar-right">

                {{-- Notification Bell --}}
                <div style="position:relative;" x-data="{ open: false }">
                    <button @click="open = !open" class="topbar-icon-btn" style="position:relative;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        @if($unreadCount > 0)
                        <span style="position:absolute; top:4px; right:4px;
                            background:#ef4444; color:#fff; font-size:9px; font-weight:700;
                            border-radius:999px; min-width:16px; height:16px; padding:0 4px;
                            display:flex; align-items:center; justify-content:center;
                            border:2px solid #fff; line-height:1;">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        style="display:none; position:absolute; right:0; top:calc(100% + 8px);
                            width:320px; background:#fff; border-radius:14px;
                            border:1px solid rgba(0,0,0,0.08);
                            box-shadow:0 8px 30px rgba(0,0,0,0.12); z-index:100; overflow:hidden;">

                        <div style="padding:14px 16px 10px; border-bottom:1px solid #f1f5f9;
                            display:flex; align-items:center; justify-content:space-between;">
                            <span style="font-size:13px; font-weight:700; color:#0f172a;">Notifications</span>
                            @if($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                @csrf @method('PATCH')
                                <button type="submit" style="background:none; border:none; cursor:pointer; font-size:11.5px; font-weight:600; color:#2563eb;">Mark all read</button>
                            </form>
                            @endif
                        </div>

                        <div style="max-height:340px; overflow-y:auto;">
                        @forelse(auth()->user()->unreadNotifications->take(6) as $notif)
                        @php
                            $bookingUrl = '#';
                            if (isset($notif->data['booking_id'])) {
                                $bookingUrl = match(true) {
                                    auth()->user()->isAdmin()  => route('admin.bookings.show', $notif->data['booking_id']),
                                    auth()->user()->isDriver() => route('driver.trips.show',   $notif->data['booking_id']),
                                    default                    => route('client.bookings.show', $notif->data['booking_id']),
                                };
                            }
                        @endphp
                        <a href="{{ $bookingUrl }}"
                            onclick="fetch('{{ route('notifications.markRead', $notif->id) }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}})"
                            style="display:flex; gap:10px; align-items:flex-start; padding:12px 16px;
                                border-bottom:1px solid #f8fafc; background:#fafbff; text-decoration:none;
                                transition:background 0.12s;"
                            onmouseover="this.style.background='#f0f6ff'"
                            onmouseout="this.style.background='#fafbff'">
                            <span style="margin-top:5px; width:7px; height:7px; border-radius:50%; background:#3b82f6; flex-shrink:0;"></span>
                            <div style="flex:1; min-width:0;">
                                <p style="margin:0 0 2px; font-size:12.5px; font-weight:500; color:#1e293b; line-height:1.45;">
                                    {{ $notif->data['message'] }}
                                </p>
                                @if(isset($notif->data['service']))
                                <p style="margin:0 0 3px; font-size:11.5px; color:#64748b;">
                                    {{ $notif->data['service'] }}
                                    @if(isset($notif->data['amount'])) · ${{ number_format($notif->data['amount'], 2) }} @endif
                                </p>
                                @endif
                                <p style="margin:0; font-size:11px; color:#94a3b8;">
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                style="flex-shrink:0; margin-top:3px;">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                        @empty
                        <div style="padding:28px 16px; text-align:center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                style="margin:0 auto 8px; display:block;">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                            </svg>
                            <p style="margin:0; font-size:13px; color:#94a3b8;">You're all caught up!</p>
                        </div>
                        @endforelse
                    </div>

                        <a href="{{ route('notifications.index') }}"
                            style="display:block; text-align:center; padding:11px; font-size:12.5px; font-weight:600; color:#2563eb; border-top:1px solid #f1f5f9; text-decoration:none; transition:background 0.12s;"
                            onmouseover="this.style.background='#eff6ff'"
                            onmouseout="this.style.background='none'">
                            View all notifications →
                        </a>
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="topbar-avatar" title="{{ auth()->user()->name }}">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="page-body">

            @if(session('success'))
            <div class="alert alert-success" role="alert">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error" role="alert">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

<script>
// ── Desktop sidebar collapse ──────────────────
const sidebar     = document.getElementById('sidebar');
const collapseBtn = document.getElementById('collapseBtn');
const collapseIcon = document.getElementById('collapseIcon');

const ICON_COLLAPSE = '<path d="M11 19l-7-7 7-7"/><path d="M21 19l-7-7 7-7"/>';
const ICON_EXPAND   = '<path d="M13 5l7 7-7 7"/><path d="M3 5l7 7-7 7"/>';

// Restore saved state
if (localStorage.getItem('sidebarCollapsed') === 'true' && window.innerWidth > 768) {
    sidebar.classList.add('is-collapsed');
    collapseIcon.innerHTML = ICON_EXPAND;
}

collapseBtn.addEventListener('click', function () {
    if (window.innerWidth <= 768) return; // no collapse on mobile
    const collapsed = sidebar.classList.toggle('is-collapsed');
    collapseIcon.innerHTML = collapsed ? ICON_EXPAND : ICON_COLLAPSE;
    localStorage.setItem('sidebarCollapsed', collapsed);
});

// ── Mobile sidebar ────────────────────────────
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileOverlay = document.getElementById('mobileOverlay');

function openMobile() {
    sidebar.classList.add('mobile-open');
    mobileOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeMobile() {
    sidebar.classList.remove('mobile-open');
    mobileOverlay.classList.remove('open');
    document.body.style.overflow = '';
}

// Show hamburger on mobile
function checkMobile() {
    if (window.innerWidth <= 768) {
        mobileMenuBtn.style.display = 'flex';
        // Make sure sidebar is not collapsed on mobile
        sidebar.classList.remove('is-collapsed');
    } else {
        mobileMenuBtn.style.display = 'none';
        closeMobile();
        // Restore desktop collapsed state
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('is-collapsed');
            collapseIcon.innerHTML = ICON_EXPAND;
        }
    }
}

checkMobile();
window.addEventListener('resize', checkMobile);

// Close mobile sidebar when a nav link is clicked
document.querySelectorAll('.sidebar .nav-item').forEach(function(link) {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) closeMobile();
    });
});

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeMobile();
});
</script>

</body>
</html>