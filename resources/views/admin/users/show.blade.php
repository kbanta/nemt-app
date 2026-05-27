@extends('layouts.app')
@section('title', $user->name . ' — User Profile')
@section('content')

<style>
    .profile-hero {
        background: #fff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.07);
        padding: 28px 28px 24px; display: flex; align-items: flex-start;
        gap: 20px; margin-bottom: 18px; flex-wrap: wrap;
    }
    .avatar-lg {
        width: 64px; height: 64px; border-radius: 18px;
        background: linear-gradient(135deg, #3b82f6, #6d28d9);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .hero-body { flex: 1; min-width: 0; }
    .hero-name { font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1.2; }
    .hero-meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 6px; }
    .hero-meta-item { display: flex; align-items: center; gap: 5px; font-size: 13px; color: #64748b; }
    .hero-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; flex-shrink: 0; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }

    .info-card { background: #fff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.07); overflow: hidden; }
    .info-card-header {
        padding: 14px 20px; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: 9px;
    }
    .info-card-icon {
        width: 28px; height: 28px; border-radius: 8px; background: #eff6ff;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .info-card-title { font-size: 13px; font-weight: 700; color: #0f172a; }

    .info-row {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 12px; padding: 12px 20px; border-bottom: 1px solid #f8fafc;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 12.5px; color: #94a3b8; font-weight: 500; white-space: nowrap; flex-shrink: 0; }
    .info-value { font-size: 13px; color: #1e293b; font-weight: 600; text-align: right; }

    .active-dot { display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 600; }
    .active-dot::before { content: ''; width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .active-dot.yes { color: #16a34a; } .active-dot.yes::before { background: #16a34a; }
    .active-dot.no  { color: #94a3b8; } .active-dot.no::before  { background: #cbd5e1; }

    .role-admin  { background: #faf5ff; color: #7c3aed; }
    .role-driver { background: #eff6ff; color: #2563eb; }
    .role-client { background: #f0fdf4; color: #16a34a; }
    .role-other  { background: #f8fafc; color: #64748b; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 9px;
        font-size: 13px; font-weight: 600; text-decoration: none; border: none;
        cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all 0.13s;
        white-space: nowrap; box-shadow: 0 1px 3px rgba(37,99,235,0.25);
    }
    .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: 6px; background: transparent;
        color: #64748b; padding: 8px 14px; border-radius: 9px; font-size: 13px;
        font-weight: 600; text-decoration: none; border: 1.5px solid #e2e8f0;
        cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all 0.13s; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

    .btn-warning {
        display: inline-flex; align-items: center; gap: 6px; background: #fefce8;
        color: #b45309; padding: 8px 14px; border-radius: 9px; font-size: 13px;
        font-weight: 600; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
        transition: background 0.13s; white-space: nowrap;
    }
    .btn-warning:hover { background: #fef9c3; }

    .btn-success {
        display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4;
        color: #16a34a; padding: 8px 14px; border-radius: 9px; font-size: 13px;
        font-weight: 600; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
        transition: background 0.13s; white-space: nowrap;
    }
    .btn-success:hover { background: #dcfce7; }

    .btn-danger {
        display: inline-flex; align-items: center; gap: 6px; background: #fef2f2;
        color: #dc2626; padding: 8px 14px; border-radius: 9px; font-size: 13px;
        font-weight: 600; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
        transition: background 0.13s; white-space: nowrap;
    }
    .btn-danger:hover { background: #fee2e2; }

    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .profile-hero { padding: 20px 18px; gap: 14px; }
        .hero-actions { width: 100%; }
    }
</style>

{{-- BACK --}}
<div style="margin-bottom:18px;">
    <a href="{{ route('admin.users.index') }}"
       style="display:inline-flex; align-items:center; gap:6px; font-size:13px;
              font-weight:600; color:#64748b; text-decoration:none;"
       onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#64748b'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Back to Users
    </a>
</div>

@if(session('success'))
<div style="margin-bottom:16px; background:#f0fdf4; border:1.5px solid #bbf7d0;
            border-radius:10px; padding:12px 16px; display:flex; align-items:center; gap:10px;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
    </svg>
    <span style="font-size:13px; font-weight:600; color:#15803d;">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div style="margin-bottom:16px; background:#fef2f2; border:1.5px solid #fecaca;
            border-radius:10px; padding:12px 16px; display:flex; align-items:center; gap:10px;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <span style="font-size:13px; font-weight:600; color:#dc2626;">{{ session('error') }}</span>
</div>
@endif

{{-- PROFILE HERO --}}
@php
    $roleClass = match($user->role) {
        'admin'  => 'role-admin',
        'driver' => 'role-driver',
        'client' => 'role-client',
        default  => 'role-other',
    };
@endphp

<div class="profile-hero">
    <div class="avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    <div class="hero-body">
        <div class="hero-name">{{ $user->name }}</div>
        <div style="display:flex; align-items:center; gap:8px; margin-top:4px; flex-wrap:wrap;">
            <span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
            <span class="active-dot {{ $user->is_active ? 'yes' : 'no' }}">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="hero-meta">
            <span class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                {{ $user->email }}
            </span>
            @if($user->phone)
            <span class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07
                             A19.5 19.5 0 0 1 4.07 12a19.79 19.79 0 0 1-3.07-8.67
                             A2 2 0 0 1 3 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81
                             a2 2 0 0 1-.45 2.11L7.09 8.09a16 16 0 0 0 6.29 6.29l1.07-1.07
                             a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                {{ $user->phone }}
            </span>
            @endif
            <span class="hero-meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
                Joined {{ $user->created_at->format('M d, Y') }}
            </span>
        </div>
    </div>

    <div class="hero-actions">
        {{-- Toggle active --}}
        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" style="display:inline;">
            @csrf
            @if($user->id !== auth()->id())
                @if($user->is_active)
                    <button type="submit" class="btn-warning">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                        </svg>
                        Deactivate
                    </button>
                @else
                    <button type="submit" class="btn-success">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Activate
                    </button>
                @endif
            @endif
        </form>

        {{-- Driver profile link --}}
        @if($user->role === 'driver' && $user->driver)
            <a href="{{ route('admin.drivers.show', $user->driver) }}" class="btn-ghost">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                    <path d="M16 8h4l3 5v3h-7V8z"/>
                    <circle cx="5.5"  cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
                Driver Profile
            </a>
        @endif
    </div>
</div>

{{-- DETAIL GRID --}}
<div class="detail-grid">

    {{-- Edit form --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </div>
            <span class="info-card-title">Edit User</span>
        </div>

        @if($errors->any())
        <div style="margin:14px 20px 0; background:#fef2f2; border:1.5px solid #fecaca;
                    border-radius:9px; padding:12px 14px;">
            @foreach($errors->all() as $e)
            <p style="font-size:12.5px; color:#dc2626; margin-bottom:2px;">• {{ $e }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" style="padding:16px 20px 20px;">
            @csrf @method('PUT')

            <div style="margin-bottom:14px;">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="form-input" required>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="form-input" required>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-label">Phone <span style="font-weight:400; color:#94a3b8;">— optional</span></label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="form-input">
            </div>
            <div style="margin-bottom:20px;">
                <label class="form-label">Role</label>
                <div style="position:relative;">
                    <select name="role" class="form-input" style="appearance:none; padding-right:40px; cursor:pointer;">
                        @foreach(['admin' => 'Admin', 'driver' => 'Driver', 'client' => 'Client'] as $val => $label)
                            <option value="{{ $val }}" {{ old('role', $user->role) === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <span style="position:absolute; right:13px; top:50%; transform:translateY(-50%);
                                 pointer-events:none; color:#94a3b8;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:11px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Save Changes
            </button>
        </form>
    </div>

    {{-- Account info --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon" style="background:#fdf4ff;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9333ea"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
            </div>
            <span class="info-card-title">Account Details</span>
        </div>

        <div class="info-row">
            <span class="info-label">User ID</span>
            <span class="info-value" style="font-family:'DM Mono',monospace; font-size:12px;">
                #{{ $user->id }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value">
                <span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
                <span class="active-dot {{ $user->is_active ? 'yes' : 'no' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone</span>
            <span class="info-value">{{ $user->phone ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Bookings</span>
            <span class="info-value">{{ $bookingCount }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Joined</span>
            <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Last Updated</span>
            <span class="info-value">{{ $user->updated_at->format('M d, Y') }}</span>
        </div>
    </div>

</div>

{{-- DANGER ZONE --}}
@if($user->id !== auth()->id())
<div class="info-card" style="margin-bottom:8px;">
    <div class="info-card-header">
        <div class="info-card-icon" style="background:#fef2f2;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9"  x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <span class="info-card-title" style="color:#dc2626;">Danger Zone</span>
    </div>
    <div style="padding:16px 20px; display:flex; align-items:center;
                justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div>
            <p style="font-size:13px; font-weight:600; color:#1e293b; margin-bottom:2px;">
                Delete this user
            </p>
            <p style="font-size:12px; color:#94a3b8;">
                Permanently removes this account and all associated data. This cannot be undone.
            </p>
        </div>
        <button type="submit" form="delete-user-form" class="btn-danger"
                onclick="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
            Delete User
        </button>
    </div>
</div>
@endif

{{-- Delete form (outside all other forms) --}}
<form id="delete-user-form" method="POST"
      action="{{ route('admin.users.destroy', $user) }}"
      style="display:none;">
    @csrf @method('DELETE')
</form>

@endsection