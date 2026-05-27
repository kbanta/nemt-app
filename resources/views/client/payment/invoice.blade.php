<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Arial', sans-serif;
    font-size: 12px;
    color: #0d1624;
    background: #fff;
    padding: 40px;
    line-height: 1.5;
}

/* ── HEADER ─────────────────────────── */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 28px;
    border-bottom: 2px solid #0d1624;
    margin-bottom: 32px;
}

.brand-name {
    font-size: 22px;
    font-weight: 900;
    letter-spacing: -0.02em;
    color: #0d1624;
    text-transform: uppercase;
}
.brand-name span { color: #d63030; }

.brand-sub {
    font-size: 10px;
    color: #5a6680;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-top: 3px;
}

.invoice-meta { text-align: right; }
.invoice-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #5a6680;
    margin-bottom: 4px;
}
.invoice-number {
    font-size: 20px;
    font-weight: 900;
    color: #0d1624;
    letter-spacing: -0.01em;
}
.invoice-date {
    font-size: 11px;
    color: #5a6680;
    margin-top: 4px;
}

/* ── STATUS BAND ────────────────────── */
.status-band {
    background: #f0f4fc;
    border-left: 3px solid #1547a8;
    padding: 10px 16px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.status-band-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #5a6680;
}
.status-badge {
    display: inline-block;
    padding: 3px 12px;
    border-radius: 2px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    background: #d1fae5;
    color: #065f46;
}

/* ── TWO-COL INFO ───────────────────── */
.info-grid {
    display: table;
    width: 100%;
    margin-bottom: 28px;
    border-collapse: collapse;
}
.info-col {
    display: table-cell;
    width: 50%;
    vertical-align: top;
    padding-right: 24px;
}
.info-col:last-child { padding-right: 0; padding-left: 24px; border-left: 1px solid #e2eaf8; }

.info-section-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #d63030;
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #e2eaf8;
}

.info-row {
    display: table;
    width: 100%;
    padding: 5px 0;
    border-bottom: 1px solid #f0f4fc;
}
.info-row:last-child { border-bottom: none; }
.info-key {
    display: table-cell;
    width: 42%;
    font-size: 11px;
    color: #5a6680;
    font-weight: 400;
}
.info-val {
    display: table-cell;
    font-size: 11px;
    font-weight: 600;
    color: #0d1624;
    text-align: right;
}

/* ── TRIP SECTION ───────────────────── */
.trip-section {
    margin-bottom: 28px;
    border: 1px solid #e2eaf8;
    border-radius: 2px;
    overflow: hidden;
}
.trip-section-head {
    background: #0d1624;
    padding: 8px 16px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.6);
}
.trip-row {
    display: table;
    width: 100%;
    border-collapse: collapse;
}
.trip-cell {
    display: table-cell;
    padding: 10px 16px;
    font-size: 11px;
    border-bottom: 1px solid #f0f4fc;
    vertical-align: top;
}
.trip-cell-label {
    width: 30%;
    color: #5a6680;
    font-weight: 400;
}
.trip-cell-val {
    font-weight: 500;
    color: #0d1624;
}
.trip-row:last-child .trip-cell { border-bottom: none; }

/* ── PAYMENT TABLE ──────────────────── */
.payment-section { margin-bottom: 0; }

.payment-section-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #d63030;
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #e2eaf8;
}

table.payment-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}
table.payment-table th {
    background: #f0f4fc;
    padding: 8px 12px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #5a6680;
    text-align: left;
    border-bottom: 1px solid #e2eaf8;
}
table.payment-table th:last-child { text-align: right; }
table.payment-table td {
    padding: 10px 12px;
    font-size: 12px;
    border-bottom: 1px solid #f0f4fc;
    color: #0d1624;
    vertical-align: top;
}
table.payment-table td:last-child {
    text-align: right;
    font-weight: 600;
    white-space: nowrap;
}
table.payment-table tr:last-child td { border-bottom: none; }

.td-desc { color: #0d1624; }
.td-subdesc {
    font-size: 10px;
    color: #5a6680;
    margin-top: 2px;
}

/* Total row */
.total-row {
    display: table;
    width: 100%;
    border-top: 2px solid #0d1624;
    margin-top: 0;
}
.total-left {
    display: table-cell;
    padding: 12px;
    vertical-align: middle;
}
.total-right {
    display: table-cell;
    padding: 12px;
    text-align: right;
    vertical-align: middle;
    white-space: nowrap;
}
.total-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #5a6680;
}
.total-amount {
    font-size: 24px;
    font-weight: 900;
    color: #1547a8;
    letter-spacing: -0.02em;
    line-height: 1;
}

/* Transaction ID */
.txn-row {
    background: #f0f4fc;
    border-top: 1px solid #e2eaf8;
    padding: 8px 12px;
    display: table;
    width: 100%;
}
.txn-label {
    display: table-cell;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #5a6680;
    width: 30%;
    vertical-align: middle;
}
.txn-val {
    display: table-cell;
    font-size: 10px;
    color: #0d1624;
    font-family: monospace;
    text-align: right;
    vertical-align: middle;
}

/* ── FOOTER ─────────────────────────── */
.footer {
    margin-top: 36px;
    padding-top: 16px;
    border-top: 1px solid #e2eaf8;
    display: table;
    width: 100%;
}
.footer-left {
    display: table-cell;
    font-size: 10px;
    color: #5a6680;
    vertical-align: bottom;
}
.footer-right {
    display: table-cell;
    text-align: right;
    font-size: 10px;
    color: #5a6680;
    vertical-align: bottom;
}
.footer-brand {
    font-size: 13px;
    font-weight: 900;
    color: #0d1624;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}
.footer-brand span { color: #d63030; }
</style>
</head>
<body>

{{-- ── HEADER ─────────────────────────── --}}
<div class="header">
    <div>
        <div class="brand-name">Med<span>Ride</span></div>
        <div class="brand-sub">Non-Emergency Medical Transportation</div>
    </div>
    <div class="invoice-meta">
        <div class="invoice-label">Invoice / Receipt</div>
        <div class="invoice-number">#{{ $booking->booking_number }}</div>
        <div class="invoice-date">Issued {{ $booking->created_at->format('F d, Y') }}</div>
    </div>
</div>

{{-- ── STATUS BAND ─────────────────── --}}
<div class="status-band">
    <span class="status-band-label">Booking Status</span>
    <span class="status-badge">{{ ucfirst($booking->status) }}</span>
</div>

{{-- ── CLIENT + BOOKING INFO ──────── --}}
<div class="info-grid">
    <div class="info-col">
        <div class="info-section-label">Client Information</div>
        <div class="info-row">
            <span class="info-key">Name</span>
            <span class="info-val">{{ $booking->client->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-key">Email</span>
            <span class="info-val">{{ $booking->client->email }}</span>
        </div>
    </div>
    <div class="info-col">
        <div class="info-section-label">Booking Details</div>
        <div class="info-row">
            <span class="info-key">Booking #</span>
            <span class="info-val">{{ $booking->booking_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-key">Date Created</span>
            <span class="info-val">{{ $booking->created_at->format('M d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-key">Scheduled</span>
            <span class="info-val">{{ $booking->scheduled_at->format('M d, Y H:i') }}</span>
        </div>
    </div>
</div>

{{-- ── TRIP DETAILS ────────────────── --}}
<div class="trip-section">
    <div class="trip-section-head">Trip Details</div>
    <div class="trip-row">
        <span class="trip-cell trip-cell-label">Service Type</span>
        <span class="trip-cell trip-cell-val">{{ $booking->serviceType->name }}</span>
    </div>
    <div class="trip-row">
        <span class="trip-cell trip-cell-label">Pickup</span>
        <span class="trip-cell trip-cell-val">{{ $booking->pickup_address }}</span>
    </div>
    <div class="trip-row">
        <span class="trip-cell trip-cell-label">Dropoff</span>
        <span class="trip-cell trip-cell-val">{{ $booking->dropoff_address }}</span>
    </div>
    <div class="trip-row">
        <span class="trip-cell trip-cell-label">Distance</span>
        <span class="trip-cell trip-cell-val">{{ $booking->distance_miles }} miles</span>
    </div>
</div>

{{-- ── PAYMENT ─────────────────────── --}}
<div class="payment-section">
    <div class="payment-section-label">Payment Breakdown</div>

    @php
        $st             = $booking->serviceType;
        $miles          = (float) $booking->distance_miles;
        $includedMiles  = (float) $st->included_miles;
        $conditionMiles = (float) ($st->condition_miles ?: 1);
        $ppm            = (float) $st->price_per_mile;

        if ($includedMiles > 0) {
            // Tiered: base covers included_miles, then charge per condition_miles block
            $extraMiles    = max(0, $miles - $includedMiles);
            $blocks        = floor($extraMiles / $conditionMiles);
            $distanceCharge = $blocks * $ppm;
        } else {
            // Simple: base + (miles × ppm)
            $extraMiles    = $miles;
            $blocks        = null;
            $distanceCharge = $miles * $ppm;
        }
    @endphp

    <table class="payment-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            {{-- Base price --}}
            <tr>
                <td>
                    <div class="td-desc">Base Price</div>
                    <div class="td-subdesc">
                        {{ $st->name }}
                        @if($includedMiles > 0)
                            — includes first {{ $includedMiles }} mi
                        @else
                            — flat rate
                        @endif
                    </div>
                </td>
                <td style="color:#5a6680; font-size:11px;">—</td>
                <td>${{ number_format($st->base_price, 2) }}</td>
            </tr>

            {{-- Distance charge --}}
            <tr>
                <td>
                    <div class="td-desc">Distance Charge</div>
                    <div class="td-subdesc">
                        @if($includedMiles > 0)
                            {{ $miles }} mi total · {{ $includedMiles }} mi included
                            = {{ number_format($extraMiles, 1) }} mi extra
                            ÷ {{ $conditionMiles }} mi × ${{ number_format($ppm, 2) }}
                            = {{ $blocks }} block{{ $blocks != 1 ? 's' : '' }}
                        @else
                            {{ $miles }} mi × ${{ number_format($ppm, 2) }}/mi
                        @endif
                    </div>
                </td>
                <td style="color:#5a6680; font-size:11px;">
                    ${{ number_format($ppm, 2) }}
                    @if($includedMiles > 0)
                        / {{ $conditionMiles }}mi
                    @else
                        /mi
                    @endif
                </td>
                <td>${{ number_format($distanceCharge, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Total --}}
    <div class="total-row">
        <div class="total-left">
            <div class="total-label">Total Amount Due</div>
            @if($includedMiles > 0)
            <div style="font-size:10px; color:#94a3b8; margin-top:3px;">
                ${{ number_format($st->base_price, 2) }} base
                + {{ $blocks }} block{{ $blocks != 1 ? 's' : '' }}
                × ${{ number_format($ppm, 2) }}
            </div>
            @else
            <div style="font-size:10px; color:#94a3b8; margin-top:3px;">
                ${{ number_format($st->base_price, 2) }} base
                + ${{ number_format($distanceCharge, 2) }} distance
            </div>
            @endif
        </div>
        <div class="total-right">
            <div class="total-amount">${{ number_format($booking->final_price, 2) }}</div>
        </div>
    </div>

    {{-- Payment method --}}
    <div class="txn-row">
        <span class="txn-label">Payment Method</span>
        <span class="txn-val">
            @if($booking->payment_method === 'insurance')
                Insurance — {{ $booking->insurance_provider }}
                (Member: {{ $booking->insurance_member_id }})
            @else
                {{ ucfirst($booking->payment_method) }}
            @endif
        </span>
    </div>

    {{-- Transaction ID --}}
    @if($booking->payment?->stripe_payment_intent)
    <div class="txn-row">
        <span class="txn-label">Transaction ID</span>
        <span class="txn-val">{{ $booking->payment->stripe_payment_intent }}</span>
    </div>
    @endif
</div>

{{-- ── FOOTER ──────────────────────── --}}
<div class="footer">
    <div class="footer-left">
        <div class="footer-brand">Med<span>Ride</span></div>
        <div style="margin-top:4px;">Non-Emergency Medical Transportation</div>
        <div style="margin-top:2px;">Thank you for choosing MedRide.</div>
    </div>
    <div class="footer-right">
        <div>Generated {{ now()->format('M d, Y H:i') }}</div>
        <div style="margin-top:2px;">This is an official receipt.</div>
    </div>
</div>

</body>
</html>