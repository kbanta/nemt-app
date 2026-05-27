@extends('layouts.app')
@section('title', 'Add Driver')
@section('content')

<div style="max-width:680px;">
    <div style="margin-bottom:24px; display:flex; align-items:center; gap:14px;">
        <a href="{{ route('admin.drivers.index') }}"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px;
                  font-weight:500; color:#64748b; text-decoration:none; padding:7px 12px;
                  border:1.5px solid #e2e8f0; border-radius:9px; background:#fff;"
           onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Back
        </a>
        <div>
            <h2 style="font-size:22px; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">Add Driver</h2>
            <p style="font-size:13.5px; color:#64748b; margin-top:3px;">Create a new driver account</p>
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
        <form method="POST" action="{{ route('admin.drivers.store') }}">
            @csrf

            {{-- Account Info --}}
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; margin-bottom:6px;">Account Info</p>
            <div style="border-top:1px solid #f1f5f9; margin-bottom:20px;"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Juan dela Cruz" required>
                    @error('name')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="juan@email.com" required>
                    @error('email')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Min. 8 characters" required>
                    @error('password')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
                </div>
                <div>
                    <label class="form-label">Phone <span style="font-weight:400; color:#94a3b8;">— optional</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="+63 912 345 6789">
                    @error('phone')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- License Info --}}
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; margin-bottom:6px; margin-top:8px;">License Info</p>
            <div style="border-top:1px solid #f1f5f9; margin-bottom:20px;"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label">License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number') }}" class="form-input" placeholder="N01-12-345678" required>
                    @error('license_number')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">License Expiry</label>
                    <input type="date" name="license_expiry" value="{{ old('license_expiry') }}" class="form-input" required>
                    @error('license_expiry')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Initial Status</label>
                    <div style="position:relative;">
                        <select name="status" class="form-input" style="appearance:none; padding-right:40px; cursor:pointer;">
                            <option value="pending"  {{ old('status','pending') === 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <span style="position:absolute; right:13px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </div>
                    @error('status')<p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:13px; font-size:14px; border-radius:10px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Create Driver
            </button>
        </form>
    </div>
</div>

<style>
    @media(max-width:640px) {
        [style*="grid-template-columns:1fr 1fr"] { grid-template-columns:1fr !important; }
    }
</style>
@endsection