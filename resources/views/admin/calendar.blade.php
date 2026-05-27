@extends('layouts.app')
@section('title', 'Booking Calendar')
@section('content')

<div style="margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
    <div>
        <h2 style="font-size:22px; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">Booking Calendar</h2>
        <p style="font-size:13.5px; color:#64748b; margin-top:3px;">All scheduled trips at a glance</p>
    </div>
    <a href="{{ route('admin.bookings.create') }}"
       style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:#fff;
              padding:9px 16px; border-radius:9px; font-size:13px; font-weight:600;
              text-decoration:none; transition:all 0.13s; box-shadow:0 1px 3px rgba(37,99,235,0.25);"
       onmouseover="this.style.background='#1d4ed8'"
       onmouseout="this.style.background='#2563eb'">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Booking
    </a>
</div>

{{-- Legend --}}
<div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:16px;">
    @foreach([
        'pending'    => ['#f59e0b', 'Pending'],
        'approved'   => ['#3b82f6', 'Approved'],
        'assigned'   => ['#8b5cf6', 'Assigned'],
        'in_transit' => ['#06b6d4', 'In Transit'],
        'completed'  => ['#16a34a', 'Completed'],
        'cancelled'  => ['#ef4444', 'Cancelled'],
    ] as $status => [$color, $label])
    <div style="display:inline-flex; align-items:center; gap:5px; background:#fff;
                border:1.5px solid #e2e8f0; border-radius:8px; padding:5px 10px;">
        <div style="width:9px; height:9px; border-radius:3px; background:{{ $color }};"></div>
        <span style="font-size:12px; font-weight:500; color:#64748b;">{{ $label }}</span>
    </div>
    @endforeach
</div>

{{-- Calendar card --}}
<div style="background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,0.07); padding:24px;">

    {{-- Controls --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <button id="cal-prev" style="width:34px; height:34px; border-radius:8px; border:1.5px solid #e2e8f0;
                    background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.13s;"
                    onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <span id="cal-title" style="font-size:16px; font-weight:700; color:#0f172a; min-width:160px; text-align:center;"></span>
            <button id="cal-next" style="width:34px; height:34px; border-radius:8px; border:1.5px solid #e2e8f0;
                    background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.13s;"
                    onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <span id="cal-month-count" style="font-size:12px; color:#94a3b8; font-weight:500;"></span>
            <button id="cal-today" style="font-size:12px; font-weight:600; color:#2563eb; background:#eff6ff;
                    border:1.5px solid #bfdbfe; border-radius:8px; padding:7px 14px; cursor:pointer; transition:all 0.13s;"
                    onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                Today
            </button>
        </div>
    </div>

    {{-- Day headers --}}
    <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:6px; margin-bottom:6px;">
        @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
        <div style="text-align:center; font-size:11.5px; font-weight:700; color:#94a3b8;
                    text-transform:uppercase; letter-spacing:0.05em; padding:8px 0;">
            <span class="day-full">{{ $day }}</span>
            <span class="day-short" style="display:none;">{{ substr($day,0,3) }}</span>
        </div>
        @endforeach
    </div>

    {{-- Calendar grid --}}
    <div id="cal-grid" style="display:grid; grid-template-columns:repeat(7,1fr); gap:6px;"></div>

    {{-- Selected day panel --}}
    <div id="cal-panel" style="display:none; margin-top:20px; border-top:1px solid #f1f5f9; padding-top:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
            <p id="cal-panel-title" style="font-size:14px; font-weight:700; color:#0f172a;"></p>
            <button id="cal-panel-close"
                style="font-size:12px; color:#64748b; background:none; border:none; cursor:pointer; padding:4px 8px; border-radius:6px;"
                onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
                ✕ Close
            </button>
        </div>
        <div id="cal-panel-list" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px,1fr)); gap:10px;"></div>
    </div>

</div>

<style>
    @media (max-width: 640px) {
        .day-full  { display: none !important; }
        .day-short { display: inline !important; }
    }
</style>

<script>
(function () {
    const bookings = @json($calendarBookings);

    const byDate = {};
    bookings.forEach(b => {
        if (!byDate[b.date]) byDate[b.date] = [];
        byDate[b.date].push(b);
    });

    const monthNames = ['January','February','March','April','May','June',
                        'July','August','September','October','November','December'];

    const statusColors = {
        pending:    '#f59e0b',
        approved:   '#3b82f6',
        assigned:   '#8b5cf6',
        in_transit: '#06b6d4',
        completed:  '#16a34a',
        cancelled:  '#ef4444',
    };

    let current   = new Date();
    let activeDay = null;

    function pad(n) { return String(n).padStart(2, '0'); }

    function render() {
        const year  = current.getFullYear();
        const month = current.getMonth();

        document.getElementById('cal-title').textContent = monthNames[month] + ' ' + year;

        const grid     = document.getElementById('cal-grid');
        grid.innerHTML = '';

        const firstDay  = new Date(year, month, 1).getDay();
        const daysIn    = new Date(year, month + 1, 0).getDate();
        const today     = new Date();

        // Count bookings this month for the subtitle
        let monthTotal = 0;
        for (let d = 1; d <= daysIn; d++) {
            const ds = year + '-' + pad(month + 1) + '-' + pad(d);
            monthTotal += (byDate[ds] || []).length;
        }
        document.getElementById('cal-month-count').textContent =
            monthTotal + ' booking' + (monthTotal !== 1 ? 's' : '') + ' this month';

        // Empty leading cells
        for (let i = 0; i < firstDay; i++) {
            const blank = document.createElement('div');
            blank.style.minHeight = '90px';
            grid.appendChild(blank);
        }

        for (let d = 1; d <= daysIn; d++) {
            const dateStr     = year + '-' + pad(month + 1) + '-' + pad(d);
            const isToday     = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
            const isActive    = activeDay === dateStr;
            const dayBookings = byDate[dateStr] || [];
            const hasBookings = dayBookings.length > 0;

            const cell = document.createElement('div');
            cell.style.cssText = `
                min-height:90px; border-radius:10px; padding:8px 7px;
                border:1.5px solid ${isActive ? '#2563eb' : (hasBookings ? '#e2e8f0' : '#f8fafc')};
                background:${isActive ? '#eff6ff' : '#fff'};
                cursor:${hasBookings ? 'pointer' : 'default'};
                transition:all 0.13s; overflow:hidden;
            `;

            // Day number bubble
            const num = document.createElement('div');
            num.style.cssText = `
                font-size:13px; font-weight:${isToday ? '800' : '600'};
                color:${isToday ? '#fff' : (isActive ? '#2563eb' : '#334155')};
                width:26px; height:26px; border-radius:7px;
                display:flex; align-items:center; justify-content:center;
                margin-bottom:5px; flex-shrink:0;
                background:${isToday ? '#2563eb' : 'transparent'};
            `;
            num.textContent = d;
            cell.appendChild(num);

            // Booking entries
            if (hasBookings) {
                const show = dayBookings.slice(0, 3);
                show.forEach(b => {
                    const entry = document.createElement('div');
                    entry.style.cssText = `
                        font-size:10.5px; font-weight:600; color:#fff;
                        background:${statusColors[b.status] ?? '#94a3b8'};
                        border-radius:4px; padding:2px 6px; margin-bottom:3px;
                        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
                    `;
                    entry.textContent = b.time + ' ' + b.client;
                    cell.appendChild(entry);
                });

                if (dayBookings.length > 3) {
                    const more = document.createElement('div');
                    more.style.cssText = `
                        font-size:10.5px; font-weight:600; color:#2563eb;
                        background:#eff6ff; border-radius:4px; padding:2px 6px;
                        text-align:center;
                    `;
                    more.textContent = '+' + (dayBookings.length - 3) + ' more';
                    cell.appendChild(more);
                }

                cell.addEventListener('click', () => {
                    activeDay = isActive ? null : dateStr;
                    render();
                    renderPanel(dateStr, dayBookings);
                });

                cell.addEventListener('mouseover', () => {
                    if (!isActive) cell.style.background = '#f0f4ff';
                });
                cell.addEventListener('mouseout', () => {
                    if (!isActive) cell.style.background = '#fff';
                });
            }

            grid.appendChild(cell);
        }
    }

    function renderPanel(dateStr, dayBookings) {
        const panel = document.getElementById('cal-panel');
        const title = document.getElementById('cal-panel-title');
        const list  = document.getElementById('cal-panel-list');

        if (!activeDay) { panel.style.display = 'none'; return; }

        const [y, m, d] = dateStr.split('-');
        const dateObj   = new Date(y, m - 1, d);
        title.textContent = dateObj.toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        }) + ' — ' + dayBookings.length + ' booking' + (dayBookings.length !== 1 ? 's' : '');

        list.innerHTML = '';
        dayBookings.forEach(b => {
            const item = document.createElement('a');
            item.href  = `/admin/bookings/${b.id}`;
            item.style.cssText = `
                display:flex; align-items:center; gap:12px; padding:12px 14px;
                border:1.5px solid #e2e8f0; border-radius:10px; text-decoration:none;
                transition:all 0.13s; background:#fff;
            `;
            item.onmouseover = () => item.style.background = '#f8fafc';
            item.onmouseout  = () => item.style.background = '#fff';
            item.innerHTML = `
                <div style="width:4px; height:44px; border-radius:4px; flex-shrink:0;
                             background:${statusColors[b.status] ?? '#94a3b8'};"></div>
                <div style="flex:1; min-width:0;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:3px;">
                        <span style="font-family:'DM Mono',monospace; font-size:11px;
                                     font-weight:600; color:#2563eb;">${b.booking_number}</span>
                        <span style="font-size:11px; color:#94a3b8;">${b.time}</span>
                    </div>
                    <div style="font-size:13px; font-weight:600; color:#0f172a; margin-bottom:2px;
                                white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        ${b.client}
                    </div>
                    <div style="font-size:12px; color:#64748b; white-space:nowrap;
                                overflow:hidden; text-overflow:ellipsis;">
                        ${b.service} · ${b.pickup}
                    </div>
                </div>
                <div style="flex-shrink:0; text-align:right;">
                    <span style="font-size:11px; font-weight:700; color:#fff;
                                 background:${statusColors[b.status] ?? '#94a3b8'};
                                 border-radius:6px; padding:3px 9px; white-space:nowrap;">
                        ${b.status.replace('_', ' ')}
                    </span>
                    <div style="margin-top:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            `;
            list.appendChild(item);
        });

        panel.style.display = 'block';
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    document.getElementById('cal-prev').addEventListener('click', () => {
        current.setMonth(current.getMonth() - 1);
        activeDay = null;
        document.getElementById('cal-panel').style.display = 'none';
        render();
    });

    document.getElementById('cal-next').addEventListener('click', () => {
        current.setMonth(current.getMonth() + 1);
        activeDay = null;
        document.getElementById('cal-panel').style.display = 'none';
        render();
    });

    document.getElementById('cal-today').addEventListener('click', () => {
        current   = new Date();
        activeDay = null;
        document.getElementById('cal-panel').style.display = 'none';
        render();
    });

    document.getElementById('cal-panel-close').addEventListener('click', () => {
        activeDay = null;
        document.getElementById('cal-panel').style.display = 'none';
        render();
    });

    render();
})();
</script>

@endsection