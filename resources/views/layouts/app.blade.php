<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} · @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&family=Fraunces:ital,opsz,wght@0,9..144,700;1,9..144,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="theme-color" content="#0f172a">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#0f172a">
    <style>
    /* ── Reset & Base ───────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }

    :root {
        /* Sidebar */
        --sb-w:         256px;
        --sb-mini:      64px;
        --sb-bg:        #111317;
        --sb-border:    rgba(255,255,255,0.06);
        --sb-hover:     rgba(255,255,255,0.05);
        --sb-active:    rgba(255,255,255,0.09);
        --sb-accent:    #4f7eff;
        --sb-text:      rgba(255,255,255,0.44);
        --sb-text-h:    rgba(255,255,255,0.9);
        --sb-label:     rgba(255,255,255,0.18);

        /* Main */
        --bg:           #f4f5f7;
        --surface:      #ffffff;
        --border:       #e8eaed;
        --text:         #111317;
        --text-2:       #6b7280;
        --blue:         #2f5fe8;
        --blue-lt:      #eef2ff;
        --red:          #e03131;
        --green:        #1a9e6e;
        --r-sm:         6px;
        --r-md:         10px;
        --r-lg:         14px;
    }

    body {
        font-family: 'Instrument Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        -webkit-font-smoothing: antialiased;
    }
    code, .mono { font-family: 'DM Mono', monospace; }

    /* ── Shell ──────────────────────────────── */
    .shell {
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    /* ── Sidebar ────────────────────────────── */
    .sidebar {
        width: var(--sb-w);
        flex-shrink: 0;
        background: var(--sb-bg);
        display: flex;
        flex-direction: column;
        height: 100vh;
        border-right: 1px solid var(--sb-border);
        transition: width 0.2s cubic-bezier(0.4,0,0.2,1);
        overflow: hidden;
        position: relative;
        z-index: 40;
    }
    .sidebar.collapsed { width: var(--sb-mini); }

    /* Subtle top accent line */
    .sidebar::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--sb-accent), #a78bfa);
    }

    /* ── Sidebar header ─────────────────────── */
    .sb-head {
        height: 58px;
        padding: 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid var(--sb-border);
        flex-shrink: 0;
    }
    .sb-logo-link {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }
    .sb-mark {
        width: 32px;
        height: 32px;
        border-radius: var(--r-sm);
        background: var(--sb-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .sb-brand {
        overflow: hidden;
        white-space: nowrap;
    }
    .sb-brand-name {
        font-family: 'Fraunces', serif;
        font-size: 14.5px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.015em;
        line-height: 1.2;
        display: block;
    }
    .sb-brand-role {
        font-size: 10px;
        font-weight: 500;
        color: var(--sb-label);
        letter-spacing: 0.03em;
        display: block;
        margin-top: 1px;
    }
    .sb-collapse {
        width: 26px;
        height: 26px;
        border-radius: 5px;
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.2);
        flex-shrink: 0;
        transition: background 0.12s, color 0.12s;
    }
    .sb-collapse:hover {
        background: rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.65);
    }

    /* ── Sidebar nav ────────────────────────── */
    .sb-nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px 8px;
    }
    .sb-nav::-webkit-scrollbar { width: 0; }

    .sb-section { margin-bottom: 2px; }

    .sb-section-label {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.13em;
        color: var(--sb-label);
        padding: 12px 10px 4px;
        display: block;
        white-space: nowrap;
    }

    .sb-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: var(--r-sm);
        color: var(--sb-text);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.1s, color 0.1s;
        margin-bottom: 1px;
        position: relative;
        white-space: nowrap;
        cursor: pointer;
    }
    .sb-item:hover {
        background: var(--sb-hover);
        color: var(--sb-text-h);
    }
    .sb-item.active {
        background: var(--sb-active);
        color: #fff;
    }
    .sb-item.active::after {
        content: '';
        position: absolute;
        right: 0; top: 7px; bottom: 7px;
        width: 2.5px;
        background: var(--sb-accent);
        border-radius: 2px 0 0 2px;
    }

    .sb-icon {
        width: 28px;
        height: 28px;
        border-radius: 5px;
        background: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.1s;
    }
    .sb-item.active .sb-icon { background: rgba(79,126,255,0.2); }
    .sb-item:hover .sb-icon  { background: rgba(255,255,255,0.07); }

    .sb-label-text { overflow: hidden; }

    /* Tooltip */
    .sb-tooltip {
        display: none;
        position: absolute;
        left: calc(var(--sb-mini) + 6px);
        top: 50%;
        transform: translateY(-50%);
        background: #1e2128;
        color: rgba(255,255,255,0.9);
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
        white-space: nowrap;
        pointer-events: none;
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        z-index: 200;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .sidebar.collapsed .sb-item:hover .sb-tooltip { display: block; }

    /* ── Sidebar footer ─────────────────────── */
    .sb-foot {
        padding: 10px 8px;
        border-top: 1px solid var(--sb-border);
        flex-shrink: 0;
    }
    .sb-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: var(--r-sm);
        background: rgba(255,255,255,0.03);
        overflow: hidden;
        cursor: default;
    }
    .sb-user-av {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        background: linear-gradient(135deg, #2f5fe8, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: 0.02em;
    }
    .sb-user-info {
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }
    .sb-user-name {
        font-size: 12.5px;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sb-user-role {
        font-size: 10px;
        color: var(--sb-label);
        margin-top: 1px;
        text-transform: capitalize;
    }
    .sb-logout {
        background: none;
        border: none;
        cursor: pointer;
        width: 26px;
        height: 26px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.2);
        transition: background 0.12s, color 0.12s;
        flex-shrink: 0;
    }
    .sb-logout:hover {
        background: rgba(239,68,68,0.15);
        color: #f87171;
    }

    /* ── Collapsed sidebar ──────────────────── */
    .sidebar.collapsed .sb-brand,
    .sidebar.collapsed .sb-section-label,
    .sidebar.collapsed .sb-label-text,
    .sidebar.collapsed .sb-user-info,
    .sidebar.collapsed .sb-logout {
        opacity: 0;
        pointer-events: none;
        width: 0;
    }
    .sidebar.collapsed .sb-item {
        justify-content: center;
        padding: 8px 0;
    }
    .sidebar.collapsed .sb-item.active::after { display: none; }
    .sidebar.collapsed .sb-user { justify-content: center; }
    .sidebar.collapsed .sb-logo-link { flex: 0; }
    .sidebar.collapsed .sb-head { justify-content: center; padding: 0; }

    /* ── Main area ──────────────────────────── */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-width: 0;
    }

    /* ── Topbar ─────────────────────────────── */
    .topbar {
        height: 58px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        flex-shrink: 0;
        position: sticky;
        top: 0;
        z-index: 20;
    }
    .topbar-l { display: flex; align-items: center; gap: 12px; }
    .topbar-r { display: flex; align-items: center; gap: 6px; }

    .tb-btn {
        width: 34px;
        height: 34px;
        border-radius: var(--r-sm);
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-2);
        transition: background 0.12s, color 0.12s;
        position: relative;
    }
    .tb-btn:hover { background: var(--bg); color: var(--text); }

    .topbar-logo { height: 32px; width: auto; display: block; }

    /* ── Notification badge ─────────────────── */
    .notif-badge {
        position: absolute;
        top: 3px; right: 3px;
        min-width: 16px;
        height: 16px;
        background: #e03131;
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        border: 2px solid var(--surface);
        line-height: 1;
    }

    /* ── Avatar chip ────────────────────────── */
    .av-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 10px 4px 4px;
        border-radius: var(--r-md);
        border: 1px solid var(--border);
        background: none;
        cursor: pointer;
        transition: background 0.12s, border-color 0.12s;
        font-family: 'Instrument Sans', sans-serif;
    }
    .av-chip:hover { background: var(--bg); border-color: #d1d5db; }

    .av-circle {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: linear-gradient(135deg, #2f5fe8, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .av-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
    }
    .av-sub {
        font-size: 10px;
        color: var(--text-2);
        line-height: 1;
        margin-top: 1px;
    }
    .av-caret {
        color: #9ca3af;
        transition: transform 0.18s;
        flex-shrink: 0;
    }
    .av-chip[aria-expanded="true"] .av-caret { transform: rotate(180deg); }

    /* ── Dropdown shared ────────────────────── */
    .dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: 0 8px 32px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.06);
        z-index: 300;
        overflow: hidden;
    }

    /* Avatar dropdown */
    .av-dropdown { width: 220px; }

    .av-dropdown-head {
        padding: 14px 16px;
        background: #fafafa;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .av-dropdown-av {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: linear-gradient(135deg, #2f5fe8, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .av-dropdown-name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
    }
    .av-dropdown-email {
        font-size: 11px;
        color: var(--text-2);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
        margin-top: 2px;
    }

    .dropdown-body { padding: 6px; }

    .dd-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 10px;
        border-radius: var(--r-sm);
        font-size: 13px;
        font-weight: 500;
        color: var(--text);
        text-decoration: none;
        transition: background 0.1s;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        font-family: 'Instrument Sans', sans-serif;
        text-align: left;
    }
    .dd-item:hover { background: var(--bg); }
    .dd-item-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dd-item.danger { color: #e03131; }
    .dd-item.danger:hover { background: #fef2f2; }

    .dd-sep { height: 1px; background: var(--border); margin: 4px 6px; }

    /* ── Notification dropdown ──────────────── */
    .notif-dropdown { width: 336px; }

    @media (max-width: 768px) {
        .notif-dropdown {
            position: fixed;
            left: 50%;
            right: auto;
            top: 62px;
            transform: translateX(-50%);
            width: calc(100vw - 32px);
            max-width: 336px;
        }
    }

    .notif-head {
        padding: 13px 16px 11px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .notif-head-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }
    .notif-mark-all {
        font-size: 11.5px;
        font-weight: 600;
        color: var(--blue);
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Instrument Sans', sans-serif;
        padding: 0;
    }
    .notif-mark-all:hover { text-decoration: underline; }

    .notif-list { max-height: 340px; overflow-y: auto; }
    .notif-list::-webkit-scrollbar { width: 4px; }
    .notif-list::-webkit-scrollbar-track { background: transparent; }
    .notif-list::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 2px; }

    .notif-item {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        padding: 11px 16px;
        border-bottom: 1px solid #f9fafb;
        text-decoration: none;
        transition: background 0.1s;
        cursor: pointer;
    }
    .notif-item:hover { background: #f9fafb; }
    .notif-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--blue);
        flex-shrink: 0;
        margin-top: 5px;
    }
    .notif-msg {
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text);
        line-height: 1.45;
        margin-bottom: 2px;
    }
    .notif-sub {
        font-size: 11.5px;
        color: var(--text-2);
        margin-bottom: 2px;
    }
    .notif-time { font-size: 11px; color: #9ca3af; }

    .notif-empty {
        padding: 32px 16px;
        text-align: center;
    }
    .notif-empty p { font-size: 13px; color: #9ca3af; margin-top: 10px; }

    .notif-footer {
        display: block;
        text-align: center;
        padding: 10px;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--blue);
        border-top: 1px solid var(--border);
        text-decoration: none;
        transition: background 0.1s;
    }
    .notif-footer:hover { background: var(--blue-lt); }

    /* ── Page body ──────────────────────────── */
    .page-body {
        flex: 1;
        overflow-y: auto;
        padding: 28px 32px;
    }

    /* ── Alerts ─────────────────────────────── */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 16px;
        border-radius: var(--r-md);
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .alert svg { flex-shrink: 0; margin-top: 1px; }
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
    }
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    /* ── Shared UI ──────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
    }
    .stat-card {
        background: var(--surface);
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
        padding: 22px 24px;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.07);
    }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #9ca3af;
        padding: 10px 16px;
        text-align: left;
        background: #f9fafb;
        border-bottom: 1px solid var(--border);
    }
    .data-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13.5px;
        color: #374151;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: #fafafa; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--blue); color: #fff;
        padding: 8px 18px; border-radius: var(--r-sm);
        font-size: 13px; font-weight: 600;
        text-decoration: none; border: none; cursor: pointer;
        transition: all 0.13s; font-family: 'Instrument Sans', sans-serif;
        box-shadow: 0 1px 3px rgba(47,95,232,0.25);
    }
    .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }
    .btn-ghost {
        display: inline-flex; align-items: center; gap: 6px;
        background: transparent; color: var(--text-2);
        padding: 8px 16px; border-radius: var(--r-sm);
        font-size: 13px; font-weight: 500; text-decoration: none;
        cursor: pointer; border: 1px solid var(--border);
        transition: all 0.13s; font-family: 'Instrument Sans', sans-serif;
    }
    .btn-ghost:hover { background: var(--bg); color: var(--text); }
    .btn-sm { padding: 5px 12px; font-size: 12px; }
    .btn-danger {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fef2f2; color: var(--red);
        padding: 8px 16px; border-radius: var(--r-sm);
        font-size: 13px; font-weight: 600; text-decoration: none;
        border: 1px solid #fecaca; cursor: pointer;
        transition: all 0.13s; font-family: 'Instrument Sans', sans-serif;
    }
    .btn-danger:hover { background: #fee2e2; }
    .form-input {
        width: 100%; border: 1.5px solid var(--border); border-radius: var(--r-sm);
        padding: 9px 12px; font-size: 13.5px; color: var(--text);
        background: #fff; outline: none;
        transition: border-color 0.13s, box-shadow 0.13s;
        font-family: 'Instrument Sans', sans-serif;
    }
    .form-input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(47,95,232,0.1);
    }
    .form-label {
        display: block;
        font-size: 12px; font-weight: 600;
        color: #4b5563; margin-bottom: 5px;
    }

    /* ── Mobile overlay ─────────────────────── */
    .mob-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 35;
        backdrop-filter: blur(2px);
    }
    .mob-overlay.open { display: block; }

    /* ── Mobile ─────────────────────────────── */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.22s cubic-bezier(0.4,0,0.2,1);
            width: var(--sb-w) !important;
        }
        .sidebar.mob-open { transform: translateX(0); }
        /* Always show labels on mobile */
        .sidebar .sb-brand,
        .sidebar .sb-section-label,
        .sidebar .sb-label-text,
        .sidebar .sb-user-info,
        .sidebar .sb-logout {
            opacity: 1 !important;
            pointer-events: auto !important;
            width: auto !important;
        }
        .sidebar .sb-item { justify-content: flex-start !important; padding: 8px 10px !important; }
        .sidebar .sb-item.active::after { display: block !important; }
        .sidebar .sb-user { justify-content: flex-start !important; }
        .sidebar .sb-head { justify-content: flex-start !important; padding: 0 16px !important; }
        .sidebar .sb-logo-link { flex: 1 !important; }
        .sb-collapse { display: none !important; }
        .page-body { padding: 20px 16px; }
        .topbar { padding: 0 16px; }
        .mob-menu-btn { display: flex !important; }
        .av-name, .av-sub { display: none; }
    }

    .mob-menu-btn { display: none; }
    </style>
</head>

<body class="h-full">
<div class="shell">

    {{-- Mobile overlay --}}
    <div class="mob-overlay" id="mobOverlay" onclick="closeMob()"></div>

    {{-- ── SIDEBAR ──────────────────────────── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Head --}}
        <div class="sb-head">
            <a href="/" class="sb-logo-link">
                <div class="sb-mark">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h4l3-9 4 18 3-9h4"/>
                    </svg>
                </div>
                <div class="sb-brand">
                    <!-- <span class="sb-brand-name">{{ config('app.name') }}</span> -->
                    <span class="sb-brand-name">Company Name</span>
                    <span class="sb-brand-role">{{ ucfirst(auth()->user()->role) }} Portal</span>
                </div>
            </a>
            <button class="sb-collapse" id="sbCollapseBtn" title="Toggle sidebar">
                <svg id="sbCollapseIcon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 19l-7-7 7-7"/>
                    <path d="M21 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="sb-nav">

            @if(auth()->user()->isAdmin())

            <div class="sb-section">
                <span class="sb-section-label">Overview</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </span>
                    <span class="sb-label-text">Dashboard</span>
                    <span class="sb-tooltip">Dashboard</span>
                </a>
            </div>

            <div class="sb-section">
                <span class="sb-section-label">Operations</span>
                <a href="{{ route('admin.bookings.index') }}"
                    class="sb-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <span class="sb-label-text">Bookings</span>
                    <span class="sb-tooltip">Bookings</span>
                </a>
                <a href="{{ route('admin.calendar') }}"
                    class="sb-item {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                    <span class="sb-label-text">Calendar</span>
                    <span class="sb-tooltip">Calendar</span>
                </a>
                <a href="{{ route('admin.drivers.index') }}"
                    class="sb-item {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a7 7 0 0 1 13 0"/></svg>
                    </span>
                    <span class="sb-label-text">Drivers</span>
                    <span class="sb-tooltip">Drivers</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="sb-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <span class="sb-label-text">Users</span>
                    <span class="sb-tooltip">Users</span>
                </a>
            </div>

            <div class="sb-section">
                <span class="sb-section-label">Config</span>
                <a href="{{ route('admin.service-types.index') }}"
                    class="sb-item {{ request()->routeIs('admin.service-types.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    </span>
                    <span class="sb-label-text">Service Types</span>
                    <span class="sb-tooltip">Service Types</span>
                </a>
                <a href="{{ route('admin.payments.index') }}"
                    class="sb-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </span>
                    <span class="sb-label-text">Payments</span>
                    <span class="sb-tooltip">Payments</span>
                </a>
                @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.settings.index') }}"
                    class="sb-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    </span>
                    <span class="sb-label-text">Settings</span>
                    <span class="sb-tooltip">Settings</span>
                </a>
                @endif
            </div>

            @elseif(auth()->user()->isClient())

            <div class="sb-section">
                <span class="sb-section-label">My Account</span>
                <a href="{{ route('client.dashboard') }}"
                    class="sb-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    <span class="sb-label-text">Dashboard</span>
                    <span class="sb-tooltip">Dashboard</span>
                </a>
                <a href="{{ route('client.bookings.index') }}"
                    class="sb-item {{ request()->routeIs('client.bookings.index') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <span class="sb-label-text">My Bookings</span>
                    <span class="sb-tooltip">My Bookings</span>
                </a>
                <a href="{{ route('client.bookings.create') }}"
                    class="sb-item {{ request()->routeIs('client.bookings.create') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    </span>
                    <span class="sb-label-text">New Booking</span>
                    <span class="sb-tooltip">New Booking</span>
                </a>
            </div>

            @elseif(auth()->user()->isDriver())

            <div class="sb-section">
                <span class="sb-section-label">My Work</span>
                <a href="{{ route('driver.dashboard') }}"
                    class="sb-item {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    <span class="sb-label-text">Dashboard</span>
                    <span class="sb-tooltip">Dashboard</span>
                </a>
                <a href="{{ route('driver.trips.index') }}"
                    class="sb-item {{ request()->routeIs('driver.trips.*') ? 'active' : '' }}">
                    <span class="sb-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                    </span>
                    <span class="sb-label-text">My Trips</span>
                    <span class="sb-tooltip">My Trips</span>
                </a>
            </div>

            @endif

        </nav>

        {{-- Footer --}}
        <div class="sb-foot">
            <div class="sb-user">
                <div class="sb-user-av">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="sb-user-info">
                    <div class="sb-user-name">{{ auth()->user()->name }}</div>
                    <div class="sb-user-role">{{ auth()->user()->role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="sb-logout" title="Sign out">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- ── MAIN ──────────────────────────────── --}}
    <div class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-l">

                {{-- Mobile hamburger --}}
                <button class="tb-btn mob-menu-btn" id="mobMenuBtn"
                    onclick="openMob()" aria-label="Menu">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>

                <a href="/">
                    @if(file_exists(public_path('images/lg-blacks.png')))
                        <img src="{{ asset('images/lg-black.png') }}"
                            alt="{{ config('app.name') }}"
                            class="topbar-logo">
                    @else
                        <div class="topbar-logo-placeholder">
                            Your Logo Here
                        </div>
                    @endif
                </a>
            </div>

            <div class="topbar-r">

                {{-- Notification bell --}}
                <div style="position:relative;" x-data="{ open: false }">
                    <button class="tb-btn" id="notif-bell" @click="open = !open" aria-label="Notifications">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                        @if($unread > 0)
                        <span class="notif-badge">{{ $unread > 9 ? '9+' : $unread }}</span>
                        @endif
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        style="display:none;"
                        class="dropdown notif-dropdown">

                        <div class="notif-head">
                            <span class="notif-head-title">Notifications</span>
                            @if($unread > 0)
                            <form method="POST" action="{{ route('notifications.markAllRead') }}" style="margin:0;">
                                @csrf @method('PATCH')
                                <button type="submit" class="notif-mark-all">Mark all read</button>
                            </form>
                            @endif
                        </div>

                        <div class="notif-list" id="notif-list">
                            @forelse(auth()->user()->unreadNotifications->take(6) as $notif)
                            @php
                                $nUrl = '#';
                                if (isset($notif->data['booking_id'])) {
                                    $nUrl = match(true) {
                                        auth()->user()->isAdmin()  => route('admin.bookings.show', $notif->data['booking_id']),
                                        auth()->user()->isDriver() => route('driver.trips.show',   $notif->data['booking_id']),
                                        default                    => route('client.bookings.show', $notif->data['booking_id']),
                                    };
                                }
                            @endphp
                            <a href="{{ $nUrl }}" class="notif-item"
                                onclick="fetch('{{ route('notifications.markRead', $notif->id) }}',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}})">
                                <span class="notif-dot"></span>
                                <div style="flex:1; min-width:0;">
                                    <p class="notif-msg">{{ $notif->data['message'] }}</p>
                                    @if(isset($notif->data['service']))
                                    <p class="notif-sub">
                                        {{ $notif->data['service'] }}
                                        @if(isset($notif->data['amount'])) · ${{ number_format($notif->data['amount'],2) }} @endif
                                    </p>
                                    @endif
                                    <p class="notif-time">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="#d1d5db" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    style="flex-shrink:0; margin-top:4px;">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                            @empty
                            <div class="notif-empty" id="notif-empty">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="#d1d5db" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    style="margin:0 auto; display:block;">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                </svg>
                                <p>You're all caught up!</p>
                            </div>
                            @endforelse
                        </div>

                        <a href="{{ route('notifications.index') }}" class="notif-footer">
                            View all notifications →
                        </a>
                    </div>
                </div>

                {{-- Avatar dropdown --}}
                <div style="position:relative;">
                    <button class="av-chip" id="avBtn"
                        onclick="toggleAv()" aria-expanded="false">
                        <div class="av-circle">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="av-name">{{ explode(' ', auth()->user()->name)[0] }}</div>
                            <div class="av-sub">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <svg class="av-caret" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>

                    <div id="avDropdown" class="dropdown av-dropdown" style="display:none;">

                        <div class="av-dropdown-head">
                            <div class="av-dropdown-av">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div style="min-width:0;">
                                <div class="av-dropdown-name">{{ auth()->user()->name }}</div>
                                <div class="av-dropdown-email">{{ auth()->user()->email }}</div>
                            </div>
                        </div>

                        <div class="dropdown-body">
                            <a href="{{ route('profile.edit') }}" class="dd-item">
                                <span class="dd-item-icon" style="background:#eff6ff;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="#2f5fe8" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </span>
                                My Profile
                            </a>
                        </div>

                        <div class="dd-sep"></div>

                        <div class="dropdown-body" style="padding-top:2px;">
                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="dd-item danger">
                                    <span class="dd-item-icon" style="background:#fef2f2;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="#e03131" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                            <polyline points="16 17 21 12 16 7"/>
                                            <line x1="21" y1="12" x2="9" y2="12"/>
                                        </svg>
                                    </span>
                                    Sign out
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </header>

        {{-- Alerts + content --}}
        <main class="page-body">

            @if(session('success'))
            <div class="alert alert-success">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

<script>
/* ── Sidebar collapse (desktop) ────────────── */
const sidebar    = document.getElementById('sidebar');
const sbBtn      = document.getElementById('sbCollapseBtn');
const sbIcon     = document.getElementById('sbCollapseIcon');

const ICO_CLOSE = '<path d="M11 19l-7-7 7-7"/><path d="M21 19l-7-7 7-7"/>';
const ICO_OPEN  = '<path d="M13 5l7 7-7 7"/><path d="M3 5l7 7-7 7"/>';

if (localStorage.getItem('sb_collapsed') === '1' && window.innerWidth > 768) {
    sidebar.classList.add('collapsed');
    sbIcon.innerHTML = ICO_OPEN;
}

sbBtn.addEventListener('click', () => {
    if (window.innerWidth <= 768) return;
    const c = sidebar.classList.toggle('collapsed');
    sbIcon.innerHTML = c ? ICO_OPEN : ICO_CLOSE;
    localStorage.setItem('sb_collapsed', c ? '1' : '0');
});

/* ── Mobile sidebar ─────────────────────────── */
const mobOverlay = document.getElementById('mobOverlay');

function openMob() {
    sidebar.classList.add('mob-open');
    mobOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMob() {
    sidebar.classList.remove('mob-open');
    mobOverlay.classList.remove('open');
    document.body.style.overflow = '';
}
function checkMob() {
    const isMob = window.innerWidth <= 768;
    document.getElementById('mobMenuBtn').style.display = isMob ? 'flex' : 'none';
    if (!isMob) {
        closeMob();
        if (localStorage.getItem('sb_collapsed') === '1') {
            sidebar.classList.add('collapsed');
            sbIcon.innerHTML = ICO_OPEN;
        } else {
            sidebar.classList.remove('collapsed');
            sbIcon.innerHTML = ICO_CLOSE;
        }
    } else {
        sidebar.classList.remove('collapsed');
    }
}
checkMob();
window.addEventListener('resize', checkMob);
document.querySelectorAll('.sidebar .sb-item').forEach(l =>
    l.addEventListener('click', () => { if (window.innerWidth <= 768) closeMob(); })
);
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeMob(); closeAv(); } });

/* ── Avatar dropdown ────────────────────────── */
const avBtn      = document.getElementById('avBtn');
const avDropdown = document.getElementById('avDropdown');

function toggleAv() {
    const open = avDropdown.style.display === 'block';
    avDropdown.style.display = open ? 'none' : 'block';
    avBtn.setAttribute('aria-expanded', String(!open));
}
function closeAv() {
    avDropdown.style.display = 'none';
    avBtn.setAttribute('aria-expanded', 'false');
}
document.addEventListener('click', e => {
    if (!avBtn.contains(e.target) && !avDropdown.contains(e.target)) closeAv();
});
</script>
@auth
{{-- ── NOTIFICATION SOUND ────────────────────── --}}
<audio id="notif-sound" preload="auto">
    <source src="{{ asset('sounds/notify.mp3') }}" type="audio/mpeg">
</audio>

{{-- ── REALTIME NOTIFICATION SCRIPT ────────────── --}}
<script>
window.addEventListener('load', function () {
    if (!window.Echo) return;

    const sound    = document.getElementById('notif-sound');
    const userId   = {{ auth()->id() }};
    const userRole = '{{ auth()->user()->role }}';

    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {

            // ── 1. Play sound ─────────────────────────
            if (sound) {
                sound.currentTime = 0;
                sound.play().catch(() => {
                    document.addEventListener('click', function playOnce() {
                        sound.play().catch(() => {});
                        document.removeEventListener('click', playOnce);
                    }, { once: true });
                });
            }

            // ── 2. Update bell badge ──────────────────
            // badge uses a CLASS so use querySelector
            let badge = document.querySelector('.notif-badge');
            if (badge) {
                const current = parseInt(badge.innerText) || 0;
                const next    = current + 1;
                badge.innerText = next > 9 ? '9+' : next;
            } else {
                // No badge exists yet — create one inside the bell button
                const bell = document.getElementById('notif-bell');
                if (bell) {
                    badge = document.createElement('span');
                    badge.className   = 'notif-badge';
                    badge.innerText   = '1';
                    bell.appendChild(badge);
                }
            }

            // ── 3. Prepend to dropdown list ───────────
            const list  = document.getElementById('notif-list');
            const empty = document.getElementById('notif-empty');

            if (list) {
                if (empty) empty.remove();

                const url  = notification.url || '#';
                const item = document.createElement('a');
                item.href       = url;
                item.className  = 'notif-item';

                item.innerHTML = `
                    <span class="notif-dot"></span>
                    <div style="flex:1; min-width:0;">
                        <p class="notif-msg">${notification.message || 'New notification'}</p>
                        ${notification.service ? `
                        <p class="notif-sub">
                            ${notification.service}
                            ${notification.amount ? ' · $' + parseFloat(notification.amount).toFixed(2) : ''}
                        </p>` : ''}
                        <p class="notif-time">Just now</p>
                    </div>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="#d1d5db" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" style="flex-shrink:0; margin-top:4px;">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                `;

                // Mark as read on click
                item.addEventListener('click', () => {
                    if (notification.id) {
                        fetch(`/notifications/${notification.id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).catch(() => {});
                    }
                });

                list.prepend(item);
            }

            // ── 4. Toast ──────────────────────────────
            showNotifToast(notification);
        });

    function showNotifToast(notification) {
        const existing = document.querySelectorAll('.notif-toast');
        const offset   = existing.length * 80;

        const toast = document.createElement('div');
        toast.className = 'notif-toast';
        toast.style.cssText = `
            position:fixed; bottom:${24 + offset}px; right:24px;
            background:#111317; color:#fff;
            padding:14px 18px; border-radius:14px;
            box-shadow:0 8px 32px rgba(0,0,0,0.25);
            display:flex; align-items:flex-start; gap:12px;
            z-index:9999; max-width:340px; min-width:280px;
            border:1px solid rgba(255,255,255,0.08);
            animation:notifSlideIn 0.3s cubic-bezier(0.16,1,0.3,1);
            cursor:pointer;
        `;

        const iconBg = { admin: '#2f5fe8', driver: '#16a34a', client: '#7c3aed' }[userRole] || '#2f5fe8';

        toast.innerHTML = `
            <div style="width:36px;height:36px;border-radius:10px;background:${iconBg};
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            <div style="flex:1;min-width:0;">
                <p style="margin:0 0 3px;font-size:11px;font-weight:700;
                          color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.06em;">
                    New Notification
                </p>
                <p style="margin:0;font-size:13.5px;font-weight:600;color:#fff;line-height:1.4;">
                    ${notification.message || 'You have a new notification'}
                </p>
                ${notification.service ? `
                <p style="margin:3px 0 0;font-size:12px;color:rgba(255,255,255,0.45);">
                    ${notification.service}
                </p>` : ''}
            </div>
            <button onclick="this.closest('.notif-toast').remove()"
                    style="background:none;border:none;color:rgba(255,255,255,0.3);
                           cursor:pointer;padding:2px;flex-shrink:0;font-size:18px;line-height:1;">×</button>
        `;

        toast.addEventListener('click', function (e) {
            if (e.target.tagName === 'BUTTON') return;
            if (notification.url) window.location.href = notification.url;
            toast.remove();
        });

        document.body.appendChild(toast);

        const timer = setTimeout(() => {
            toast.style.animation = 'notifSlideOut 0.25s ease forwards';
            setTimeout(() => toast.remove(), 250);
        }, 5000);

        toast.addEventListener('mouseenter', () => clearTimeout(timer));
        toast.addEventListener('mouseleave', () => {
            setTimeout(() => {
                toast.style.animation = 'notifSlideOut 0.25s ease forwards';
                setTimeout(() => toast.remove(), 250);
            }, 2000);
        });
    }
});
</script>

<style>
@keyframes notifSlideIn {
    from { transform: translateX(120%); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}
@keyframes notifSlideOut {
    from { transform: translateX(0);    opacity: 1; }
    to   { transform: translateX(120%); opacity: 0; }
}
</style>
@endauth
</body>
</html>