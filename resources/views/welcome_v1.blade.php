<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedRide — Non-Emergency Medical Transportation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,700;1,9..144,300&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:     #0b1a2e;
            --navy-mid: #132340;
            --navy-soft:#1e3459;
            --blue:     #1d6ef5;
            --blue-lt:  #3d84f7;
            --sky:      #e8f1fe;
            --cream:    #f7f5f1;
            --text:     #0b1a2e;
            --muted:    #5c6b82;
            --border:   #dde3ed;
            --white:    #ffffff;
            --green:    #1a9e6e;
            --green-lt: #e6f7f2;
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--white);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── NAV ─────────────────────────────────────────── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 0 5vw;
            height: 68px;
            display: flex; align-items: center; justify-content: space-between;
            transition: background 0.3s, box-shadow 0.3s, border-color 0.3s;
        }

        nav.scrolled {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 0 var(--border);
        }

        nav.scrolled .nav-brand-text { color: var(--navy); }
        nav.scrolled .nav-links a    { color: var(--muted); }
        nav.scrolled .nav-links a:hover { color: var(--navy); }
        nav.scrolled .btn-outline    { color: var(--navy); border-color: var(--border); }
        nav.scrolled .btn-outline:hover { background: var(--cream); }

        /* transparent nav on hero */
        nav.hero-nav .nav-brand-text  { color: #fff; }
        nav.hero-nav .nav-brand-mark  { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); }
        nav.hero-nav .nav-links a     { color: rgba(255,255,255,0.75); }
        nav.hero-nav .nav-links a:hover { color: #fff; }
        nav.hero-nav .btn-outline     { color: #fff; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.08); }
        nav.hero-nav .btn-outline:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.5); }

        /* logged-in avatar chip on dark nav */
        nav.hero-nav .user-chip {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }
        nav.hero-nav .user-chip-name { color: rgba(255,255,255,0.9); }

        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
            z-index: 1;
        }
        .nav-brand-mark {
            width: 36px; height: 36px;
            background: var(--navy);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: background 0.3s, border 0.3s;
        }
        .nav-brand-text {
            font-family: 'Fraunces', serif;
            font-size: 20px; font-weight: 700;
            color: var(--navy);
            letter-spacing: -0.02em;
            transition: color 0.3s;
        }

        .nav-links {
            display: flex; align-items: center; gap: 32px;
            list-style: none;
        }
        .nav-links a {
            text-decoration: none; font-size: 14px; font-weight: 500;
            color: var(--muted); transition: color 0.15s;
        }
        .nav-links a:hover { color: var(--text); }

        .nav-cta { display: flex; align-items: center; gap: 10px; }

        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 20px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            text-decoration: none; transition: all 0.15s;
            border: none; cursor: pointer; white-space: nowrap;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-outline {
            background: transparent; color: var(--navy);
            border: 1.5px solid var(--border);
            transition: all 0.2s;
        }
        .btn-primary {
            background: var(--blue); color: #fff;
            box-shadow: 0 1px 3px rgba(29,110,245,0.3), 0 4px 12px rgba(29,110,245,0.15);
        }
        .btn-primary:hover {
            background: #1660e0;
            box-shadow: 0 2px 6px rgba(29,110,245,0.35), 0 6px 20px rgba(29,110,245,0.2);
            transform: translateY(-1px);
        }

        .user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(0,0,0,0.04);
            border: 1px solid var(--border);
            padding: 5px 12px 5px 6px;
            border-radius: 999px;
            transition: all 0.2s;
        }
        .user-chip-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: linear-gradient(135deg,#2563eb,#6d28d9);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .user-chip-name {
            font-size: 13px; font-weight: 600; color: var(--text);
            white-space: nowrap; max-width: 120px;
            overflow: hidden; text-overflow: ellipsis;
            transition: color 0.2s;
        }

        /* ── HERO ─────────────────────────────────────────── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex; align-items: center;
            overflow: hidden;
        }

        /* Real photo background */
        .hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background-image: url('https://eliteextra.com/wp-content/uploads/2022/06/AdobeStock_386147368-1536x910.jpeg');
            background-size: cover;
            background-position: center 30%;
            transform: scale(1.04);
            transition: transform 8s ease;
        }
        .hero-bg.loaded { transform: scale(1); }

        /* Multi-layer overlay for text readability */
        .hero-overlay {
            position: absolute; inset: 0; z-index: 1;
            background:
                linear-gradient(105deg, rgba(8,20,44,0.88) 0%, rgba(8,20,44,0.7) 50%, rgba(8,20,44,0.25) 100%),
                linear-gradient(to top, rgba(8,20,44,0.6) 0%, transparent 50%);
        }

        .hero-inner {
            position: relative; z-index: 2;
            max-width: 1160px; margin: 0 auto; width: 100%;
            padding: 140px 5vw 100px;
            display: grid; grid-template-columns: 1fr 420px; gap: 80px; align-items: center;
        }

        .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(29,110,245,0.2);
            border: 1px solid rgba(29,110,245,0.4);
            color: #93c0fd;
            font-size: 11.5px; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase;
            padding: 5px 14px; border-radius: 999px;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-family: 'Fraunces', serif;
            font-size: clamp(38px, 4.5vw, 60px);
            font-weight: 500; color: #fff;
            line-height: 1.1; letter-spacing: -0.03em;
            margin-bottom: 24px;
        }
        .hero h1 em {
            font-style: italic; font-weight: 300;
            color: #7eb3fb;
        }

        .hero-sub {
            font-size: 17px; color: rgba(255,255,255,0.6);
            line-height: 1.7; margin-bottom: 40px; max-width: 460px;
        }

        .hero-actions { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }

        .btn-hero-primary {
            background: var(--blue); color: #fff;
            padding: 15px 30px; border-radius: 11px;
            font-size: 15px; font-weight: 600;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 20px rgba(29,110,245,0.45);
            transition: all 0.15s;
        }
        .btn-hero-primary:hover {
            background: #1660e0; transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(29,110,245,0.55);
        }

        .btn-hero-ghost {
            color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 500;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
            transition: color 0.15s;
            border: 1.5px solid rgba(255,255,255,0.2);
            padding: 14px 22px; border-radius: 11px;
        }
        .btn-hero-ghost:hover { color: #fff; border-color: rgba(255,255,255,0.45); }

        .hero-trust {
            margin-top: 52px; padding-top: 36px;
            border-top: 1px solid rgba(255,255,255,0.12);
            display: flex; align-items: center; gap: 28px; flex-wrap: wrap;
        }
        .trust-divider { width: 1px; height: 30px; background: rgba(255,255,255,0.15); }
        .trust-item { font-size: 13px; color: rgba(255,255,255,0.5); }
        .trust-num { font-size: 22px; font-weight: 700; color: #fff; display: block; line-height: 1.1; }

        /* Hero panel (right side card) */
        .hero-panel {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; padding: 28px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .panel-head {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em;
            color: rgba(255,255,255,0.35); margin-bottom: 18px;
        }

        .service-pill {
            display: flex; align-items: center; gap: 12px;
            padding: 13px 15px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px; margin-bottom: 8px;
            transition: background 0.15s; cursor: default;
        }
        .service-pill:hover { background: rgba(255,255,255,0.1); }

        .pill-icon {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(29,110,245,0.2);
            border: 1px solid rgba(29,110,245,0.3);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .pill-label { font-size: 13.5px; font-weight: 500; color: rgba(255,255,255,0.88); }
        .pill-sub   { font-size: 11.5px; color: rgba(255,255,255,0.4); margin-top: 1px; }
        .pill-price { margin-left: auto; font-size: 13px; font-weight: 600; color: #7eb3fb; }

        /* Hero scroll indicator */
        .scroll-hint {
            position: absolute; bottom: 36px; left: 50%; transform: translateX(-50%);
            z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 6px;
            color: rgba(255,255,255,0.35); font-size: 11px; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase;
            animation: bounce 2.5s ease infinite;
        }
        @keyframes bounce {
            0%,100% { transform: translateX(-50%) translateY(0); }
            50%      { transform: translateX(-50%) translateY(6px); }
        }

        /* ── HOW IT WORKS ─────────────────────────────────── */
        .section { padding: 96px 5vw; }
        .section-inner { max-width: 1160px; margin: 0 auto; }

        .section-tag {
            display: inline-block; font-size: 12px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--blue); margin-bottom: 14px;
        }
        .section-title {
            font-family: 'Fraunces', serif;
            font-size: clamp(28px, 3vw, 40px); font-weight: 500;
            letter-spacing: -0.025em; color: var(--navy);
            margin-bottom: 16px; line-height: 1.2;
        }
        .section-sub { font-size: 17px; color: var(--muted); max-width: 500px; line-height: 1.65; }
        .section-header {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 56px; flex-wrap: wrap; gap: 24px;
        }

        .steps-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 0; position: relative;
        }
        .steps-connector {
            position: absolute; top: 32px; left: 12.5%; right: 12.5%; height: 1px;
            background: repeating-linear-gradient(90deg, var(--border) 0px, var(--border) 8px, transparent 8px, transparent 18px);
        }
        .step-card { padding: 0 28px 0 0; position: relative; }
        .step-card:last-child { padding-right: 0; }
        .step-num {
            width: 56px; height: 56px; border-radius: 14px;
            background: var(--navy); color: #fff;
            font-family: 'Fraunces', serif; font-size: 20px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px; position: relative; z-index: 1;
        }
        .step-card:nth-child(2) .step-num { background: var(--blue); }
        .step-card:nth-child(3) .step-num { background: var(--navy-soft); }
        .step-card:nth-child(4) .step-num { background: var(--green); }
        .step-title { font-size: 16px; font-weight: 600; margin-bottom: 8px; color: var(--navy); }
        .step-body  { font-size: 14px; color: var(--muted); line-height: 1.6; }

        /* ── SERVICES ────────────────────────────────────── */
        .section-alt { background: var(--cream); }
        .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .service-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: 16px; padding: 28px;
            transition: all 0.2s; position: relative; overflow: hidden;
        }
        .service-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--blue); transform: scaleX(0); transform-origin: left; transition: transform 0.25s;
        }
        .service-card:hover { border-color: transparent; box-shadow: 0 8px 32px rgba(11,26,46,0.1); transform: translateY(-3px); }
        .service-card:hover::before { transform: scaleX(1); }
        .service-icon-wrap {
            width: 52px; height: 52px; background: var(--sky);
            border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;
        }
        .service-card h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; color: var(--navy); }
        .service-card p  { font-size: 14px; color: var(--muted); line-height: 1.6; margin-bottom: 16px; }
        .service-price {
            font-size: 13px; font-weight: 600; color: var(--blue);
            display: flex; align-items: center; gap: 6px;
        }

        /* ── WHY US ──────────────────────────────────────── */
        .why-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
        .why-visual { background: var(--navy); border-radius: 20px; padding: 36px; color: #fff; }
        .why-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 28px; }
        .why-stat {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px; padding: 20px;
        }
        .why-stat-num   { font-family: 'Fraunces', serif; font-size: 32px; font-weight: 700; color: #fff; line-height: 1; }
        .why-stat-label { font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 6px; }
        .why-features   { list-style: none; }
        .why-feature {
            display: flex; align-items: flex-start; gap: 16px;
            padding: 20px 0; border-bottom: 1px solid var(--border);
        }
        .why-feature:last-child { border-bottom: none; }
        .feature-icon {
            width: 42px; height: 42px; background: var(--sky);
            border-radius: 11px; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 2px;
        }
        .feature-title { font-size: 15px; font-weight: 600; margin-bottom: 4px; color: var(--navy); }
        .feature-body  { font-size: 14px; color: var(--muted); line-height: 1.55; }

        /* ── TESTIMONIALS ────────────────────────────────── */
        .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .testimonial-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: 16px; padding: 28px;
        }
        .stars { display: flex; gap: 3px; margin-bottom: 16px; }
        .star  { width: 14px; height: 14px; }
        .testimonial-text {
            font-size: 15px; color: var(--text); line-height: 1.65;
            margin-bottom: 20px; font-style: italic;
            font-family: 'Fraunces', serif; font-weight: 300;
        }
        .testimonial-author { display: flex; align-items: center; gap: 12px; }
        .author-avatar {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .author-name { font-size: 14px; font-weight: 600; color: var(--navy); }
        .author-role { font-size: 12px; color: var(--muted); }

        /* ── CTA BAND ────────────────────────────────────── */
        .cta-band { background: var(--navy); padding: 80px 5vw; }
        .cta-inner {
            max-width: 1160px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            gap: 40px; flex-wrap: wrap;
        }
        .cta-band h2 {
            font-family: 'Fraunces', serif;
            font-size: clamp(26px, 2.8vw, 38px); font-weight: 500;
            color: #fff; letter-spacing: -0.025em; margin-bottom: 12px;
        }
        .cta-band p { font-size: 16px; color: rgba(255,255,255,0.5); }
        .cta-actions { display: flex; gap: 12px; align-items: center; flex-shrink: 0; }
        .btn-cta-white {
            background: #fff; color: var(--navy);
            padding: 13px 28px; border-radius: 10px; font-size: 14px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.15s;
        }
        .btn-cta-white:hover { background: #f0f4ff; transform: translateY(-1px); }
        .btn-cta-ghost {
            color: rgba(255,255,255,0.6); padding: 13px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 500; text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.15); transition: all 0.15s;
        }
        .btn-cta-ghost:hover { color: #fff; border-color: rgba(255,255,255,0.35); }

        /* ── FOOTER ──────────────────────────────────────── */
        footer {
            background: var(--navy); border-top: 1px solid rgba(255,255,255,0.07);
            padding: 48px 5vw 36px;
        }
        .footer-inner {
            max-width: 1160px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 20px;
        }
        .footer-copy { font-size: 13px; color: rgba(255,255,255,0.3); }
        .footer-links { display: flex; gap: 24px; }
        .footer-links a {
            font-size: 13px; color: rgba(255,255,255,0.35);
            text-decoration: none; transition: color 0.15s;
        }
        .footer-links a:hover { color: rgba(255,255,255,0.7); }

        /* ── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 960px) {
            .hero-inner { grid-template-columns: 1fr; gap: 48px; padding: 120px 5vw 80px; }
            .hero-panel { display: none; }
            .steps-grid { grid-template-columns: 1fr 1fr; }
            .steps-connector { display: none; }
            .services-grid { grid-template-columns: 1fr 1fr; }
            .why-grid { grid-template-columns: 1fr; }
            .testimonials-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .nav-links { display: none; }
            .services-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }
            .hero-trust { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

<!-- ─── NAVIGATION ─────────────────────────────────── -->
<nav id="main-nav" class="hero-nav">
    <a href="/" class="nav-brand">
        <div class="nav-brand-mark">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12h4l3-9 4 18 3-9h4"/>
            </svg>
        </div>
        <span class="nav-brand-text">MedRide</span>
    </a>

    <ul class="nav-links">
        <li><a href="#services">Services</a></li>
        <li><a href="#how-it-works">How it works</a></li>
        <li><a href="#why-us">Why us</a></li>
    </ul>

    <div class="nav-cta">
        @if($isLoggedIn)
            <div style="display:flex; align-items:center; gap:10px;">
                <div class="user-chip">
                    <div class="user-chip-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <span class="user-chip-name">{{ explode(' ', $user->name)[0] }}</span>
                </div>
                @php
                    $dashboard = match($user->role) {
                        'admin'  => route('admin.dashboard'),
                        'driver' => route('driver.dashboard'),
                        default  => route('client.dashboard'),
                    };
                @endphp
                <a href="{{ $dashboard }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="display:inline-flex;align-items:center;gap:7px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline">Sign in</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Book a ride</a>
        @endif
    </div>
</nav>


<!-- ─── HERO ───────────────────────────────────────── -->
<section class="hero">
    {{-- Real NEMT photo background --}}
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-inner">
        <div>
            <div class="hero-tag">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Available 24 hours a day
            </div>

            <h1>
                Medical transport<br>
                that <em>actually</em><br>shows up.
            </h1>

            <p class="hero-sub">
                Reliable, compassionate non-emergency medical transportation for patients who need more than a standard ride — wheelchair, stretcher, bariatric, and ambulatory.
            </p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-hero-primary">
                    Book a ride
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#how-it-works" class="btn-hero-ghost">
                    See how it works
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                </a>
            </div>

            <div class="hero-trust">
                <div class="trust-item">
                    <span class="trust-num">4,800+</span>
                    trips completed
                </div>
                <div class="trust-divider"></div>
                <div class="trust-item">
                    <span class="trust-num">98%</span>
                    on-time rate
                </div>
                <div class="trust-divider"></div>
                <div class="trust-item">
                    <span class="trust-num">5-star</span>
                    avg. rating
                </div>
            </div>
        </div>

        {{-- Right panel --}}
        <div class="hero-panel">
            <p class="panel-head">Available services</p>

            <div class="service-pill">
                <div class="pill-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#7eb3fb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="7" r="4"/><path d="M5.5 21a7 7 0 0 1 13 0"/>
                    </svg>
                </div>
                <div>
                    <div class="pill-label">Ambulatory</div>
                    <div class="pill-sub">Walk-in assistance</div>
                </div>
                <div class="pill-price">from $25</div>
            </div>

            <div class="service-pill">
                <div class="pill-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#7eb3fb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/>
                        <path d="M5 17H3V5a2 2 0 0 1 2-2h11v4"/><path d="M9 17h6l2-7H7l2 7z"/>
                    </svg>
                </div>
                <div>
                    <div class="pill-label">Wheelchair</div>
                    <div class="pill-sub">Equipped vehicle</div>
                </div>
                <div class="pill-price">from $40</div>
            </div>

            <div class="service-pill">
                <div class="pill-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#7eb3fb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="9" width="20" height="8" rx="2"/>
                        <path d="M6 9V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3"/>
                        <line x1="12" y1="12" x2="12" y2="14"/>
                    </svg>
                </div>
                <div>
                    <div class="pill-label">Stretcher / Gurney</div>
                    <div class="pill-sub">Lying-down transport</div>
                </div>
                <div class="pill-price">from $75</div>
            </div>

            <div class="service-pill">
                <div class="pill-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#7eb3fb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <div>
                    <div class="pill-label">Bariatric</div>
                    <div class="pill-sub">Specialized equipment</div>
                </div>
                <div class="pill-price">from $90</div>
            </div>

            <div style="margin-top:20px; padding:14px 16px; background:rgba(26,158,110,0.12); border:1px solid rgba(26,158,110,0.25); border-radius:12px; display:flex; align-items:center; gap:12px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#4fd1a5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span style="font-size:12.5px; color:rgba(255,255,255,0.6);">Secure Stripe payment · Instant confirmation</span>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="scroll-hint">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
        </svg>
    </div>
</section>


<!-- ─── HOW IT WORKS ────────────────────────────────── -->
<section class="section" id="how-it-works">
    <div class="section-inner">
        <div class="section-header">
            <div>
                <span class="section-tag">Process</span>
                <h2 class="section-title">From booking to destination<br>in four simple steps</h2>
            </div>
            <p class="section-sub">No phone queues. No paperwork. Book online and we handle the rest.</p>
        </div>
        <div class="steps-grid">
            <div class="steps-connector"></div>
            <div class="step-card">
                <div class="step-num">1</div>
                <h3 class="step-title">Create your booking</h3>
                <p class="step-body">Select a service type, enter your pickup and drop-off locations, choose your date and time.</p>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <h3 class="step-title">Pay securely online</h3>
                <p class="step-body">Pay via Stripe Checkout. Your booking is instantly confirmed with a receipt emailed to you.</p>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <h3 class="step-title">Driver is assigned</h3>
                <p class="step-body">Our team assigns a verified, trained driver matched to your specific transport needs.</p>
            </div>
            <div class="step-card">
                <div class="step-num">4</div>
                <h3 class="step-title">Track in real time</h3>
                <p class="step-body">Receive status updates at every stage — assigned, in transit, and completed.</p>
            </div>
        </div>
    </div>
</section>


<!-- ─── SERVICES ───────────────────────────────────── -->
<section class="section section-alt" id="services">
    <div class="section-inner">
        <div class="section-header">
            <div>
                <span class="section-tag">Services</span>
                <h2 class="section-title">Every level of<br>medical transport covered</h2>
            </div>
            <a href="{{ route('register') }}" class="btn btn-primary">View pricing</a>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a7 7 0 0 1 13 0"/></svg>
                </div>
                <h3>Ambulatory Transport</h3>
                <p>For patients who can walk but need assistance boarding and navigating. Our drivers provide hands-on support throughout the journey.</p>
                <div class="service-price">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    From $25 + $2.50/mile
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/><path d="M5 17H3V5a2 2 0 0 1 2-2h11v4"/><path d="M9 17h6l2-7H7l2 7z"/></svg>
                </div>
                <h3>Wheelchair Transport</h3>
                <p>Vehicles fitted with ramps and securements for manual and powered wheelchair users. Fully compliant with ADA accessibility standards.</p>
                <div class="service-price">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    From $40 + $3.00/mile
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="10" rx="2"/><path d="M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/><line x1="12" y1="11" x2="12" y2="13"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                </div>
                <h3>Stretcher Transport</h3>
                <p>For patients who must remain lying down throughout their journey. Equipped vans with trained two-person crews for safe loading and transit.</p>
                <div class="service-price">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    From $75 + $4.50/mile
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <h3>Bariatric Transport</h3>
                <p>Specially equipped vehicles and trained staff for patients with higher weight requirements. Extra-wide doors, reinforced lifts, and specialized seating.</p>
                <div class="service-price">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    From $90 + $5.00/mile
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="10" rx="2"/><path d="M8 8V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M12 12v2"/></svg>
                </div>
                <h3>Gurney Transport</h3>
                <p>Non-emergency gurney-level care for patients transferred between care facilities, nursing homes, or rehabilitation centers.</p>
                <div class="service-price">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    From $80 + $4.00/mile
                </div>
            </div>
            <div class="service-card" style="background:var(--navy);border-color:transparent;display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div class="service-icon-wrap" style="background:rgba(255,255,255,0.1);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7eb3fb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h3 style="color:#fff;">Not sure which service?</h3>
                    <p style="color:rgba(255,255,255,0.5);">Tell us your situation and we'll recommend the right transport type for your specific needs.</p>
                </div>
                <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:6px;color:#7eb3fb;font-size:14px;font-weight:600;text-decoration:none;margin-top:16px;">
                    Get a recommendation
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- ─── WHY US ──────────────────────────────────────── -->
<section class="section" id="why-us">
    <div class="section-inner">
        <div class="why-grid">
            <div class="why-visual">
                <span class="section-tag" style="color:#7eb3fb;">Our record</span>
                <h2 style="font-family:'Fraunces',serif;font-size:26px;font-weight:500;color:#fff;letter-spacing:-0.02em;margin:12px 0 0;">Numbers that<br><em style="font-style:italic;font-weight:300;color:#7eb3fb;">speak for themselves.</em></h2>
                <div class="why-stat-grid">
                    <div class="why-stat"><div class="why-stat-num">4,800+</div><div class="why-stat-label">Trips completed</div></div>
                    <div class="why-stat"><div class="why-stat-num">98%</div><div class="why-stat-label">On-time arrivals</div></div>
                    <div class="why-stat"><div class="why-stat-num">120+</div><div class="why-stat-label">Certified drivers</div></div>
                    <div class="why-stat"><div class="why-stat-num">24/7</div><div class="why-stat-label">Availability</div></div>
                </div>
            </div>
            <div>
                <span class="section-tag">Why MedRide</span>
                <h2 class="section-title">Built for patients,<br>not just passengers</h2>
                <ul class="why-features">
                    <li class="why-feature">
                        <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                        <div><div class="feature-title">Verified, trained drivers</div><div class="feature-body">Every driver completes background checks, CPR certification, and sensitivity training before their first trip.</div></div>
                    </li>
                    <li class="why-feature">
                        <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
                        <div><div class="feature-title">Transparent, upfront pricing</div><div class="feature-body">See the full fare before you pay. No surge pricing, no hidden fees — ever. Invoices available for insurance claims.</div></div>
                    </li>
                    <li class="why-feature">
                        <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg></div>
                        <div><div class="feature-title">Live status updates</div><div class="feature-body">Track your booking from confirmation to arrival. Get notified the moment your driver is assigned and en route.</div></div>
                    </li>
                    <li class="why-feature">
                        <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1d6ef5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <div><div class="feature-title">Reliable scheduling</div><div class="feature-body">Book days in advance or same-day. We accommodate recurring appointments, dialysis runs, and hospital discharges.</div></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- ─── TESTIMONIALS ───────────────────────────────── -->
<section class="section section-alt">
    <div class="section-inner">
        <div class="section-header">
            <div>
                <span class="section-tag">Patient stories</span>
                <h2 class="section-title">Trusted by patients<br>and their families</h2>
            </div>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">@for($i=0;$i<5;$i++)<svg class="star" viewBox="0 0 24 24" fill="#f59e0b" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor</div>
                <p class="testimonial-text">"After my knee replacement, I needed transport to physical therapy three times a week. MedRide was on time every single visit. The driver always helped me to the door — I never had to worry."</p>
                <div class="testimonial-author"><div class="author-avatar" style="background:#1d6ef5;">BM</div><div><div class="author-name">Barbara M.</div><div class="author-role">Patient, knee replacement recovery</div></div></div>
            </div>
            <div class="testimonial-card">
                <div class="stars">@for($i=0;$i<5;$i++)<svg class="star" viewBox="0 0 24 24" fill="#f59e0b" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor</div>
                <p class="testimonial-text">"My father is in a wheelchair and previous transport services were unreliable. MedRide showed up early, the driver knew exactly how to secure his chair, and the online booking was so simple my dad can do it himself."</p>
                <div class="testimonial-author"><div class="author-avatar" style="background:#059669;">JT</div><div><div class="author-name">James T.</div><div class="author-role">Family caregiver</div></div></div>
            </div>
            <div class="testimonial-card">
                <div class="stars">@for($i=0;$i<5;$i++)<svg class="star" viewBox="0 0 24 24" fill="#f59e0b" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor</div>
                <p class="testimonial-text">"I coordinate transport for a dialysis center. We switched our patients to MedRide six months ago. The driver tracking, PDF invoices for billing, and the 98% on-time rate have made our operations so much smoother."</p>
                <div class="testimonial-author"><div class="author-avatar" style="background:#7c3aed;">RG</div><div><div class="author-name">Rosa G.</div><div class="author-role">Dialysis center coordinator</div></div></div>
            </div>
        </div>
    </div>
</section>


<!-- ─── CTA BAND ────────────────────────────────────── -->
<div class="cta-band">
    <div class="cta-inner">
        <div>
            <h2>Ready to book your first ride?</h2>
            <p>Create an account in under two minutes. No subscription required.</p>
        </div>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-cta-white">
                Get started
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('login') }}" class="btn-cta-ghost">Sign in</a>
        </div>
    </div>
</div>


<!-- ─── FOOTER ──────────────────────────────────────── -->
<footer>
    <div class="footer-inner">
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="nav-brand-mark">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l3-9 4 18 3-9h4"/></svg>
            </div>
            <span class="footer-copy">© {{ date('Y') }} MedRide. All rights reserved.</span>
        </div>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Contact</a>
            <a href="{{ route('login') }}">Driver portal</a>
        </div>
    </div>
</footer>

<script>
    // ── Transparent → solid nav on scroll ──────────────
    const nav = document.getElementById('main-nav');
    const heroHeight = document.querySelector('.hero').offsetHeight;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 60) {
            nav.classList.remove('hero-nav');
            nav.classList.add('scrolled');
        } else {
            nav.classList.add('hero-nav');
            nav.classList.remove('scrolled');
        }
    }, { passive: true });

    // ── Subtle hero parallax ────────────────────────────
    const heroBg = document.getElementById('heroBg');
    window.addEventListener('scroll', () => {
        const offset = window.scrollY;
        if (offset < heroHeight) {
            heroBg.style.transform = `translateY(${offset * 0.3}px)`;
        }
    }, { passive: true });

    // ── Trigger zoom-out animation once loaded ──────────
    window.addEventListener('load', () => {
        heroBg.classList.add('loaded');
    });
</script>

</body>
</html>