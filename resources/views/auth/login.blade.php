<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — MedRide</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Barlow+Condensed:wght@400;500;600;700;800&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --ink: #0d1624;
            --forest: #1547a8;
            --moss: #1d5ccc;
            --sage: #4a86e8;
            --mint: #bdd4f8;
            --paper: #f0f4fc;
            --cream: #f6f8fd;
            --warm: #e2eaf8;
            --red: #d63030;
            --red-lt: #ff4444;
            --muted: #5a6680;
            --border: #c8d4e8;
            --white: #ffffff;
        }

        html,
        body {
            height: 100%;
            font-family: 'Barlow', sans-serif;
            -webkit-font-smoothing: antialiased;
            color: var(--ink);
        }

        body {
            display: flex;
            min-height: 100vh;
            background: var(--ink);
        }

        /* ── LAYOUT ─────────────────────────────────── */
        .page {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ── LEFT SIDE ──────────────────────────────── */
        .left {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .left-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://eliteextra.com/wp-content/uploads/2022/06/AdobeStock_386147368-1536x910.jpeg');
            background-size: cover;
            background-position: center 25%;
            opacity: 0.38;
            mix-blend-mode: luminosity;
        }

        .left-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right, rgba(8, 17, 31, 0.88) 0%, rgba(8, 17, 31, 0.6) 60%, rgba(8, 17, 31, 0.2) 100%),
                linear-gradient(to top, rgba(8, 17, 31, 0.9) 0%, transparent 55%);
        }

        .left-inner {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 44px 52px;
        }

        /* Logo */
        .site-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: auto;
        }

        .logo-mark {
            width: 34px;
            height: 34px;
            background: var(--red);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-mark img {
            height: 34px;
            width: auto;
            display: block;
        }

        .logo-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #fff;
        }

        /* Left bottom content */
        .left-foot {
            margin-top: auto;
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 22px;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--red-lt);
            box-shadow: 0 0 8px rgba(255, 68, 68, 0.6);
            animation: livepulse 2s ease infinite;
            flex-shrink: 0;
        }

        @keyframes livepulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.35;
                transform: scale(0.65);
            }
        }

        .left-heading {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(34px, 3.5vw, 54px);
            font-weight: 700;
            line-height: 1.06;
            letter-spacing: -0.025em;
            color: #fff;
            margin-bottom: 22px;
        }

        .left-heading em {
            font-style: italic;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.75);
        }

        .left-desc {
            font-size: 15px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 36px;
        }

        .left-stats {
            display: flex;
            gap: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 28px;
        }

        .left-stat {
            padding-right: 36px;
            margin-right: 36px;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .left-stat:last-child {
            border-right: none;
            margin-right: 0;
            padding-right: 0;
        }

        .stat-n {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -0.01em;
        }

        .stat-l {
            font-size: 11px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.38);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 4px;
        }

        /* Ticker at very bottom */
        .left-ticker {
            margin-top: 36px;
            overflow: hidden;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            padding-top: 14px;
        }

        .ticker-row {
            display: flex;
            gap: 0;
            animation: tickmove 22s linear infinite;
            width: max-content;
        }

        .ticker-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 28px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            white-space: nowrap;
        }

        .ticker-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--red-lt);
        }

        @keyframes tickmove {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* ── RIGHT SIDE ─────────────────────────────── */
        .right {
            width: 500px;
            flex-shrink: 0;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 56px;
            position: relative;
        }

        /* Red top accent line */
        .right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--red);
        }

        .back-link {
            position: absolute;
            top: 36px;
            left: 56px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .back-link:hover {
            color: var(--ink);
        }

        .back-link svg {
            opacity: 0.5;
        }

        .right-register-link {
            position: absolute;
            top: 36px;
            right: 56px;
            font-size: 13px;
            color: var(--muted);
        }

        .right-register-link a {
            color: var(--forest);
            font-weight: 600;
            text-decoration: none;
        }

        .right-register-link a:hover {
            text-decoration: underline;
        }

        /* Form header */
        .form-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 12px;
        }

        .form-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: var(--ink);
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 14px;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.65;
            margin-bottom: 38px;
        }

        /* Status message */
        .status-msg {
            background: var(--paper);
            border: 1px solid var(--border);
            border-left: 3px solid var(--forest);
            border-radius: 3px;
            padding: 12px 16px;
            font-size: 13px;
            color: var(--forest);
            margin-bottom: 24px;
            font-weight: 500;
        }

        /* Fields */
        .field {
            margin-bottom: 20px;
        }

        .field-label {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .field-input {
            width: 100%;
            padding: 13px 16px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 4px;
            font-family: 'Barlow', sans-serif;
            font-size: 15px;
            font-weight: 400;
            color: var(--ink);
            outline: none;
            transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
            appearance: none;
        }

        .field-input::placeholder {
            color: #b8c6d9;
        }

        .field-input:focus {
            border-color: var(--forest);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(21, 71, 168, 0.1);
        }

        .field-input.error {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(214, 48, 48, 0.08);
        }

        .field-error {
            font-size: 12px;
            color: var(--red);
            font-weight: 500;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Password wrapper with show/hide */
        .pw-wrap {
            position: relative;
        }

        .pw-wrap .field-input {
            padding-right: 48px;
        }

        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .pw-toggle:hover {
            color: var(--ink);
        }

        /* Remember + forgot row */
        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }

        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 3px;
            accent-color: var(--forest);
            cursor: pointer;
            flex-shrink: 0;
        }

        .forgot {
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.15s;
        }

        .forgot:hover {
            color: var(--forest);
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--red);
            color: #fff;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: all 0.15s;
            box-shadow: 0 4px 16px rgba(214, 48, 48, 0.28);
        }

        .btn-submit:hover {
            background: #bf2020;
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(214, 48, 48, 0.38);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 26px 0 20px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--border);
        }

        /* Bottom register */
        .bottom-register {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        .bottom-register a {
            color: var(--forest);
            font-weight: 600;
            text-decoration: none;
        }

        .bottom-register a:hover {
            text-decoration: underline;
        }

        /* Trust row at bottom of form */
        .form-trust {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--paper);
        }

        .trust-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--muted);
            font-weight: 400;
        }

        .trust-chip svg {
            flex-shrink: 0;
        }

        /* ── RESPONSIVE ─────────────────────────────── */
        @media (max-width: 960px) {
            .left {
                display: none;
            }

            .right {
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            .right {
                padding: 60px 28px 48px;
            }

            .back-link,
            .right-register-link {
                display: none;
            }
        }
        /* Hero: show white, hide black */
        nav.dark-nav .logo-light {
            display: block;
        }

        nav.dark-nav .logo-dark {
            display: none;
        }

        /* Scrolled: show black, hide white */
        nav.scrolled .logo-light {
            display: none;
        }

        nav.scrolled .logo-dark {
            display: block;
        }

        .logo-img {
            height: 54px;
            width: auto;
            display: block;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- ── LEFT ──────────────────────────────── -->
        <div class="left">
            <div class="left-bg"></div>
            <div class="left-overlay"></div>
            <div class="left-inner">

                <a href="/" class="logo-img">
                    <img src="{{ asset('images/lg-white.png') }}" alt="MedRide" class="logo-img logo-light">
                    <!-- <img src="{{ asset('images/lg-black.png') }}" alt="MedRide" class="logo-img logo-dark"> -->
                </a>

                <div class="left-foot">
                    <div class="live-badge">
                        <span class="live-dot"></span>
                        Dispatching now · 24 / 7
                    </div>

                    <h2 class="left-heading">
                        Safety is our<br><em>utmost priority.</em>
                    </h2>

                    <p class="left-desc">
                        Non-emergency medical transportation — wheelchair, stretcher, bariatric, and ambulatory. Book online or call us directly.
                    </p>

                    <div class="left-stats">
                        <div class="left-stat">
                            <div class="stat-n">4,800+</div>
                            <div class="stat-l">Trips done</div>
                        </div>
                        <div class="left-stat">
                            <div class="stat-n">98%</div>
                            <div class="stat-l">On-time rate</div>
                        </div>
                        <div class="left-stat">
                            <div class="stat-n">24/7</div>
                            <div class="stat-l">Dispatch</div>
                        </div>
                    </div>

                    <div class="left-ticker">
                        <div class="ticker-row">
                            <div class="ticker-item"><span style="background:var(--red);color:#fff;font-size:9px;font-weight:800;padding:2px 7px;border-radius:2px;letter-spacing:0.1em;">LIVE</span> Dispatching now</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Ambulatory transport</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Wheelchair equipped</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Stretcher &amp; gurney</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Bariatric certified</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> 98% on-time arrivals</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> CPR-certified drivers</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Secure payments</div>
                            <div class="ticker-item"><span style="background:var(--red);color:#fff;font-size:9px;font-weight:800;padding:2px 7px;border-radius:2px;letter-spacing:0.1em;">LIVE</span> Dispatching now</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Ambulatory transport</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Wheelchair equipped</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Stretcher &amp; gurney</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Bariatric certified</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> 98% on-time arrivals</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> CPR-certified drivers</div>
                            <div class="ticker-item"><span class="ticker-dot"></span> Secure payments</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ── RIGHT ─────────────────────────────── -->
        <div class="right">

            <a href="/" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to home
            </a>

            <div class="right-register-link">
                New here? <a href="{{ route('register') }}">Create account</a>
            </div>

            <div class="form-label">Patient &amp; Driver Portal</div>
            <h1 class="form-title">Welcome back.</h1>
            <p class="form-sub">Sign in to manage your bookings and track your rides in real time.</p>

            {{-- Session status --}}
            @if (session('status'))
            <div class="status-msg">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="field">
                    <label class="field-label" for="email">Email address</label>
                    <input
                        class="field-input @error('email') error @enderror"
                        id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required autofocus autocomplete="username">
                    @error('email')
                    <div class="field-error">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <div class="pw-wrap">
                        <input
                            class="field-input @error('password') error @enderror"
                            id="password" type="password" name="password"
                            placeholder="••••••••"
                            required autocomplete="current-password">
                        <button type="button" class="pw-toggle" onclick="togglePw()" aria-label="Show password">
                            <svg id="eye-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <div class="field-error">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="form-extras">
                    <label class="remember">
                        <input type="checkbox" name="remember" id="remember_me">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot">Forgot password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit">
                    Sign in
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>

            </form>

            <div class="divider"><span>or</span></div>

            <div class="bottom-register">
                Don't have an account? <a href="{{ route('register') }}">Create one — it's free</a>
            </div>

            <div class="form-trust">
                <span class="trust-chip">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    SSL secured
                </span>
                <span class="trust-chip">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Data protected
                </span>
                <span class="trust-chip">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                    </svg>
                    Stripe payments
                </span>
            </div>

        </div>
    </div>

    <script>
        function togglePw() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>

</body>

</html>