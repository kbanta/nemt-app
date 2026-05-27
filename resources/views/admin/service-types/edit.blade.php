@extends('layouts.app')
@section('title', 'Edit Service Type')
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

    /* ── Back link ───────────────────────────── */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        padding: 8px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        transition: all 0.12s;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* ── Form card ───────────────────────────── */
    .form-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, 0.07);
        overflow: hidden;
        max-width: 560px;
    }

    .card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
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

    /* ── Form body ───────────────────────────── */
    .form-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* ── Field ───────────────────────────────── */
    .field label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        letter-spacing: 0.01em;
    }

    .field label .req {
        color: #dc2626;
        margin-left: 2px;
    }

    .field input[type="text"],
    .field input[type="number"],
    .field textarea {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 9px 12px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: 'DM Sans', sans-serif;
        background: #fff;
        outline: none;
        transition: border-color 0.13s, box-shadow 0.13s;
        box-sizing: border-box;
    }

    .field input[type="text"]:focus,
    .field input[type="number"]:focus,
    .field textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .field input.is-error,
    .field textarea.is-error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
    }

    .field textarea {
        resize: vertical;
        min-height: 88px;
        line-height: 1.5;
    }

    /* ── Price grid ──────────────────────────── */
    .price-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* ── Price input wrapper ─────────────────── */
    .price-wrap {
        position: relative;
    }

    .price-wrap .currency {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        pointer-events: none;
        line-height: 1;
    }

    .price-wrap input {
        padding-left: 24px !important;
    }

    /* ── Error message ───────────────────────── */
    .field-error {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        color: #dc2626;
        font-weight: 500;
        margin-top: 5px;
    }

    /* ── Hint text ───────────────────────────── */
    .field-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 5px;
    }

    /* ── Toggle (checkbox) ───────────────────── */
    .toggle-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        cursor: pointer;
        transition: border-color 0.12s, background 0.12s;
        user-select: none;
    }

    .toggle-row:hover {
        border-color: #bfdbfe;
        background: #f8fbff;
    }

    .toggle-row input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #2563eb;
        cursor: pointer;
        flex-shrink: 0;
    }

    .toggle-row .toggle-text strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.3;
    }

    .toggle-row .toggle-text span {
        font-size: 11.5px;
        color: #94a3b8;
    }

    /* ── Meta strip ──────────────────────────── */
    .meta-strip {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1.5px solid #f1f5f9;
        border-radius: 9px;
        font-size: 12px;
        color: #64748b;
    }

    /* ── Form footer ─────────────────────────── */
    .form-footer {
        padding: 16px 22px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #2563eb;
        color: #fff;
        padding: 9px 20px;
        border-radius: 9px;
        font-size: 13.5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.25);
        transition: all 0.13s;
        white-space: nowrap;
    }

    .btn-submit:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 600px) {
        .price-grid {
            grid-template-columns: 1fr;
        }

        .form-card {
            max-width: 100%;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .form-footer a,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

{{-- ── PAGE HEADER ──────────────────────────────── --}}
<div class="page-header">
    <div>
        <h2>Edit Service Type</h2>
        <p>Update the details and pricing for <strong style="color:#334155;">{{ $serviceType->name }}</strong></p>
    </div>

    <a href="{{ route('admin.service-types.index') }}" class="btn-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Back to Service Types
    </a>
</div>

{{-- ── FORM CARD ────────────────────────────────── --}}
<div class="form-card">

    {{-- Card header --}}
    <div class="card-header">
        <div class="card-header-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
        </div>
        <div>
            <p style="font-size:13.5px; font-weight:700; color:#0f172a; line-height:1.2;">
                {{ $serviceType->name }}
            </p>
            <p style="font-size:11.5px; color:#94a3b8; margin-top:1px;">
                All fields marked <span style="color:#dc2626;">*</span> are required
            </p>
        </div>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('admin.service-types.update', $serviceType) }}">
        @csrf
        @method('PUT')

        <div class="form-body">

            {{-- Name --}}
            <div class="field">
                <label for="name">
                    Service Name <span class="req">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $serviceType->name) }}"
                    placeholder="e.g. Standard Sedan, Executive SUV…"
                    class="{{ $errors->has('name') ? 'is-error' : '' }}"
                    required
                    autocomplete="off">
                @error('name')
                <p class="field-error">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="field">
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Optional — briefly describe what this service includes…">{{ old('description', $serviceType->description) }}</textarea>
                <p class="field-hint">Visible to clients during booking.</p>
            </div>

            {{-- Pricing --}}
            <div>
                <p style="font-size:12.5px; font-weight:600; color:#374151;
                           margin-bottom:10px; letter-spacing:0.01em;">
                    Pricing <span style="color:#dc2626;">*</span>
                </p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">

                    <div class="field">
                        <label>Base Price (Flat Rate)</label>
                        <div class="price-wrap">
                            <span class="currency">$</span>
                            <input type="number" name="base_price" step="0.01" min="0"
                                value="{{ old('base_price', isset($serviceType) ? $serviceType->base_price : '0.00') }}" required>
                        </div>
                        <p class="field-hint">Flat charge for the first X miles</p>
                        @error('base_price')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label>Included Miles</label>
                        <div class="price-wrap">
                            <span class="currency" style="font-size:11px;">mi</span>
                            <input type="number" name="included_miles" step="0.1" min="0.1" id="included_miles"
                                value="{{ old('included_miles', isset($serviceType) ? $serviceType->included_miles : '5') }}" required>
                        </div>
                        <p class="field-hint">Miles covered by base price</p>
                        @error('included_miles')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label>Condition Miles (Block Size)</label>
                        <div class="price-wrap">
                            <span class="currency" style="font-size:11px;">mi</span>
                            <input type="number" name="condition_miles" step="0.1" min="0.1" id="condition_miles"
                                value="{{ old('condition_miles', isset($serviceType) ? $serviceType->condition_miles : '4') }}" required>
                        </div>
                        <p class="field-hint">Every X miles triggers extra charge</p>
                        @error('condition_miles')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label>Charge Per Block</label>
                        <div class="price-wrap">
                            <span class="currency">$</span>
                            <input type="number" name="price_per_mile" step="0.01" min="0" id="price_per_mile_tiered"
                                value="{{ old('price_per_mile', isset($serviceType) ? $serviceType->price_per_mile : '0.00') }}" required>
                        </div>
                        <p class="field-hint">Amount charged per block</p>
                        @error('price_per_mile')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                </div>

                {{-- Live preview --}}
                <div id="tiered-preview" style="margin-top:12px; background:#f8fafc; border:1px solid #e2e8f0;
                                 border-radius:9px; padding:14px 16px;">
                    <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em;
               color:#94a3b8; margin-bottom:8px;">Live Preview</p>
                    <div id="tiered-preview-text" style="font-size:13px; font-weight:600; color:#0f172a; margin-bottom:6px;"></div>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;" id="tiered-examples"></div>
                </div>
            </div>

            {{-- Active toggle --}}
            <div class="field">
                <label as="div">Visibility</label>
                <label class="toggle-row" for="is_active">
                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $serviceType->is_active) ? 'checked' : '' }}>
                    <div class="toggle-text">
                        <strong>Active</strong>
                        <span>Service is visible to clients and can be booked</span>
                    </div>
                </label>
            </div>

            {{-- Last-updated meta --}}
            <div class="meta-strip">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                    stroke="#94a3b8" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                Last updated {{ $serviceType->updated_at->diffForHumans() }}
                &nbsp;·&nbsp;
                Created {{ $serviceType->created_at->format('M d, Y') }}
            </div>

        </div>

        {{-- Footer --}}
        <div class="form-footer">
            <a href="{{ route('admin.service-types.index') }}" class="btn-back">
                Cancel
            </a>
            <button type="submit" class="btn-submit">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Save Changes
            </button>
        </div>

    </form>
</div>
<script>
    function updatePreview() {
        const base = parseFloat(document.querySelector('[name="base_price"]')?.value) || 0;
        const included = parseFloat(document.getElementById('included_miles')?.value) || 0;
        const condition = parseFloat(document.getElementById('condition_miles')?.value) || 1;
        const charge = parseFloat(document.getElementById('price_per_mile_tiered')?.value) || 0;

        const text = document.getElementById('tiered-preview-text');
        const examples = document.getElementById('tiered-examples');

        if (text) {
            text.textContent = `$${base.toFixed(2)} flat for first ${included} mi, then $${charge.toFixed(2)} per every ${condition} mi after`;
        }

        if (examples) {
            examples.innerHTML = '';
            const sampleDistances = [
                included,
                included + condition,
                included + (condition * 3),
            ];
            sampleDistances.forEach(d => {
                const remaining = Math.max(0, d - included);
                const blocks = Math.floor(remaining / condition);
                const total = base + (blocks * charge);
                const chip = document.createElement('div');
                chip.style.cssText = `
                font-size:12px; font-weight:600; color:#2563eb;
                background:#eff6ff; border:1px solid #bfdbfe;
                border-radius:7px; padding:4px 10px;
            `;
                chip.textContent = `${d} mi = $${total.toFixed(2)}`;
                examples.appendChild(chip);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Attach live preview to all pricing inputs
        ['base_price', 'included_miles', 'condition_miles', 'price_per_mile_tiered'].forEach(id => {
            const el = id === 'base_price' ?
                document.querySelector('[name="base_price"]') :
                document.getElementById(id);
            if (el) el.addEventListener('input', updatePreview);
        });

        // Run once on load so preview shows immediately
        updatePreview();
    });
</script>
@endsection