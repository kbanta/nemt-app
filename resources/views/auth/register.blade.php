<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — MedRide</title>
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
        }

        body {
            font-family: 'Barlow', sans-serif;
            -webkit-font-smoothing: antialiased;
            color: var(--ink);
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

        /* ── LEFT ───────────────────────────────────── */
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

        .logo-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #fff;
        }

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
            font-size: clamp(30px, 3vw, 48px);
            font-weight: 700;
            line-height: 1.08;
            letter-spacing: -0.025em;
            color: #fff;
            margin-bottom: 18px;
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
            margin-bottom: 32px;
        }

        /* Steps list on left */
        .left-steps {
            list-style: none;
            margin-bottom: 36px;
        }

        .left-step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .left-step:first-child {
            padding-top: 0;
        }

        .left-step:last-child {
            border-bottom: none;
        }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 1px;
        }

        .step-num.active {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        .step-body-title {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.3;
        }

        .step-body-sub {
            font-size: 12px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.35);
            margin-top: 2px;
        }

        .left-ticker {
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

        /* ── RIGHT ───────────────────────────────────── */
        .right {
            width: 520px;
            flex-shrink: 0;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 56px;
            position: relative;
            overflow-y: auto;
        }

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

        .right-login-link {
            position: absolute;
            top: 36px;
            right: 56px;
            font-size: 13px;
            color: var(--muted);
        }

        .right-login-link a {
            color: var(--forest);
            font-weight: 600;
            text-decoration: none;
        }

        .right-login-link a:hover {
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
            font-size: 30px;
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
            margin-bottom: 32px;
        }

        /* Two column row */
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Fields */
        .field {
            margin-bottom: 18px;
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

        .field-input.is-error {
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

        /* Password wrapper */
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

        /* Password strength bar */
        .pw-strength {
            margin-top: 8px;
        }

        .pw-strength-bar {
            height: 3px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .pw-strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width 0.3s, background 0.3s;
            background: var(--border);
        }

        .pw-strength-label {
            font-size: 11px;
            color: var(--muted);
            font-weight: 500;
        }

        /* Terms note */
        .terms-note {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .terms-note a {
            color: var(--forest);
            text-decoration: none;
            font-weight: 500;
        }

        .terms-note a:hover {
            text-decoration: underline;
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
            margin: 22px 0 18px;
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

        .bottom-login {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        .bottom-login a {
            color: var(--forest);
            font-weight: 600;
            text-decoration: none;
        }

        .bottom-login a:hover {
            text-decoration: underline;
        }

        /* Trust row */
        .form-trust {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--paper);
            flex-wrap: wrap;
        }

        .trust-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--muted);
            font-weight: 400;
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

        @media (max-width: 600px) {
            .right {
                padding: 60px 24px 48px;
            }

            .back-link,
            .right-login-link {
                display: none;
            }

            .field-row {
                grid-template-columns: 1fr;
            }
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
                    <img src="{{ asset('images/lg-white-x.png') }}" alt="MedRide" class="logo-img logo-light">
                    <!-- <img src="{{ asset('images/lg-black-x.png') }}" alt="MedRide" class="logo-img logo-dark"> -->
                </a>

                <div class="left-foot">
                    <!-- <div class="live-badge">
                        <span class="live-dot"></span>
                        Join 4,800+ patients already riding
                    </div> -->

                    <h2 class="left-heading">
                        Your first ride<br><em>starts here.</em>
                    </h2>

                    <p class="left-desc">
                        Create your free account in under two minutes. Book ambulatory, wheelchair, stretcher, or bariatric transport instantly.
                    </p>

                    <ul class="left-steps">
                        <li class="left-step">
                            <div class="step-num active">1</div>
                            <div>
                                <div class="step-body-title">Create your account</div>
                                <div class="step-body-sub">Name, email, and a password — that's it</div>
                            </div>
                        </li>
                        <li class="left-step">
                            <div class="step-num">2</div>
                            <div>
                                <div class="step-body-title">Choose your service type</div>
                                <div class="step-body-sub">Ambulatory, wheelchair, stretcher, bariatric</div>
                            </div>
                        </li>
                        <li class="left-step">
                            <div class="step-num">3</div>
                            <div>
                                <div class="step-body-title">Pay &amp; get confirmed</div>
                                <div class="step-body-sub">Secure Stripe checkout, instant receipt</div>
                            </div>
                        </li>
                        <li class="left-step">
                            <div class="step-num">4</div>
                            <div>
                                <div class="step-body-title">Track in real time</div>
                                <div class="step-body-sub">Live status from assigned → arrived</div>
                            </div>
                        </li>
                    </ul>

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

            <div class="right-login-link">
                Have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
            <br><br> <br>
            <br><br> <br>
            <br><br> <br>
            <div class="form-label">Free · No subscription</div>
            <h1 class="form-title">Create your account.</h1>
            <p class="form-sub">Book your first ride in under two minutes. No credit card required to register.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="field">
                    <label class="field-label" for="name">Full name</label>
                    <input
                        class="field-input @error('name') is-error @enderror"
                        id="name" type="text" name="name"
                        value="{{ old('name') }}"
                        placeholder="Jane Doe"
                        required autofocus autocomplete="name">
                    @error('name')
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

                {{-- Email --}}
                <div class="field">
                    <label class="field-label" for="email">Email address</label>
                    <input
                        class="field-input @error('email') is-error @enderror"
                        id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required autocomplete="username">
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
                            class="field-input @error('password') is-error @enderror"
                            id="password" type="password" name="password"
                            placeholder="Min. 8 characters"
                            required autocomplete="new-password"
                            oninput="checkStrength(this.value)">
                        <button type="button" class="pw-toggle" onclick="togglePw('password','eye1')" aria-label="Show password">
                            <svg id="eye1" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    <div class="pw-strength">
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="strength-fill"></div>
                        </div>
                        <div class="pw-strength-label" id="strength-label"></div>
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

                {{-- Confirm Password --}}
                <div class="field">
                    <label class="field-label" for="password_confirmation">Confirm password</label>
                    <div class="pw-wrap">
                        <input
                            class="field-input @error('password_confirmation') is-error @enderror"
                            id="password_confirmation" type="password" name="password_confirmation"
                            placeholder="Re-enter password"
                            required autocomplete="new-password">
                        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation','eye2')" aria-label="Show password">
                            <svg id="eye2" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
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

                <p class="terms-note">
                    By creating an account you agree to our
                    <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                </p>

                <button type="submit" class="btn-submit">
                    Create account
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>

            </form>

            <div class="divider"><span>or</span></div>

            <div class="bottom-login">
                Already have an account? <a href="{{ route('login') }}">Sign in instead</a>
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
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        function checkStrength(val) {
            const fill = document.getElementById('strength-fill');
            const label = document.getElementById('strength-label');
            if (!val) {
                fill.style.width = '0%';
                label.textContent = '';
                return;
            }
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const levels = [{
                    pct: '20%',
                    color: '#d63030',
                    text: 'Too weak'
                },
                {
                    pct: '45%',
                    color: '#e07b20',
                    text: 'Weak'
                },
                {
                    pct: '70%',
                    color: '#c8922a',
                    text: 'Fair'
                },
                {
                    pct: '100%',
                    color: '#1a9e6e',
                    text: 'Strong'
                },
            ];
            const l = levels[score - 1] || levels[0];
            fill.style.width = l.pct;
            fill.style.background = l.color;
            label.textContent = l.text;
            label.style.color = l.color;
        }
    </script>

</body>

</html>