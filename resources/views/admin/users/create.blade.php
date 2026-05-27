@extends('layouts.app')
@section('title', 'Add User')
@section('content')

<div style="max-width:680px;">

    {{-- Back + heading --}}
    <div style="margin-bottom:24px; display:flex; align-items:center; gap:14px;">
        <a href="{{ route('admin.users.index') }}"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px;
                  font-weight:500; color:#64748b; text-decoration:none; padding:7px 12px;
                  border:1.5px solid #e2e8f0; border-radius:9px; background:#fff;"
           onmouseover="this.style.background='#f1f5f9'"
           onmouseout="this.style.background='#fff'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back
        </a>
        <div>
            <h2 style="font-size:22px; font-weight:800; color:#0f172a; letter-spacing:-0.02em;">
                Add User
            </h2>
            <p style="font-size:13px; color:#94a3b8; margin-top:3px;">
                Create a new admin, driver, or client account
            </p>
        </div>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
    <div style="margin-bottom:20px; background:#fef2f2; border:1.5px solid #fecaca;
                border-radius:10px; padding:14px 18px;">
        <p style="font-size:13px; font-weight:700; color:#991b1b; margin-bottom:6px;">
            Please fix the following errors:
        </p>
        <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $e)
            <li style="font-size:13px; color:#dc2626; margin-bottom:2px;">{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card" style="padding:32px;">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            {{-- ── Account Info ──────────────────────── --}}
            <p style="font-size:11px; font-weight:700; text-transform:uppercase;
                      letter-spacing:0.08em; color:#94a3b8; margin-bottom:6px;">
                Account Info
            </p>
            <div style="border-top:1px solid #f1f5f9; margin-bottom:20px;"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-input" placeholder="Jane Smith" required>
                    @error('name')
                        <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-input" placeholder="jane@example.com" required>
                    @error('email')
                        <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">
                        Phone
                        <span style="font-weight:400; color:#94a3b8;">— optional</span>
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="form-input" placeholder="+1 555 000 0000">
                    @error('phone')
                        <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Role</label>
                    <div style="position:relative;">
                        <select name="role" id="roleSelect" class="form-input"
                                style="appearance:none; padding-right:40px; cursor:pointer;"
                                onchange="handleRoleChange(this.value)">
                            @foreach(['client' => 'Client', 'driver' => 'Driver', 'admin' => 'Admin'] as $val => $label)
                                <option value="{{ $val }}" {{ old('role', 'client') === $val ? 'selected' : '' }}>
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
                    @error('role')
                        <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Driver note (shown only when role = driver) --}}
            <div id="driverNote"
                 style="display:{{ old('role', 'client') === 'driver' ? 'flex' : 'none' }};
                        align-items:flex-start; gap:10px; background:#eff6ff;
                        border:1.5px solid #bfdbfe; border-radius:10px;
                        padding:12px 14px; margin-bottom:20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="flex-shrink:0; margin-top:1px;">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8"  x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <p style="font-size:12.5px; color:#1d4ed8; line-height:1.5;">
                    A driver profile will be created automatically with <strong>Pending</strong> status.
                    You can add license details from the
                    <strong>Drivers</strong> section after saving.
                </p>
            </div>

            {{-- ── Password ───────────────────────────── --}}
            <p style="font-size:11px; font-weight:700; text-transform:uppercase;
                      letter-spacing:0.08em; color:#94a3b8; margin-bottom:6px; margin-top:8px;">
                Password
            </p>
            <div style="border-top:1px solid #f1f5f9; margin-bottom:20px;"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">
                <div>
                    <label class="form-label">Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="password"
                               class="form-input" placeholder="Min. 8 characters"
                               style="padding-right:40px;" required>
                        <button type="button" onclick="togglePw('password', 'eyePassword')"
                                style="position:absolute; right:11px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; cursor:pointer; color:#94a3b8;
                                       padding:0; display:flex; align-items:center;">
                            <svg id="eyePassword" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Confirm Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-input" placeholder="Repeat password"
                               style="padding-right:40px;" required>
                        <button type="button" onclick="togglePw('password_confirmation', 'eyeConfirm')"
                                style="position:absolute; right:11px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; cursor:pointer; color:#94a3b8;
                                       padding:0; display:flex; align-items:center;">
                            <svg id="eyeConfirm" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Submit ──────────────────────────────── --}}
            <div style="display:flex; gap:10px;">
                <button type="submit"
                        style="flex:1; display:inline-flex; align-items:center; justify-content:center;
                               gap:7px; padding:13px; font-size:14px; font-weight:700;
                               border-radius:10px; background:#2563eb; color:#fff; border:none;
                               cursor:pointer; font-family:'DM Sans',sans-serif;
                               box-shadow:0 1px 3px rgba(37,99,235,0.3); transition:all 0.13s;"
                        onmouseover="this.style.background='#1d4ed8'"
                        onmouseout="this.style.background='#2563eb'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Create User
                </button>
                <a href="{{ route('admin.users.index') }}"
                   style="display:inline-flex; align-items:center; justify-content:center;
                          gap:6px; padding:13px 20px; font-size:14px; font-weight:600;
                          border-radius:10px; background:#f8fafc; color:#64748b;
                          border:1.5px solid #e2e8f0; text-decoration:none; transition:all 0.13s;"
                   onmouseover="this.style.background='#f1f5f9'"
                   onmouseout="this.style.background='#f8fafc'">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<script>
function handleRoleChange(role) {
    document.getElementById('driverNote').style.display = role === 'driver' ? 'flex' : 'none';
}

function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    icon.innerHTML = show
        ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
           <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
           <line x1="1" y1="1" x2="23" y2="23"/>`
        : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
           <circle cx="12" cy="12" r="3"/>`;
}
</script>

<style>
    @media(max-width:640px) {
        [style*="grid-template-columns:1fr 1fr"] { grid-template-columns:1fr !important; }
    }
</style>

@endsection