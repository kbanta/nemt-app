@extends('layouts.app')
@section('title', 'All Notifications')
@section('content')
<div class="card" style="overflow:hidden;">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9;">
        <h2 style="margin:0; font-size:15px; font-weight:700; color:#0f172a;">All Notifications</h2>
    </div>
    @forelse($notifications as $notif)
        <div style="padding:14px 20px; border-bottom:1px solid #f8fafc;
                    display:flex; gap:12px; align-items:flex-start;
                    {{ $notif->read_at ? '' : 'background:#fafbff;' }}">
            <span style="margin-top:5px; width:7px; height:7px; border-radius:50%; flex-shrink:0;
                         background:{{ $notif->read_at ? '#cbd5e1' : '#3b82f6' }};"></span>
            <div>
                <p style="margin:0 0 3px; font-size:13px; font-weight:500; color:#1e293b;">
                    {{ $notif->data['message'] }}
                </p>
                <p style="margin:0; font-size:11.5px; color:#94a3b8;">
                    {{ $notif->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    @empty
        <div style="padding:40px; text-align:center; color:#94a3b8; font-size:13px;">
            No notifications yet.
        </div>
    @endforelse
    <div style="padding:14px 20px;">{{ $notifications->links() }}</div>
</div>
@endsection