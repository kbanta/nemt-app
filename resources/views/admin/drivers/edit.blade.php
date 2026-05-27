@extends('layouts.app')
@section('title', 'Edit Driver')
@section('content')

<div style="max-width:680px;">
    <div style="margin-bottom:24px; display:flex; align-items:center; gap:14px;">
        <a href="{{ route('admin.drivers.show', $driver) }}"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px;
                  font-weight:500; color:#64748b; text-decoration:none; padding:7px 12px;
                  border:1.5px solid #e2e8f0; border-radius:9px; background:#fff;"
           onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Back
        </a>
        <div>
            <h2 style="font-size:22px; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">Edit Driver</h2>
            <p style="font-size:13.5px; color:#64748b; margin-top:3px;">{{ $driver->user->name }}</p>
        </div>
    </div>

    @if($errors->any())
    <div style="margin-bottom:20px; background:#fef2f2; border:1.5px solid #fecaca; border-radius:10px; padding:14px 18px;">
        <p style="font-size:13px; font-weight:700; color:#991b1b; margin-bottom:6px;">Please fix the following errors:</p>
        <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $e)
            <li style="font-size:13px; color:#dc2626; margin-bottom:2px;">{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card" style="padding:32px;">

        {{-- ✅ Save form — NO nested forms inside --}}
        <form method="POST" action="{{ route('admin.drivers.update', $driver) }}">
            @csrf @method('PUT')

            {{-- Account Info --}}
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; margin-bottom:6px;">Account Info</p>
            <div style="border-top:1px solid #f1f5f9; margin-bottom:20px;"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $driver->user->name) }}" class="form-input" required>
                    @error('name')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $driver->user->email) }}" class="form-input" required>
                    @error('email')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">New Password <span style="font-weight:400; color:#94a3b8;">— optional</span></label>
                    <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current">
                    @error('password')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Repeat new password">
                </div>
                <div>
                    <label class="form-label">Phone <span style="font-weight:400; color:#94a3b8;">— optional</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $driver->user->phone) }}" class="form-input">
                    @error('phone')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- License Info --}}
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; margin-bottom:6px; margin-top:8px;">License & Status</p>
            <div style="border-top:1px solid #f1f5f9; margin-bottom:20px;"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                <div>
                    <label class="form-label">License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $driver->license_number) }}" class="form-input" required>
                    @error('license_number')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">License Expiry</label>
                    <input type="date" name="license_expiry" value="{{ old('license_expiry', \Carbon\Carbon::parse($driver->license_expiry)->format('Y-m-d')) }}" class="form-input" required>
                    @error('license_expiry')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <div style="position:relative;">
                        <select name="status" class="form-input" style="appearance:none; padding-right:40px; cursor:pointer;">
                            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $driver->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <span style="position:absolute; right:13px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </div>
                </div>
                <div>
                    <label class="form-label">Availability</label>
                    <label style="display:flex; align-items:center; gap:10px; padding:10px 14px;
                                  border:1.5px solid #e2e8f0; border-radius:10px; cursor:pointer; margin-top:0;">
                        <input type="checkbox" name="is_available" value="1"
                               {{ old('is_available', $driver->is_available) ? 'checked' : '' }}
                               style="accent-color:#2563eb; width:15px; height:15px;">
                        <span style="font-size:13px; color:#334155; font-weight:500;">Available for bookings</span>
                    </label>
                </div>
            </div>

            {{-- Buttons row: Save inside this form, Delete is a separate form below via form= attribute --}}
            <div style="display:flex; gap:10px;">
                <button type="submit"
                        style="flex:1; display:inline-flex; align-items:center; justify-content:center;
                               gap:7px; padding:13px; font-size:14px; font-weight:700;
                               border-radius:10px; background:#2563eb; color:#fff; border:none;
                               cursor:pointer; font-family:'DM Sans',sans-serif;
                               box-shadow:0 1px 3px rgba(37,99,235,0.3); transition:all 0.13s;"
                        onmouseover="this.style.background='#1d4ed8'"
                        onmouseout="this.style.background='#2563eb'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Save Changes
                </button>

                {{-- ✅ Delete button submits the SEPARATE delete form below via the `form` attribute --}}
                <button type="submit" form="delete-driver-form"
                        style="display:inline-flex; align-items:center; justify-content:center;
                               gap:7px; padding:13px 18px; font-size:14px; font-weight:600;
                               border-radius:10px; background:#fef2f2; color:#dc2626;
                               border:1.5px solid #fecaca; cursor:pointer;
                               font-family:'DM Sans',sans-serif; transition:all 0.13s;"
                        onmouseover="this.style.background='#fee2e2'"
                        onmouseout="this.style.background='#fef2f2'"
                        onclick="return confirm('Delete {{ addslashes($driver->user->name) }}? This cannot be undone.')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Delete
                </button>
            </div>

        </form>
        {{-- ✅ End of save form --}}

    </div>{{-- end .card --}}
</div>

{{-- ✅ Delete form lives OUTSIDE the save form, identified by id="delete-driver-form" --}}
<form id="delete-driver-form"
      method="POST"
      action="{{ route('admin.drivers.destroy', $driver) }}"
      style="display:none;">
    @csrf
    @method('DELETE')
</form>

<style>
    @media(max-width:640px) {
        [style*="grid-template-columns:1fr 1fr"] { grid-template-columns:1fr !important; }
    }
</style>
@endsection