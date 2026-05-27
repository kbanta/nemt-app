@extends('layouts.app')
@section('title', 'System Settings')
@section('content')

<style>
    .stg-wrap {
        display: grid;
        grid-template-columns: 224px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* ── Sidebar ─────────────────────────────────────────── */
    .stg-sidebar {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
        position: sticky;
        top: 24px;
    }
    .stg-sidebar-head {
        padding: 11px 16px;
        font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.09em;
        color: #94a3b8; border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .stg-nav-item {
        display: flex; align-items: center; gap: 9px;
        padding: 11px 16px;
        font-size: 13px; font-weight: 500; color: #64748b;
        text-decoration: none; border-bottom: 1px solid #f8fafc;
        transition: background 0.12s, color 0.12s; cursor: pointer;
    }
    .stg-nav-item:last-child { border-bottom: none; }
    .stg-nav-item:hover  { background: #f8fafc; color: #0f172a; }
    .stg-nav-item.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
    .stg-nav-count {
        margin-left: auto; font-size: 10.5px; font-weight: 700;
        background: #f1f5f9; color: #94a3b8;
        border-radius: 999px; padding: 1px 7px;
    }
    .stg-nav-item.active .stg-nav-count { background: #dbeafe; color: #2563eb; }
    .stg-add-btn {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        margin: 12px; padding: 9px;
        background: #f8fafc; border: 1.5px dashed #e2e8f0;
        border-radius: 9px; font-size: 12.5px; font-weight: 600; color: #64748b;
        cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif;
        width: calc(100% - 24px);
    }
    .stg-add-btn:hover { background: #eff6ff; border-color: #bfdbfe; color: #2563eb; }

    /* ── Cards ───────────────────────────────────────────── */
    .stg-card {
        background: #fff; border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden; margin-bottom: 20px; scroll-margin-top: 24px;
    }
    .stg-card-head {
        padding: 16px 22px; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }
    .stg-card-head-left { display: flex; align-items: center; gap: 12px; }
    .stg-card-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .stg-card-title { font-size: 13.5px; font-weight: 700; color: #0f172a; }
    .stg-card-sub   { font-size: 12px; color: #94a3b8; margin-top: 1px; }
    .stg-card-body  { padding: 0; }

    /* ── Setting row ─────────────────────────────────────── */
    .stg-row {
        display: grid; grid-template-columns: 1fr 1.2fr auto;
        gap: 20px; align-items: center;
        padding: 16px 22px; border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }
    .stg-row:last-child { border-bottom: none; }
    .stg-row:hover { background: #fafbfd; }
    .stg-row-label { font-size: 13px; font-weight: 600; color: #0f172a; }
    .stg-row-desc  { font-size: 12px; color: #94a3b8; margin-top: 3px; line-height: 1.45; }
    .stg-row-key {
        display: inline-block; margin-top: 5px;
        font-size: 11px; font-weight: 600;
        font-family: 'DM Mono', monospace;
        color: #64748b; background: #f1f5f9;
        padding: 2px 8px; border-radius: 5px;
    }
    .stg-enc-badge {
        display: inline-flex; align-items: center; gap: 4px;
        background: #fef2f2; border-radius: 5px; padding: 2px 7px; margin-top: 5px;
        font-size: 10.5px; font-weight: 600; color: #dc2626;
    }

    /* ── Inputs ──────────────────────────────────────────── */
    .stg-input-wrap { position: relative; }
    .stg-input {
        width: 100%; border: 1.5px solid #e2e8f0; border-radius: 9px;
        padding: 9px 12px; font-size: 13px; color: #1e293b;
        font-family: 'DM Sans', sans-serif; background: #fff; outline: none;
        transition: border-color 0.13s, box-shadow 0.13s;
    }
    .stg-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .stg-input.mono  { padding-right: 44px; font-family: 'DM Mono', monospace; letter-spacing: 0.08em; }
    .stg-input.area  { resize: vertical; min-height: 80px; }
    .stg-eye {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; padding: 4px; color: #94a3b8;
        transition: color 0.12s; font-family: 'DM Sans', sans-serif;
    }
    .stg-eye:hover { color: #2563eb; }

    /* ── Row actions ─────────────────────────────────────── */
    .stg-row-actions { display: flex; align-items: center; gap: 6px; }
    .stg-del-btn {
        width: 30px; height: 30px; border-radius: 8px;
        background: #fef2f2; border: 1px solid #fecaca;
        display: flex; align-items: center; justify-content: center;
        color: #dc2626; transition: all 0.13s; flex-shrink: 0;
        font-family: 'DM Sans', sans-serif;
    }
    .stg-del-btn:hover { background: #fee2e2; border-color: #fca5a5; transform: scale(1.05); }

    /* ── Alerts ──────────────────────────────────────────── */
    .stg-alert {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1.5px solid;
    }
    .stg-alert.ok  { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
    .stg-alert.err { background: #fef2f2; border-color: #fecaca; color: #991b1b; }

    /* ── Buttons ─────────────────────────────────────────── */
    .stg-btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 22px; border-radius: 10px;
        font-size: 13.5px; font-weight: 700; border: none;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: all 0.15s; text-decoration: none;
    }
    .stg-btn-blue  { background: #2563eb; color: #fff; box-shadow: 0 2px 8px rgba(37,99,235,0.25); }
    .stg-btn-blue:hover  { background: #1d4ed8; box-shadow: 0 4px 14px rgba(37,99,235,0.35); transform: translateY(-1px); }
    .stg-btn-amber { background: #d97706; color: #fff; }
    .stg-btn-amber:hover { background: #b45309; }
    .stg-btn-ghost { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .stg-btn-ghost:hover { background: #e2e8f0; color: #0f172a; }
    .stg-btn-sm { padding: 7px 14px; font-size: 12.5px; border-radius: 8px; }

    /* ── Save bar ────────────────────────────────────────── */
    .stg-save-bar {
        display: flex; justify-content: flex-end; align-items: center;
        gap: 12px; margin-top: 4px;
    }

    /* ── Test mail ───────────────────────────────────────── */
    .stg-test-row { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
    .stg-test-input-wrap { flex: 1; min-width: 200px; }

    /* ── Modal ───────────────────────────────────────────── */
    .stg-modal-bg {
        display: none; position: fixed; inset: 0; z-index: 800;
        background: rgba(10,15,26,0.45); backdrop-filter: blur(4px);
        align-items: center; justify-content: center;
    }
    .stg-modal-bg.open { display: flex; }
    .stg-modal {
        background: #fff; border-radius: 18px;
        width: 540px; max-width: 94vw; max-height: 92vh; overflow-y: auto;
        box-shadow: 0 24px 64px rgba(0,0,0,0.18);
        animation: stg-pop 0.22s cubic-bezier(0.16,1,0.3,1);
    }
    @keyframes stg-pop {
        from { opacity:0; transform:scale(0.95) translateY(8px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }
    .stg-modal-head {
        padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; background: #fff; z-index: 1;
    }
    .stg-modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
    .stg-modal-close {
        width: 30px; height: 30px; border-radius: 8px;
        background: #f1f5f9; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #64748b; transition: all 0.12s; font-family: 'DM Sans', sans-serif;
    }
    .stg-modal-close:hover { background: #fef2f2; color: #dc2626; }
    .stg-modal-body { padding: 22px 24px; display: flex; flex-direction: column; gap: 16px; }
    .stg-modal-foot {
        padding: 16px 24px; border-top: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        position: sticky; bottom: 0; background: #fff;
    }

    /* ── Modal form fields ───────────────────────────────── */
    .stg-field-label {
        font-size: 12.5px; font-weight: 600; color: #374151;
        margin-bottom: 6px; display: block;
    }
    .stg-field-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .stg-field-error { font-size: 11.5px; color: #dc2626; margin-top: 4px; }
    .stg-field-hint  { font-size: 11px; color: #94a3b8; margin-top: 4px; }

    /* ── Page header ─────────────────────────────────────── */
    .stg-page-head {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .stg-page-title { font-size: 22px; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; }
    .stg-page-sub   { font-size: 13.5px; color: #64748b; margin-top: 3px; }
    .stg-super-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 9px; padding: 8px 14px;
        font-size: 12px; font-weight: 600; color: #dc2626;
    }

    /* ── Responsive ──────────────────────────────────────── */
    @media (max-width: 900px) {
        .stg-wrap    { grid-template-columns: 1fr; }
        .stg-sidebar { position: static; }
        .stg-row     { grid-template-columns: 1fr; gap: 10px; }
        .stg-field-row { grid-template-columns: 1fr; }
    }
</style>

{{-- ── Page header ─────────────────────────────────────── --}}
<div class="stg-page-head">
    <div>
        <div class="stg-page-title">System Settings</div>
        <div class="stg-page-sub">Manage application configuration. Changes take effect immediately.</div>
    </div>
    <div class="stg-super-badge">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        Superadmin Only
    </div>
</div>

{{-- ── Flash messages ──────────────────────────────────── --}}
@if(session('success'))
<div class="stg-alert ok">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="stg-alert err">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
</div>
@endif
@if($errors->any())
<div class="stg-alert err">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>@foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach</div>
</div>
@endif

@php
$groupIcons = [
    'general' => ['bg' => '#eff6ff', 'stroke' => '#2563eb',
        'icon' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>'],
    'stripe'  => ['bg' => '#fdf4ff', 'stroke' => '#9333ea',
        'icon' => '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>'],
    'maps'    => ['bg' => '#f0fdf4', 'stroke' => '#16a34a',
        'icon' => '<polygon points="3 11 22 2 13 21 11 13 3 11"/>'],
    'mail'    => ['bg' => '#fefce8', 'stroke' => '#d97706',
        'icon' => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>'],
];
$groupLabels = [
    'general' => 'General',
    'stripe'  => 'Stripe Payments',
    'maps'    => 'Maps & Routing',
    'mail'    => 'Email / SMTP',
];
$defaultIcon = ['bg' => '#f1f5f9', 'stroke' => '#64748b', 'icon' => '<circle cx="12" cy="12" r="3"/>'];
@endphp

<div class="stg-wrap">

    {{-- ── SIDEBAR ──────────────────────────────────────── --}}
    <div class="stg-sidebar">
        <div class="stg-sidebar-head">Sections</div>

        @foreach($groups as $group => $settings)
        @php $gi = $groupIcons[$group] ?? $defaultIcon; @endphp
        <a href="#stg-{{ $group }}" class="stg-nav-item" data-section="stg-{{ $group }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="{{ $gi['stroke'] }}" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                {!! $gi['icon'] !!}
            </svg>
            {{ $groupLabels[$group] ?? ucfirst($group) }}
            <span class="stg-nav-count">{{ $settings->count() }}</span>
        </a>
        @endforeach

        <button type="button" class="stg-add-btn" onclick="openAddModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Setting
        </button>
    </div>

    {{-- ── MAIN ─────────────────────────────────────────── --}}
    <div>

        {{-- ── SAVE FORM — no nested forms inside ────────── --}}
        <form method="POST" action="{{ route('admin.settings.update') }}" id="stg-form">
            @csrf

            @foreach($groups as $group => $settings)
            @php $gd = $groupIcons[$group] ?? $defaultIcon; @endphp

            <div class="stg-card" id="stg-{{ $group }}">

                {{-- Card header --}}
                <div class="stg-card-head">
                    <div class="stg-card-head-left">
                        <div class="stg-card-icon" style="background:{{ $gd['bg'] }};">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="{{ $gd['stroke'] }}" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                {!! $gd['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="stg-card-title">{{ $groupLabels[$group] ?? ucfirst($group) }}</div>
                            <div class="stg-card-sub">{{ $settings->count() }} setting{{ $settings->count() != 1 ? 's' : '' }}</div>
                        </div>
                    </div>
                    <button type="button" class="stg-btn stg-btn-ghost stg-btn-sm"
                            onclick="openAddModal('{{ $group }}')">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Add
                    </button>
                </div>

                {{-- Settings rows --}}
                <div class="stg-card-body">
                    @foreach($settings as $setting)
                    <div class="stg-row">

                        {{-- Meta --}}
                        <div>
                            <div class="stg-row-label">{{ $setting->label }}</div>
                            @if($setting->description)
                                <div class="stg-row-desc">{{ $setting->description }}</div>
                            @endif
                            <code class="stg-row-key">{{ $setting->key }}</code>
                            @if($setting->is_encrypted)
                                <div class="stg-enc-badge">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    Encrypted
                                </div>
                            @endif
                        </div>

                        {{-- Input --}}
                        <div class="stg-input-wrap">
                            @if($setting->type === 'password')
                                @php $hasValue = $setting->is_encrypted && !empty($setting->value); @endphp

                                @if($hasValue)
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;
                                            background:#f0fdf4; border:1px solid #bbf7d0;
                                            border-radius:8px; padding:8px 12px;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span style="font-size:12px; font-weight:600; color:#166534; flex:1;">
                                        Value is set — leave blank to keep it
                                    </span>
                                    <span style="font-size:11px; color:#94a3b8; font-family:'DM Mono',monospace;">
                                        ••••••••••
                                    </span>
                                </div>
                                @endif

                                <input type="password"
                                       name="{{ $setting->key }}"
                                       id="stgf-{{ $setting->key }}"
                                       class="stg-input mono"
                                       placeholder="{{ $hasValue ? 'Leave blank to keep existing value' : 'Enter value...' }}"
                                       value=""
                                       autocomplete="new-password"
                                       style="{{ $hasValue ? 'border-color:#bbf7d0; background:#f0fdf4;' : '' }}">
                                <button type="button" class="stg-eye"
                                        onclick="stgToggle('stgf-{{ $setting->key }}', this)">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>

                            @elseif($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}"
                                          class="stg-input area"
                                          rows="3">{{ $setting->getDecodedValue() }}</textarea>

                            @else
                                <input type="text"
                                       name="{{ $setting->key }}"
                                       class="stg-input"
                                       value="{{ $setting->getDecodedValue() }}">
                            @endif
                        </div>

                        {{-- Delete — calls hidden form outside save form --}}
                        <div class="stg-row-actions">
                            <button type="button"
                                    class="stg-del-btn"
                                    title="Delete setting"
                                    onclick="stgDelete('{{ route('admin.settings.destroy', $setting) }}', '{{ addslashes($setting->label) }}')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/><path d="M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

            <div class="stg-save-bar">
                <span style="font-size:12.5px; color:#94a3b8;">Changes apply to all sections at once.</span>
                <button type="submit" class="stg-btn stg-btn-blue">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Save All Settings
                </button>
            </div>
        </form>

        {{-- ── DELETE FORM — outside save form ───────────── --}}
        <form method="POST" id="stg-delete-form" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

        {{-- ── Test mail ──────────────────────────────────── --}}
        @if(isset($groups['mail']))
        <div class="stg-card" style="margin-top:20px;">
            <div class="stg-card-head">
                <div class="stg-card-head-left">
                    <div class="stg-card-icon" style="background:#fefce8;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="stg-card-title">Test Email</div>
                        <div class="stg-card-sub">Verify your SMTP configuration</div>
                    </div>
                </div>
            </div>
            <div style="padding:20px 22px;">
                <form method="POST" action="{{ route('admin.settings.test-mail') }}" class="stg-test-row">
                    @csrf
                    <div class="stg-test-input-wrap">
                        <label class="stg-field-label">Recipient Email</label>
                        <input type="email" name="test_email"
                               class="stg-input"
                               placeholder="you@example.com"
                               value="{{ auth()->user()->email }}">
                    </div>
                    <button type="submit" class="stg-btn stg-btn-amber">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Send Test
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>{{-- /main --}}
</div>{{-- /grid --}}


{{-- ── ADD SETTING MODAL ───────────────────────────────── --}}
<div class="stg-modal-bg" id="stgModal">
    <div class="stg-modal">
        <div class="stg-modal-head">
            <span class="stg-modal-title">Add New Setting</span>
            <button type="button" class="stg-modal-close" onclick="closeAddModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.settings.store') }}">
            @csrf
            <div class="stg-modal-body">

                {{-- Key + Label --}}
                <div class="stg-field-row">
                    <div>
                        <label class="stg-field-label">Key <span style="color:#dc2626;">*</span></label>
                        <input type="text" name="key" class="stg-input"
                               placeholder="e.g. stripe_key"
                               style="font-family:'DM Mono',monospace; font-size:12.5px;"
                               required pattern="[a-z0-9_]+">
                        <div class="stg-field-hint">Lowercase letters, numbers, underscores only</div>
                        @error('key')<div class="stg-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="stg-field-label">Label <span style="color:#dc2626;">*</span></label>
                        <input type="text" name="label" class="stg-input"
                               placeholder="e.g. Stripe Secret Key" required>
                        @error('label')<div class="stg-field-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Group + Type --}}
                <div class="stg-field-row">
                    <div>
                        <label class="stg-field-label">Group <span style="color:#dc2626;">*</span></label>
                        <select name="group" id="stgGroupSelect" class="stg-input" required>
                            @foreach($groups->keys() as $g)
                                <option value="{{ $g }}">{{ $groupLabels[$g] ?? ucfirst($g) }}</option>
                            @endforeach
                            <option value="__new__">+ New group...</option>
                        </select>
                    </div>
                    <div>
                        <label class="stg-field-label">Input Type</label>
                        <select name="type" id="stgTypeSelect" class="stg-input">
                            <option value="text">Text</option>
                            <option value="password">Password (masked)</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </div>
                </div>

                {{-- New group (hidden unless __new__ selected) --}}
                <div id="stgNewGroupWrap" style="display:none;">
                    <label class="stg-field-label">
                        New Group Name <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="group_new" id="stgNewGroup" class="stg-input"
                           placeholder="e.g. sms"
                           style="font-family:'DM Mono',monospace; font-size:12.5px;">
                    <div class="stg-field-hint">Lowercase and underscores only — creates a new section</div>
                    @error('group_new')<div class="stg-field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="stg-field-label">Description</label>
                    <input type="text" name="description" class="stg-input"
                           placeholder="Brief explanation shown below the label">
                </div>

                {{-- Default value --}}
                <div>
                    <label class="stg-field-label">Default Value</label>
                    <div class="stg-input-wrap">
                        <input type="text" name="value" id="stgValueInput" class="stg-input"
                               placeholder="Optional — leave blank to set later">
                    </div>
                </div>

                {{-- Encrypt + sort order --}}
                <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:500; color:#374151;">
                        <input type="checkbox" name="is_encrypted" id="stgEncrypted" value="1"
                               style="width:16px; height:16px; accent-color:#dc2626;">
                        <span>Encrypt stored value</span>
                        <span style="font-size:11px; color:#94a3b8; font-weight:400;">(for API keys, secrets)</span>
                    </label>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <label class="stg-field-label" style="margin-bottom:0; white-space:nowrap;">Sort order</label>
                        <input type="number" name="sort_order" value="0" min="0"
                               class="stg-input" style="width:80px;">
                    </div>
                </div>

                {{-- Encrypted info note --}}
                <div id="stgEncNote" style="display:none; background:#fef2f2; border:1px solid #fecaca;
                     border-radius:8px; padding:10px 14px; font-size:12.5px; color:#991b1b;
                     align-items:flex-start; gap:8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                         style="flex-shrink:0; margin-top:1px;">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <span>Value will be encrypted at rest. On the settings page, encrypted fields show
                    <strong>blank</strong> — leave the field empty when saving to keep the existing value.</span>
                </div>

            </div>{{-- /modal-body --}}

            <div class="stg-modal-foot">
                <button type="button" class="stg-btn stg-btn-ghost stg-btn-sm" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="stg-btn stg-btn-blue stg-btn-sm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create Setting
                </button>
            </div>
        </form>
    </div>
</div>


<script>
// ── Password visibility toggle ────────────────────────
function stgToggle(id, btn) {
    const f = document.getElementById(id);
    if (!f) return;
    const isPass = f.type === 'password';
    f.type = isPass ? 'text' : 'password';
    f.style.letterSpacing = isPass ? 'normal' : '0.08em';
    btn.style.color = isPass ? '#2563eb' : '#94a3b8';
}

// ── Delete via hidden form ────────────────────────────
function stgDelete(url, label) {
    if (!confirm('Delete "' + label + '"? This cannot be undone.')) return;
    const form = document.getElementById('stg-delete-form');
    form.action = url;
    form.submit();
}

// ── Modal open / close ────────────────────────────────
function openAddModal(group) {
    document.getElementById('stgModal').classList.add('open');
    document.body.style.overflow = 'hidden';
    if (group) {
        const sel = document.getElementById('stgGroupSelect');
        if (sel) {
            const opt = [...sel.options].find(o => o.value === group);
            if (opt) sel.value = group;
        }
    }
}
function closeAddModal() {
    document.getElementById('stgModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('stgModal').addEventListener('click', function (e) {
    if (e.target === this) closeAddModal();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeAddModal();
});

// ── Group select — show/hide new group field ──────────
document.getElementById('stgGroupSelect').addEventListener('change', function () {
    const wrap  = document.getElementById('stgNewGroupWrap');
    const input = document.getElementById('stgNewGroup');
    const isNew = this.value === '__new__';
    wrap.style.display = isNew ? 'block' : 'none';
    input.required     = isNew;
    if (isNew) setTimeout(() => input.focus(), 50);
});

// ── Type select — auto-check encrypt for password ─────
document.getElementById('stgTypeSelect').addEventListener('change', function () {
    const encBox   = document.getElementById('stgEncrypted');
    const encNote  = document.getElementById('stgEncNote');
    const valInput = document.getElementById('stgValueInput');
    if (this.value === 'password') {
        encBox.checked        = true;
        encNote.style.display = 'flex';
        valInput.type         = 'password';
    } else {
        encNote.style.display = encBox.checked ? 'flex' : 'none';
        valInput.type         = 'text';
    }
});

// ── Encrypt checkbox — show/hide note ─────────────────
document.getElementById('stgEncrypted').addEventListener('change', function () {
    document.getElementById('stgEncNote').style.display = this.checked ? 'flex' : 'none';
    if (!this.checked) document.getElementById('stgValueInput').type = 'text';
});

// ── Sidebar active highlight on scroll ────────────────
const stgSections = document.querySelectorAll('.stg-card[id]');
const stgNavItems = document.querySelectorAll('.stg-nav-item[data-section]');
const stgObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            stgNavItems.forEach(n => n.classList.remove('active'));
            const a = document.querySelector('.stg-nav-item[data-section="' + entry.target.id + '"]');
            if (a) a.classList.add('active');
        }
    });
}, { rootMargin: '-20% 0px -70% 0px' });
stgSections.forEach(s => stgObs.observe(s));

// ── Smooth scroll ─────────────────────────────────────
stgNavItems.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const t = document.getElementById(link.dataset.section);
        if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

// ── Re-open modal if validation errors ────────────────
@if($errors->any())
    openAddModal();
@endif
</script>

@endsection