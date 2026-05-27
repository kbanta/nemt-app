@extends('layouts.app')
@section('title', 'New Booking')
@section('content')

<div style="max-width: 680px;">

    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">New Booking</h2>
        <p style="font-size:13.5px; color:#64748b; margin-top:4px;">Fill in the details below. Distance is calculated automatically.</p>
    </div>

    <div class="card" style="padding: 32px;" x-data="bookingForm()">
        <form method="POST" action="{{ route('client.bookings.store') }}" id="booking-form">
            @csrf

            {{-- ── SERVICE TYPE ────────────────────── --}}
            <div style="margin-bottom: 20px;">
                <label class="form-label">Service Type</label>
                <div style="position:relative;">
                    <select
                        name="service_type_id"
                        x-model="selectedServiceId"
                        @change="onServiceChange()"
                        class="form-input"
                        style="appearance:none; padding-right:40px; cursor:pointer;"
                        required
                    >
                        <option value="">Choose a transport type...</option>
                        @foreach($serviceTypes as $st)
                        <option
                            value="{{ $st->id }}"
                            data-base="{{ $st->base_price }}"
                            data-ppm="{{ $st->price_per_mile }}"
                            data-name="{{ $st->name }}"
                            {{ old('service_type_id') == $st->id ? 'selected' : '' }}
                        >{{ $st->name }}</option>
                        @endforeach
                    </select>
                    <span style="position:absolute; right:13px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>

                {{-- Service info chip --}}
                <div x-show="selectedServiceId" x-transition style="display:none; margin-top:8px;">
                    <div style="display:inline-flex; align-items:center; gap:8px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:7px 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span style="font-size:12.5px; color:#1d4ed8; font-weight:600;">
                            Base <span x-text="'$' + basePrice.toFixed(2)"></span>
                            &nbsp;+&nbsp;
                            <span x-text="'$' + ppm.toFixed(2)"></span>/mile
                        </span>
                    </div>
                </div>

                @error('service_type_id')
                <p style="color:#dc2626; font-size:12px; margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── DIVIDER ─────────────────────────── --}}
            <div style="border-top:1px solid #f1f5f9; margin: 4px 0 20px;"></div>

            {{-- ── PICKUP ──────────────────────────── --}}
            <div style="margin-bottom: 16px;">
                <label class="form-label">
                    Pickup Address
                    <span style="font-weight:400; color:#94a3b8; margin-left:4px;">— start location</span>
                </label>
                <div style="position:relative;">
                    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="3"/><path d="M12 2a8 8 0 0 1 8 8c0 5.25-8 13-8 13S4 15.25 4 10a8 8 0 0 1 8-8z"/></svg>
                    </span>
                    <input
                        type="text"
                        name="pickup_address"
                        id="pickup_address"
                        x-model="pickup"
                        @blur="maybeCalculate()"
                        value="{{ old('pickup_address') }}"
                        class="form-input"
                        style="padding-left: 38px;"
                        placeholder="123 Main St, City, State"
                        autocomplete="off"
                        required
                    >
                </div>
                @error('pickup_address')
                <p style="color:#dc2626; font-size:12px; margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── DROPOFF ─────────────────────────── --}}
            <div style="margin-bottom: 16px;">
                <label class="form-label">
                    Dropoff Address
                    <span style="font-weight:400; color:#94a3b8; margin-left:4px;">— destination</span>
                </label>
                <div style="position:relative;">
                    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <input
                        type="text"
                        name="dropoff_address"
                        id="dropoff_address"
                        x-model="dropoff"
                        @blur="maybeCalculate()"
                        value="{{ old('dropoff_address') }}"
                        class="form-input"
                        style="padding-left: 38px;"
                        placeholder="456 Oak Ave, City, State"
                        autocomplete="off"
                        required
                    >
                </div>
                @error('dropoff_address')
                <p style="color:#dc2626; font-size:12px; margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── DISTANCE RESULT ─────────────────── --}}
            <div style="margin-bottom: 20px; min-height: 42px;">

                {{-- Loading --}}
                <div x-show="calculating" style="display:none;">
                    <div style="display:flex; align-items:center; gap:8px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:9px; padding:10px 14px;">
                        <svg style="animation:spin 1s linear infinite;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        <span style="font-size:13px; color:#64748b;">Calculating distance...</span>
                    </div>
                </div>

                {{-- Success --}}
                <div x-show="distanceMiles > 0 && !calculating && !distanceError" style="display:none;">
                    <div style="display:flex; align-items:center; justify-content:space-between; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:9px; padding:10px 14px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <span style="font-size:13px; font-weight:600; color:#166534;">
                                Distance: <span x-text="distanceMiles.toFixed(1) + ' miles'"></span>
                            </span>
                            <span style="font-size:12px; color:#4ade80; background:#dcfce7; padding:2px 8px; border-radius:999px;" x-text="distanceText"></span>
                        </div>
                        <button
                            type="button"
                            @click="clearDistance()"
                            style="font-size:11px; color:#64748b; background:none; border:none; cursor:pointer; padding:2px 6px; border-radius:5px; transition:background 0.12s;"
                            onmouseover="this.style.background='#dcfce7'"
                            onmouseout="this.style.background='none'"
                        >Recalculate</button>
                    </div>
                </div>

                {{-- Error --}}
                <div x-show="distanceError" style="display:none;">
                    <div style="display:flex; align-items:center; justify-content:space-between; background:#fef2f2; border:1px solid #fecaca; border-radius:9px; padding:10px 14px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span style="font-size:13px; color:#991b1b;" x-text="distanceError"></span>
                        </div>
                        <button type="button" @click="manualMode = true; distanceError = ''" style="font-size:11px; color:#dc2626; background:none; border:none; cursor:pointer; text-decoration:underline;">Enter manually</button>
                    </div>
                </div>

                {{-- Manual fallback --}}
                <div x-show="manualMode" style="display:none; margin-top:8px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <input
                            type="number"
                            x-model.number="distanceMiles"
                            @input="updatePrice()"
                            step="0.1" min="0.1"
                            class="form-input"
                            style="max-width:160px;"
                            placeholder="0.0"
                        >
                        <span style="font-size:13px; color:#64748b;">miles</span>
                    </div>
                </div>
            </div>

            {{-- Hidden distance field sent with form --}}
            <input type="hidden" name="distance_miles" :value="distanceMiles > 0 ? distanceMiles : ''">

            {{-- ── DATE & TIME ─────────────────────── --}}
            <div style="margin-bottom: 20px;">
                <label class="form-label">Scheduled Date & Time</label>
                <div style="position:relative;">
                    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                    <input
                        type="datetime-local"
                        name="scheduled_at"
                        value="{{ old('scheduled_at') }}"
                        class="form-input"
                        style="padding-left:38px;"
                        min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                        required
                    >
                </div>
                @error('scheduled_at')
                <p style="color:#dc2626; font-size:12px; margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── NOTES ───────────────────────────── --}}
            <div style="margin-bottom: 24px;">
                <label class="form-label">
                    Notes
                    <span style="font-weight:400; color:#94a3b8; margin-left:4px;">— optional</span>
                </label>
                <textarea
                    name="notes"
                    rows="3"
                    class="form-input"
                    style="resize:vertical; min-height:80px;"
                    placeholder="Oxygen required, uses power wheelchair, second-floor pickup..."
                >{{ old('notes') }}</textarea>
            </div>

            {{-- ── PRICE SUMMARY ───────────────────── --}}
            <div
                x-show="estimatedPrice > 0"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-98"
                x-transition:enter-end="opacity-100 transform scale-100"
                style="display:none; margin-bottom: 24px;"
            >
                <div style="background: linear-gradient(135deg, #0b1a2e, #1e3459); border-radius:12px; padding:20px 22px; color:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:rgba(255,255,255,0.45); margin-bottom:6px;">Estimated Fare</p>
                            <p style="font-size:30px; font-weight:800; letter-spacing:-0.03em; line-height:1;" x-text="'$' + estimatedPrice.toFixed(2)"></p>
                            <p style="font-size:12px; color:rgba(255,255,255,0.45); margin-top:5px;">
                                Base $<span x-text="basePrice.toFixed(2)"></span>
                                + <span x-text="distanceMiles.toFixed(1)"></span> mi
                                × $<span x-text="ppm.toFixed(2)"></span>
                            </p>
                        </div>
                        <div style="text-align:right;">
                            <div style="display:inline-flex; align-items:center; gap:5px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:7px; padding:5px 10px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                <span style="font-size:11.5px; color:rgba(255,255,255,0.6);">Stripe Checkout</span>
                            </div>
                            <p style="font-size:11px; color:rgba(255,255,255,0.35); margin-top:6px;">Final price after payment</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SUBMIT ──────────────────────────── --}}
            <button
                type="submit"
                class="btn-primary"
                style="width:100%; justify-content:center; padding:13px; font-size:14px; border-radius:10px;"
                :disabled="distanceMiles <= 0"
                :style="distanceMiles <= 0 ? 'opacity:0.5; cursor:not-allowed;' : ''"
            >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Proceed to Payment
            </button>

            <p style="text-align:center; font-size:12px; color:#94a3b8; margin-top:10px;">
                You will be redirected to Stripe — no card data stored on our servers.
            </p>

        </form>
    </div>
</div>

{{-- ── Google Maps API ─────────────────────────────── --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete" async defer></script>

<style>
    @keyframes spin { to { transform: rotate(360deg); } }
    .pac-container { z-index: 9999; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 8px 24px rgba(0,0,0,0.08); font-family: 'DM Sans', sans-serif; }
    .pac-item { padding: 8px 14px; font-size: 13px; cursor: pointer; }
    .pac-item:hover { background: #f0f4f8; }
    .pac-icon { display: none; }
    .pac-item-query { font-weight: 600; color: #0f172a; }
</style>

<!-- <script>
// ── Google Places Autocomplete ────────────────────
let pickupAutocomplete, dropoffAutocomplete;

function initAutocomplete() {
    const pickupInput  = document.getElementById('pickup_address');
    const dropoffInput = document.getElementById('dropoff_address');

    if (!pickupInput || !dropoffInput) return;

    pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, {
        types: ['address'],
        fields: ['formatted_address', 'geometry']
    });

    dropoffAutocomplete = new google.maps.places.Autocomplete(dropoffInput, {
        types: ['address'],
        fields: ['formatted_address', 'geometry']
    });

    pickupAutocomplete.addListener('place_changed', () => {
        const place = pickupAutocomplete.getPlace();
        if (place.formatted_address) {
            window._alpineBookingForm.pickup = place.formatted_address;
            window._alpineBookingForm.maybeCalculate();
        }
    });

    dropoffAutocomplete.addListener('place_changed', () => {
        const place = dropoffAutocomplete.getPlace();
        if (place.formatted_address) {
            window._alpineBookingForm.dropoff = place.formatted_address;
            window._alpineBookingForm.maybeCalculate();
        }
    });
}

// ── Alpine component ──────────────────────────────
function bookingForm() {
    const component = {
        // State
        selectedServiceId: '{{ old('service_type_id', '') }}',
        pickup:   '{{ old('pickup_address', '') }}',
        dropoff:  '{{ old('dropoff_address', '') }}',
        basePrice:     0,
        ppm:           0,
        distanceMiles: 0,
        distanceText:  '',
        estimatedPrice: 0,
        calculating:   false,
        distanceError: '',
        manualMode:    false,

        // Called when service type changes
        onServiceChange() {
            const sel = document.querySelector('select[name="service_type_id"]');
            const opt = sel.options[sel.selectedIndex];
            if (!opt || !opt.dataset.base) {
                this.basePrice = 0; this.ppm = 0;
            } else {
                this.basePrice = parseFloat(opt.dataset.base) || 0;
                this.ppm       = parseFloat(opt.dataset.ppm) || 0;
            }
            this.updatePrice();
        },

        // Calculate price from current values
        updatePrice() {
            if (this.basePrice > 0 && this.distanceMiles > 0) {
                this.estimatedPrice = this.basePrice + (this.ppm * this.distanceMiles);
            } else {
                this.estimatedPrice = 0;
            }
        },

        // Trigger distance calc when both fields are filled
        maybeCalculate() {
            const p = (this.pickup  || document.getElementById('pickup_address').value).trim();
            const d = (this.dropoff || document.getElementById('dropoff_address').value).trim();
            if (p.length > 5 && d.length > 5 && this.distanceMiles === 0 && !this.manualMode) {
                this.calculateDistance(p, d);
            }
        },

        // Google Distance Matrix call
        calculateDistance(origin, destination) {
            if (typeof google === 'undefined') {
                this.distanceError = 'Maps API not loaded. Please enter distance manually.';
                this.manualMode = true;
                return;
            }

            this.calculating   = true;
            this.distanceError = '';
            this.distanceMiles = 0;

            const service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    origins:      [origin],
                    destinations: [destination],
                    travelMode:   google.maps.TravelMode.DRIVING,
                    unitSystem:   google.maps.UnitSystem.IMPERIAL,
                },
                (response, status) => {
                    this.calculating = false;

                    if (status !== 'OK') {
                        this.distanceError = 'Could not calculate distance. Please enter manually.';
                        this.manualMode = true;
                        return;
                    }

                    const element = response.rows[0].elements[0];

                    if (element.status !== 'OK') {
                        this.distanceError = 'Route not found between these addresses.';
                        this.manualMode = true;
                        return;
                    }

                    // Distance Matrix returns meters — convert to miles
                    const meters = element.distance.value;
                    this.distanceMiles = Math.round((meters / 1609.344) * 10) / 10;
                    this.distanceText  = element.distance.text;
                    this.updatePrice();
                }
            );
        },

        // Clear distance to allow recalculation
        clearDistance() {
            this.distanceMiles  = 0;
            this.distanceText   = '';
            this.estimatedPrice = 0;
            this.manualMode     = false;
            this.distanceError  = '';
        },
    };

    // Expose to initAutocomplete
    window._alpineBookingForm = component;

    // Pre-populate if old values exist (after validation error)
    if (component.selectedServiceId) {
        setTimeout(() => component.onServiceChange(), 50);
    }
    if (component.pickup && component.dropoff) {
        setTimeout(() => component.maybeCalculate(), 100);
    }

    return component;
}
</script> -->
<!-- <script>
// ── Alpine component ──────────────────────────────
function bookingForm() {
    const ORS_API_KEY = '{{ config('services.ors.key') }}'; // Add ORS_KEY=your_key to .env and config/services.php

    const component = {
        // State
        selectedServiceId: '{{ old('service_type_id', '') }}',
        pickup:   '{{ old('pickup_address', '') }}',
        dropoff:  '{{ old('dropoff_address', '') }}',
        paymentMethod: '{{ old('payment_method', 'online') }}',
        basePrice:      0,
        ppm:            0,
        includedMiles:  0,
        conditionMiles: 1,
        distanceMiles:  0,
        distanceText:   '',
        estimatedPrice: 0,
        calculating:    false,
        distanceError:  '',
        manualMode:     false,

        // Autocomplete state
        pickupSuggestions:  [],
        dropoffSuggestions: [],
        pickupActiveIndex:  -1,
        dropoffActiveIndex: -1,
        pickupDebounce:     null,
        dropoffDebounce:    null,
        
        // ── Autocomplete: Pickup ─────────────────
        onPickupInput() {
            clearTimeout(this.pickupDebounce);
            const q = this.pickup.trim();
            if (q.length < 3) { this.pickupSuggestions = []; return; }
            this.pickupDebounce = setTimeout(() => this.fetchSuggestions('pickup', q), 350);
        },

        onDropoffInput() {
            clearTimeout(this.dropoffDebounce);
            const q = this.dropoff.trim();
            if (q.length < 3) { this.dropoffSuggestions = []; return; }
            this.dropoffDebounce = setTimeout(() => this.fetchSuggestions('dropoff', q), 350);
        },

        onPickupBlur() {
            // Delay so mousedown on suggestion fires first
            setTimeout(() => {
                this.pickupSuggestions = [];
                this.pickupActiveIndex = -1;
                this.maybeCalculate();
            }, 200);
        },

        onDropoffBlur() {
            setTimeout(() => {
                this.dropoffSuggestions = [];
                this.dropoffActiveIndex = -1;
                this.maybeCalculate();
            }, 200);
        },

        async fetchSuggestions(field, query) {
            try {
                const url = `https://api.openrouteservice.org/geocode/autocomplete?api_key=${ORS_API_KEY}&text=${encodeURIComponent(query)}&size=5`;
                const res  = await fetch(url);
                const data = await res.json();
                const suggestions = (data.features || []).map(f => ({
                    label: f.properties.label,
                    coords: f.geometry.coordinates, // [lng, lat]
                }));
                if (field === 'pickup') {
                    this.pickupSuggestions  = suggestions;
                    this.pickupActiveIndex  = -1;
                } else {
                    this.dropoffSuggestions = suggestions;
                    this.dropoffActiveIndex = -1;
                }
            } catch (e) {
                // Silently fail — user can still type manually
            }
        },

        selectSuggestion(field, suggestion) {
            if (field === 'pickup') {
                this.pickup             = suggestion.label;
                this.pickupSuggestions  = [];
                this.pickupActiveIndex  = -1;
                this._pickupCoords      = suggestion.coords;
            } else {
                this.dropoff            = suggestion.label;
                this.dropoffSuggestions = [];
                this.dropoffActiveIndex = -1;
                this._dropoffCoords     = suggestion.coords;
            }
            this.maybeCalculate();
        },

        selectSuggestionByKey(field) {
            if (field === 'pickup' && this.pickupActiveIndex >= 0) {
                this.selectSuggestion('pickup', this.pickupSuggestions[this.pickupActiveIndex]);
            } else if (field === 'dropoff' && this.dropoffActiveIndex >= 0) {
                this.selectSuggestion('dropoff', this.dropoffSuggestions[this.dropoffActiveIndex]);
            }
        },

        moveSuggestion(field, dir) {
            if (field === 'pickup') {
                const max = this.pickupSuggestions.length - 1;
                this.pickupActiveIndex = Math.min(Math.max(this.pickupActiveIndex + dir, 0), max);
            } else {
                const max = this.dropoffSuggestions.length - 1;
                this.dropoffActiveIndex = Math.min(Math.max(this.dropoffActiveIndex + dir, 0), max);
            }
        },

        closeSuggestions(field) {
            if (field === 'pickup') {
                this.pickupSuggestions = [];
                this.pickupActiveIndex = -1;
            } else {
                this.dropoffSuggestions = [];
                this.dropoffActiveIndex = -1;
            }
        },

        // ── Service type ─────────────────────────
        onServiceChange() {
            const sel = document.querySelector('select[name="service_type_id"]');
            const opt = sel.options[sel.selectedIndex];
            if (!opt || !opt.dataset.base) {
                this.basePrice = 0; this.ppm = 0; this.includedMiles = 0; this.conditionMiles = 1;
            } else {
                this.basePrice      = parseFloat(opt.dataset.base)      || 0;
                this.ppm            = parseFloat(opt.dataset.ppm)       || 0;
                this.includedMiles  = parseFloat(opt.dataset.included)  || 0;
                this.conditionMiles = parseFloat(opt.dataset.condition) || 1;
            }
            this.updatePrice();
        },

        // ── Price calculation ────────────────────
        updatePrice() {
            if (this.basePrice <= 0 || this.distanceMiles <= 0) {
                this.estimatedPrice = 0;
                return;
            }

            if (this.includedMiles > 0) {
                // Tiered: base covers includedMiles, then charge per conditionMiles block
                const remaining    = Math.max(0, this.distanceMiles - this.includedMiles);
                const blocks       = Math.floor(remaining / this.conditionMiles);
                this.estimatedPrice = this.basePrice + (blocks * this.ppm);
            } else {
                // Simple: base + (miles × ppm)
                this.estimatedPrice = this.basePrice + (this.ppm * this.distanceMiles);
            }
        },

        // ── Trigger distance calc ────────────────
        maybeCalculate() {
            const p = this.pickup.trim();
            const d = this.dropoff.trim();
            if (p.length > 5 && d.length > 5 && this.distanceMiles === 0 && !this.manualMode) {
                // Use cached coords from autocomplete selection if available,
                // otherwise fall back to geocoding the typed text
                if (this._pickupCoords && this._dropoffCoords) {
                    this.calculateDistanceByCoords(this._pickupCoords, this._dropoffCoords);
                } else {
                    this.calculateDistanceByAddress(p, d);
                }
            }
        },

        // ── ORS: address → geocode → route ───────
        async calculateDistanceByAddress(origin, destination) {
            this.calculating   = true;
            this.distanceError = '';
            this.distanceMiles = 0;

            try {
                const geocode = async (address) => {
                    const url  = `https://api.openrouteservice.org/geocode/search?api_key=${ORS_API_KEY}&text=${encodeURIComponent(address)}&size=1`;
                    const res  = await fetch(url);
                    const data = await res.json();
                    if (!data.features || data.features.length === 0)
                        throw new Error('Address not found: ' + address);
                    return data.features[0].geometry.coordinates; // [lng, lat]
                };

                const [fromCoords, toCoords] = await Promise.all([
                    geocode(origin),
                    geocode(destination),
                ]);

                await this.calculateDistanceByCoords(fromCoords, toCoords);

            } catch (err) {
                this.calculating   = false;
                this.distanceError = 'Could not calculate distance. Please enter manually.';
                this.manualMode    = false;
                console.error(err);
            }
        },

        // ── ORS: coords → driving distance ───────
        async calculateDistanceByCoords(fromCoords, toCoords) {
            this.calculating   = true;
            this.distanceError = '';

            try {
                // ORS v2 GET endpoint — works on all free keys
                // coords format: lng,lat|lng,lat
                const start = `${fromCoords[0]},${fromCoords[1]}`;
                const end   = `${toCoords[0]},${toCoords[1]}`;
                const url   = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${ORS_API_KEY}&start=${start}&end=${end}`;

                const res  = await fetch(url);
                const data = await res.json();

                if (!res.ok) {
                    console.error('ORS error:', data);
                    this.distanceError = 'Could not calculate distance. Please enter manually.';
                    this.calculating   = false;
                    return;
                }

                // GeoJSON response: features[0].properties.summary.distance is in meters
                const summary = data.features?.[0]?.properties?.summary;
                if (!summary) {
                    this.distanceError = 'Route not found between these addresses.';
                    this.calculating   = false;
                    return;
                }

                // Convert meters → miles
                const miles        = summary.distance / 1609.344;
                this.distanceMiles = Math.round(miles * 10) / 10;
                this.distanceText  = this.distanceMiles + ' mi';
                this.calculating   = false;
                this.updatePrice();

            } catch (err) {
                this.calculating   = false;
                this.distanceError = 'Could not calculate distance. Please enter manually.';
                console.error(err);
            }
        },

        // ── Clear to allow recalculation ─────────
        clearDistance() {
            this.distanceMiles   = 0;
            this.distanceText    = '';
            this.estimatedPrice  = 0;
            this.manualMode      = false;
            this.distanceError   = '';
            this._pickupCoords   = null;
            this._dropoffCoords  = null;
        },
    };

    // Pre-populate if old values exist (after validation error)
    if (component.selectedServiceId) {
        setTimeout(() => component.onServiceChange(), 50);
    }
    if (component.pickup && component.dropoff) {
        setTimeout(() => component.maybeCalculate(), 100);
    }

    return component;
}
</script> -->
@endsection