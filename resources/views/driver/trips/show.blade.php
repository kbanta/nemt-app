@extends('layouts.app')
@section('title', 'Trip Details')
@section('content')

<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 20px;
        align-items: start;
    }
    .detail-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .detail-card:last-child { margin-bottom: 0; }
    .detail-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .detail-card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .detail-card-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .detail-card-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }
    .detail-card-body {
        padding: 20px 22px;
    }

    /* ── Info grid ───────────────────────────── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .info-label {
        font-size: 11.5px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ── Route visual ────────────────────────── */
    .route-dot-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 20px;
        flex-shrink: 0;
        margin-top: 3px;
    }
    .route-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .route-dot.pickup  { background: #2563eb; }
    .route-dot.dropoff { background: #dc2626; }
    .route-line {
        width: 2px;
        flex: 1;
        min-height: 28px;
        background: repeating-linear-gradient(to bottom, #cbd5e1 0, #cbd5e1 4px, transparent 4px, transparent 8px);
        margin: 4px 0;
    }
    .route-point       { display: flex; gap: 10px; margin-bottom: 4px; }
    .route-point-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px; }
    .route-point-value { font-size: 13px; font-weight: 600; color: #1e293b; line-height: 1.4; }
    .route-distance    { display: flex; align-items: center; gap: 6px; margin-top: 8px; font-size: 12.5px; color: #64748b; font-weight: 500; }

    /* ── Map ─────────────────────────────────── */
    #trip-map {
        width: 100%;
        height: 280px;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    /* ── Action buttons ──────────────────────── */
    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.13s;
        text-decoration: none;
    }
    .action-btn-orange {
        background: linear-gradient(135deg, #ea580c, #f97316);
        color: #fff;
        box-shadow: 0 2px 8px rgba(234,88,12,0.3);
    }
    .action-btn-orange:hover { box-shadow: 0 4px 16px rgba(234,88,12,0.4); transform: translateY(-1px); }
    .action-btn-green {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        box-shadow: 0 2px 8px rgba(22,163,74,0.3);
    }
    .action-btn-green:hover { box-shadow: 0 4px 16px rgba(22,163,74,0.4); transform: translateY(-1px); }
    .action-btn-maps {
        background: #fff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
    }
    .action-btn-maps:hover { background: #eff6ff; }

    /* ── Timeline ────────────────────────────── */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-item { display: flex; gap: 12px; }
    .timeline-left { display: flex; flex-direction: column; align-items: center; width: 20px; flex-shrink: 0; }
    .timeline-dot  { width: 10px; height: 10px; border-radius: 50%; background: #2563eb; flex-shrink: 0; margin-top: 3px; border: 2px solid #fff; box-shadow: 0 0 0 2px #2563eb; }
    .timeline-connector { width: 2px; flex: 1; min-height: 20px; background: #e2e8f0; margin: 4px 0; }
    .timeline-status { font-size: 13px; font-weight: 700; color: #0f172a; }
    .timeline-meta   { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }
    .timeline-notes  { font-size: 12px; color: #64748b; background: #f8fafc; border-radius: 6px; padding: 6px 9px; margin-top: 5px; margin-bottom: 4px; }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
        #trip-map  { height: 220px; }
    }
</style>

{{-- Back link --}}
<a href="{{ route('driver.trips.index') }}"
   style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:500;
          color:#64748b; text-decoration:none; padding:7px 12px; border:1.5px solid #e2e8f0;
          border-radius:9px; background:#fff; margin-bottom:20px; transition:all 0.13s;"
   onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 5l-7 7 7 7"/>
    </svg>
    Back to Trips
</a>

{{-- ── BOOKING HERO ──────────────────────────────── --}}
<div style="background:linear-gradient(135deg,#064e3b,#059669); border-radius:16px;
            padding:22px 24px; margin-bottom:20px; color:#fff;
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
    <div>
        <p style="font-family:'DM Mono',monospace; font-size:16px; font-weight:700;">
            {{ $booking->booking_number }}
        </p>
        <p style="font-size:13px; opacity:0.65; margin-top:3px;">
            {{ $booking->serviceType->name }} · {{ $booking->scheduled_at->format('M d, Y · H:i') }}
        </p>
    </div>
    <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <span class="badge {{ $booking->getStatusBadgeClass() }}"
              style="font-size:12px; padding:5px 12px;">
            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
        </span>
        <span style="font-size:16px; font-weight:800; color:#fff;">
            ${{ number_format($booking->final_price, 2) }}
        </span>
    </div>
</div>

{{-- ── TWO-COLUMN LAYOUT ───────────────────────── --}}
<div class="detail-grid">

    {{-- ── MAIN COLUMN ──────────────────────── --}}
    <div>

        {{-- Trip Details --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#eff6ff;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="10" r="3"/>
                            <path d="M12 2a8 8 0 0 1 8 8c0 5.25-8 13-8 13S4 15.25 4 10a8 8 0 0 1 8-8z"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Trip Details</span>
                </div>
            </div>
            <div class="detail-card-body">

                {{-- Route visual --}}
                <div style="margin-bottom:20px;">
                    <div class="route-point">
                        <div class="route-dot-wrap">
                            <div class="route-dot pickup"></div>
                            <div class="route-line"></div>
                        </div>
                        <div>
                            <div class="route-point-label">Pickup</div>
                            <div class="route-point-value">{{ $booking->pickup_address }}</div>
                        </div>
                    </div>
                    <div class="route-point">
                        <div class="route-dot-wrap">
                            <div class="route-dot dropoff"></div>
                        </div>
                        <div>
                            <div class="route-point-label">Dropoff</div>
                            <div class="route-point-value">{{ $booking->dropoff_address }}</div>
                        </div>
                    </div>
                    <div class="route-distance" style="margin-left:30px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#64748b"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                        </svg>
                        {{ $booking->distance_miles }} miles total
                    </div>
                </div>

                {{-- Map --}}
                <div id="trip-map" style="margin-bottom:16px;">
                    <div style="width:100%; height:100%; background:#f1f5f9; display:flex;
                                align-items:center; justify-content:center; border-radius:10px;">
                        <p style="font-size:13px; color:#94a3b8;">Loading map...</p>
                    </div>
                </div>

                {{-- Open in Google Maps button --}}
<button type="button"
        onclick="startNavigation('{{ addslashes($booking->dropoff_address) }}')"
        class="action-btn action-btn-maps"
        id="nav-btn"
        style="margin-bottom:0; border:none; cursor:pointer;">
    <svg id="nav-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polygon points="3 11 22 2 13 21 11 13 3 11"/>
    </svg>
    <span id="nav-label">Start Navigation in Google Maps</span>
</button>

                {{-- Info grid --}}
                <div style="border-top:1px solid #f1f5f9; padding-top:20px; margin-top:20px;">
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Client</div>
                            <div class="info-value">{{ $booking->client->name }}</div>
                            @if($booking->client->phone)
                            <a href="tel:{{ $booking->client->phone }}"
                               style="font-size:12px; color:#2563eb; text-decoration:none; margin-top:3px; display:inline-flex; align-items:center; gap:4px;">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.58 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                {{ $booking->client->phone }}
                            </a>
                            @endif
                        </div>
                        <div>
                            <div class="info-label">Patient Name</div>
                            <div class="info-value">{{ $booking->patient_name ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="info-label">Scheduled</div>
                            <div class="info-value">{{ $booking->scheduled_at->format('M d, Y') }}</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                                {{ $booking->scheduled_at->format('H:i') }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Payment</div>
                            <div class="info-value">{{ ucfirst($booking->payment_method ?? '—') }}</div>
                            @if($booking->is_paid)
                            <span style="display:inline-flex; align-items:center; gap:4px;
                                         font-size:12px; font-weight:600; color:#16a34a; margin-top:3px;">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Paid
                            </span>
                            @endif
                        </div>
                        @if($booking->notes)
                        <div style="grid-column:span 2;">
                            <div class="info-label">Notes</div>
                            <div style="font-size:13px; color:#475569; background:#f8fafc;
                                        border-radius:8px; padding:10px 14px; margin-top:4px;
                                        border-left:3px solid #e2e8f0; line-height:1.55;">
                                {{ $booking->notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ── ACTION BUTTONS ────────────────── --}}
        @if(in_array($booking->status, ['assigned', 'in_transit']))
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#fff7ed;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ea580c"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Trip Actions</span>
                </div>
            </div>
            <div class="detail-card-body" style="display:flex; flex-direction:column; gap:10px;">

                @if($booking->status === 'assigned')
                <form method="POST" action="{{ route('driver.trips.update-status', $booking) }}"
                    onsubmit="return submitOnce(this)">
                    @csrf
                    <input type="hidden" name="status" value="in_transit">
                    <button type="submit" class="action-btn action-btn-orange" id="btn-in-transit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                        </svg>
                        <span>Start Trip — Set In Transit</span>
                    </button>
                </form>

                @elseif($booking->status === 'in_transit')
                <form method="POST" action="{{ route('driver.trips.update-status', $booking) }}"
                    onsubmit="return confirmComplete(this)">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="action-btn action-btn-green" id="btn-complete">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>Complete Trip</span>
                    </button>
                </form>
                @endif

            </div>
        </div>
        @endif

    </div>

    {{-- ── ASIDE COLUMN ──────────────────────── --}}
    <div>

        {{-- Status Timeline --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <div class="detail-card-icon" style="background:#fdf4ff;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#9333ea" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="20" x2="12" y2="10"/>
                            <line x1="18" y1="20" x2="18" y2="4"/>
                            <line x1="6"  y1="20" x2="6"  y2="16"/>
                        </svg>
                    </div>
                    <span class="detail-card-title">Status History</span>
                </div>
                <span style="font-size:11.5px; font-weight:600; color:#94a3b8;">
                    {{ $booking->statusLogs->count() }} update{{ $booking->statusLogs->count() != 1 ? 's' : '' }}
                </span>
            </div>
            <div class="detail-card-body">
                @if($booking->statusLogs->isEmpty())
                <p style="font-size:13px; color:#94a3b8; text-align:center; padding:12px 0;">
                    No status updates yet.
                </p>
                @else
                <div class="timeline">
                    @foreach($booking->statusLogs as $log)
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <div class="timeline-dot"></div>
                            @if(!$loop->last)<div class="timeline-connector"></div>@endif
                        </div>
                        <div style="flex:1; min-width:0; padding-bottom:{{ $loop->last ? '0' : '12px' }};">
                            <div class="timeline-status">
                                {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                            </div>
                            <div class="timeline-meta">
                                {{ $log->created_at->format('M d, Y · H:i') }}
                            </div>
                            @if($log->notes)
                            <div class="timeline-notes">{{ $log->notes }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- ── LEAFLET MAP (free, no API key needed) ──── --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async function () {
    const pickup  = @json($booking->pickup_address);
    const dropoff = @json($booking->dropoff_address);
    const ORS_KEY = '{{ config('services.ors.key') }}';

    // Initialize map
    const map = L.map('trip-map');
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Custom markers
    const pickupIcon = L.divIcon({
        html: `<div style="width:14px;height:14px;border-radius:50%;background:#2563eb;border:3px solid #fff;box-shadow:0 2px 6px rgba(37,99,235,0.5);"></div>`,
        iconSize: [14, 14], iconAnchor: [7, 7], className: ''
    });
    const dropoffIcon = L.divIcon({
        html: `<div style="width:14px;height:14px;border-radius:50%;background:#dc2626;border:3px solid #fff;box-shadow:0 2px 6px rgba(220,38,38,0.5);"></div>`,
        iconSize: [14, 14], iconAnchor: [7, 7], className: ''
    });

    try {
        // Geocode both addresses
        const geocode = async (address) => {
            const url  = `https://api.openrouteservice.org/geocode/search?api_key=${ORS_KEY}&text=${encodeURIComponent(address)}&size=1`;
            const res  = await fetch(url);
            const data = await res.json();
            if (!data.features?.length) throw new Error('Not found: ' + address);
            return data.features[0].geometry.coordinates; // [lng, lat]
        };

        const [from, to] = await Promise.all([geocode(pickup), geocode(dropoff)]);

        // Add markers
        L.marker([from[1], from[0]], { icon: pickupIcon })
            .addTo(map)
            .bindPopup('<strong>Pickup</strong><br>' + pickup);
        L.marker([to[1], to[0]], { icon: dropoffIcon })
            .addTo(map)
            .bindPopup('<strong>Dropoff</strong><br>' + dropoff);

        // Get route from ORS
        const routeUrl = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${ORS_KEY}&start=${from[0]},${from[1]}&end=${to[0]},${to[1]}`;
        const routeRes  = await fetch(routeUrl);
        const routeData = await routeRes.json();

        if (routeData.features?.[0]) {
            const coords = routeData.features[0].geometry.coordinates.map(c => [c[1], c[0]]);
            const line   = L.polyline(coords, { color: '#2563eb', weight: 4, opacity: 0.75 }).addTo(map);
            map.fitBounds(line.getBounds(), { padding: [30, 30] });
        } else {
            // Fallback: just fit markers
            const bounds = L.latLngBounds([[from[1], from[0]], [to[1], to[0]]]);
            map.fitBounds(bounds, { padding: [40, 40] });
        }

    } catch (err) {
        console.error('Map error:', err);
        // Fallback: show a generic map centered on Philippines
        map.setView([13.41, 122.56], 6);
        document.getElementById('trip-map').insertAdjacentHTML('beforeend',
            '<div style="position:absolute;bottom:8px;left:8px;background:rgba(255,255,255,0.9);border-radius:6px;padding:6px 10px;font-size:12px;color:#64748b;">Could not load route</div>'
        );
    }
});
</script>
<script>
// ── Prevent double submit ─────────────────────
function submitOnce(form) {
    const btn = form.querySelector('button[type="submit"]');
    if (btn.disabled) return false; // already submitted

    // Disable button and show loading state
    btn.disabled = true;
    btn.style.opacity  = '0.7';
    btn.style.cursor   = 'not-allowed';
    btn.style.transform = 'none';

    const span = btn.querySelector('span');
    if (span) span.textContent = 'Please wait...';

    // Replace icon with spinner
    const svg = btn.querySelector('svg');
    if (svg) {
        svg.outerHTML = `<svg style="animation:spin 1s linear infinite;" width="15" height="15"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>`;
    }

    // Safety reset after 10s in case something goes wrong
    setTimeout(() => {
        btn.disabled       = false;
        btn.style.opacity  = '1';
        btn.style.cursor   = 'pointer';
    }, 10000);

    return true; // allow form to submit
}

// ── Complete trip — requires confirmation ─────
function confirmComplete(form) {
    if (!confirm('Mark this trip as completed? This cannot be undone.')) return false;
    return submitOnce(form);
}

// ── Spin animation ────────────────────────────
const style = document.createElement('style');
style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(style);

// ── Start navigation with live GPS location ───
function startNavigation(destination) {
    const btn   = document.getElementById('nav-btn');
    const icon  = document.getElementById('nav-icon');
    const label = document.getElementById('nav-label');

    // Show loading state
    btn.disabled = true;
    btn.style.opacity = '0.7';
    label.textContent = 'Getting your location...';
    icon.outerHTML = `
        <svg id="nav-icon" style="animation:spin 1s linear infinite;" width="15" height="15"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>`;

    if (!navigator.geolocation) {
        // Geolocation not supported — fall back to pickup address as origin
        openMapsWithOrigin(
            '{{ addslashes($booking->pickup_address) }}',
            destination,
            btn, label
        );
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Use current GPS coords as origin
            const url = `https://www.google.com/maps/dir/?api=1`
                + `&origin=${lat},${lng}`
                + `&destination=${encodeURIComponent(destination)}`
                + `&travelmode=driving`
                + `&dir_action=navigate`;

            window.open(url, '_blank');

            // Reset button
            resetNavBtn(btn, label);
        },
        function (error) {
            // Permission denied or error — fall back to pickup address
            console.warn('Geolocation error:', error.message);
            openMapsWithOrigin(
                '{{ addslashes($booking->pickup_address) }}',
                destination,
                btn, label
            );
        },
        {
            enableHighAccuracy: true,
            timeout: 8000,
            maximumAge: 0
        }
    );
}

function openMapsWithOrigin(origin, destination, btn, label) {
    const url = `https://www.google.com/maps/dir/?api=1`
        + `&origin=${encodeURIComponent(origin)}`
        + `&destination=${encodeURIComponent(destination)}`
        + `&travelmode=driving`
        + `&dir_action=navigate`;

    window.open(url, '_blank');
    resetNavBtn(btn, label);
}

function resetNavBtn(btn, label) {
    btn.disabled      = false;
    btn.style.opacity = '1';
    label.textContent = 'Start Navigation in Google Maps';
    // Restore icon
    const spinner = document.getElementById('nav-icon');
    if (spinner) {
        spinner.outerHTML = `
            <svg id="nav-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="3 11 22 2 13 21 11 13 3 11"/>
            </svg>`;
    }
}
</script>
@endsection