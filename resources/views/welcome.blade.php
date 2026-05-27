<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedRide — Non-Emergency Medical Transportation</title>
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

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Barlow', sans-serif;
            background: var(--cream);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* NOISE TEXTURE OVERLAY */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 1000;
            pointer-events: none;
            opacity: 0.022;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 128px 128px;
        }

        /* NAV */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 500;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            border-bottom: 1px solid transparent;
            transition: all 0.3s;
        }

        nav.scrolled {
            background: rgba(240, 244, 252, 0.97);
            backdrop-filter: blur(12px);
            border-bottom-color: var(--border);
        }

        nav.dark-nav .logo-text,
        nav.dark-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
        }

        nav.dark-nav .nav-link:hover {
            color: #fff;
        }

        nav.dark-nav .btn-nav-outline {
            color: rgba(255, 255, 255, 0.8);
            border-color: rgba(255, 255, 255, 0.3);
        }

        nav.dark-nav .btn-nav-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-mark {
            width: 32px;
            height: 32px;
            background: var(--forest);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--ink);
            transition: color 0.3s;
        }

        .nav-center {
            display: flex;
            gap: 32px;
            list-style: none;
        }

        .nav-link {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.03em;
            text-decoration: none;
            color: var(--muted);
            transition: color 0.15s;
        }

        .nav-link:hover {
            color: var(--ink);
        }

        .nav-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-nav-outline {
            font-size: 13px;
            font-weight: 500;
            padding: 7px 16px;
            border-radius: 5px;
            border: 1.5px solid var(--border);
            background: transparent;
            color: var(--ink);
            text-decoration: none;
            cursor: pointer;
            font-family: 'Barlow', sans-serif;
            transition: all 0.15s;
        }

        .btn-nav-outline:hover {
            background: var(--warm);
        }

        .btn-nav-primary {
            font-size: 13px;
            font-weight: 600;
            padding: 7px 18px;
            border-radius: 5px;
            background: var(--forest);
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font-family: 'Barlow', sans-serif;
            border: none;
            transition: all 0.15s;
            letter-spacing: 0.02em;
        }

        .btn-nav-primary:hover {
            background: var(--moss);
            transform: translateY(-1px);
        }

        /* HERO */
        .hero {
            min-height: 100vh;
            background: #08111f;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .hero-photo {
            position: absolute;
            inset: 0;
            background-image: url('https://eliteextra.com/wp-content/uploads/2022/06/AdobeStock_386147368-1536x910.jpeg');
            background-size: cover;
            background-position: center 25%;
            opacity: 0.42;
            mix-blend-mode: luminosity;
        }

        /* Subtle vignette + left fade only — no heavy color cast */
        .hero-pattern {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right, rgba(8, 17, 31, 0.82) 0%, rgba(8, 17, 31, 0.55) 55%, rgba(8, 17, 31, 0.1) 100%),
                radial-gradient(ellipse at 50% 100%, rgba(8, 17, 31, 0.7) 0%, transparent 70%);
        }

        .hero-body {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 480px;
            gap: 0;
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 120px 48px 80px;
            align-items: center;
        }

        .hero-left {}

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.55);
            margin-bottom: 28px;
        }

        .hero-eyebrow-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--red-lt);
            animation: pulse 2s ease infinite;
            box-shadow: 0 0 6px rgba(255, 68, 68, 0.5);
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.7);
            }
        }

        .hero-h1 {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(44px, 5.5vw, 76px);
            font-weight: 700;
            line-height: 1.0;
            color: #fff;
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }

        .hero-h1 em {
            font-style: italic;
            font-weight: 400;
            color: #f0f4ff;
        }

        .hero-h1-sub {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(18px, 2.2vw, 28px);
            font-weight: 400;
            font-style: italic;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 36px;
            line-height: 1.3;
        }

        .hero-desc {
            font-size: 16px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.55);
            line-height: 1.75;
            max-width: 420px;
            margin-bottom: 44px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn-hero {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 14px 32px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.15s;
        }

        .btn-hero-fill {
            background: var(--red);
            color: #fff;
            box-shadow: 0 4px 16px rgba(214, 48, 48, 0.4);
        }

        .btn-hero-fill:hover {
            background: #c02020;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(214, 48, 48, 0.5);
        }

        .btn-hero-line {
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.8);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
        }

        .btn-hero-line:hover {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.55);
            background: rgba(255, 255, 255, 0.13);
        }

        /* TRUST ROW */
        .hero-trust {
            margin-top: 64px;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }

        .trust-item {}

        .trust-big {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -0.01em;
        }

        .trust-small {
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 3px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* BOOKING PANEL (right side of hero) */
        .booking-panel {
            background: var(--paper);
            border-radius: 2px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.35), 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .panel-top {
            background: var(--ink);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-top-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
        }

        .panel-top-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #ff6b6b;
            font-weight: 500;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--red-lt);
            box-shadow: 0 0 0 2px rgba(255, 68, 68, 0.25);
            animation: pulse 2s ease infinite;
        }

        .panel-body {
            padding: 28px;
        }

        /* Phone number booking CTA */
        .phone-cta {
            background: var(--forest);
            border-radius: 3px;
            padding: 20px 24px;
            margin-bottom: 24px;
            text-align: center;
        }

        .phone-cta-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 8px;
        }

        .phone-number {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 34px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.04em;
            display: block;
            line-height: 1;
            text-decoration: none;
            transition: color 0.15s;
        }

        .phone-number:hover {
            color: var(--mint);
        }

        .phone-number span {
            color: var(--mint);
        }

        .phone-sub {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 6px;
        }

        /* Steps in panel */
        .panel-steps-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .panel-steps {
            list-style: none;
            margin-bottom: 24px;
        }

        .panel-step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
        }

        .panel-step:last-child {
            border-bottom: none;
        }

        .step-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
        }

        .panel-step.active .step-circle {
            background: var(--forest);
            border-color: var(--forest);
            color: #fff;
        }

        .step-text-main {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
        }

        .step-text-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .panel-or {
            text-align: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin: 20px 0;
            position: relative;
        }

        .panel-or::before,
        .panel-or::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: var(--border);
        }

        .panel-or::before {
            left: 0;
        }

        .panel-or::after {
            right: 0;
        }

        .btn-panel-online {
            display: block;
            width: 100%;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none;
            padding: 14px;
            border-radius: 3px;
            background: var(--forest);
            color: #fff;
            transition: all 0.15s;
        }

        .btn-panel-online:hover {
            background: var(--moss);
            transform: translateY(-1px);
        }

        /* TICKER TAPE */
        .ticker {
            background: var(--forest);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding: 10px 0;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        }

        .ticker-track {
            display: flex;
            gap: 0;
            animation: ticker 28s linear infinite;
            width: max-content;
        }

        .ticker-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 36px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
            white-space: nowrap;
        }

        .ticker-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--sage);
        }

        @keyframes ticker {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* ─────────────────────────────────────────── SECTIONS */
        section {
            padding: 100px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 48px;
        }

        .tag {
            display: inline-block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--forest);
            margin-bottom: 16px;
            padding: 4px 10px;
            border: 1.5px solid var(--moss);
            border-radius: 2px;
        }

        .section-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(30px, 3.5vw, 46px);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--ink);
        }

        /* HOW IT WORKS */
        #how-it-works {
            background: var(--paper);
        }

        .process-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 80px;
            align-items: start;
        }

        .process-sidebar {}

        .process-sidebar .tag {
            margin-bottom: 20px;
        }

        .process-sidebar p {
            font-size: 15px;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.7;
            margin-top: 16px;
        }

        .process-steps {
            padding-top: 8px;
        }

        .process-step {
            display: grid;
            grid-template-columns: 60px 1fr;
            gap: 0;
            padding: 32px 0;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .process-step:first-child {
            padding-top: 0;
        }

        .process-step:last-child {
            border-bottom: none;
        }

        .process-num-col {
            padding-top: 4px;
        }

        .process-num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 52px;
            font-weight: 800;
            color: var(--border);
            line-height: 1;
            letter-spacing: -0.02em;
            transition: color 0.2s;
        }

        .process-step:hover .process-num {
            color: var(--red);
        }

        .process-content {}

        .process-step-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .process-step-body {
            font-size: 15px;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.65;
        }

        /* SERVICES */
        #services {
            background: var(--cream);
        }

        .services-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 60px;
        }

        .services-table {
            width: 100%;
            border-collapse: collapse;
        }

        .services-table thead tr {
            border-bottom: 2px solid var(--red);
        }

        .services-table th {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 0 0 14px;
            text-align: left;
        }

        .services-table th:last-child {
            text-align: right;
        }

        .services-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s, box-shadow 0.15s;
        }

        .services-table tbody tr:hover {
            background: var(--warm);
            box-shadow: inset 3px 0 0 var(--red);
        }

        .services-table td {
            padding: 22px 16px 22px 0;
            vertical-align: top;
        }

        .services-table td:last-child {
            text-align: right;
        }

        .svc-name {
            font-family: 'Libre Baskerville', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .svc-desc {
            font-size: 13.5px;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.5;
            max-width: 320px;
        }

        .svc-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--mint);
            color: var(--forest);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 2px;
        }

        .svc-price-big {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--red);
            display: block;
            line-height: 1;
        }

        .svc-price-small {
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* WHY US */
        #why-us {
            background: var(--ink);
        }

        #why-us .tag {
            border-color: var(--sage);
            color: var(--mint);
        }

        #why-us .section-title {
            color: #fff;
        }

        .why-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin-top: 64px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .why-item {
            background: var(--ink);
            padding: 40px 36px;
            transition: background 0.2s;
        }

        .why-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .why-icon {
            width: 44px;
            height: 44px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .why-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }

        .why-body {
            font-size: 14px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.65;
        }

        /* STATS BAR */
        .stats-bar {
            background: var(--forest);
            padding: 56px 0;
        }

        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 48px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-cell {
            background: var(--forest);
            padding: 32px 40px;
            text-align: center;
        }

        .stat-big {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 52px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -0.01em;
        }

        .stat-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 8px;
        }

        /* TESTIMONIALS */
        #testimonials {
            background: var(--paper);
        }

        .testimonials-layout {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 2px;
            background: var(--border);
        }

        .testimonial {
            background: var(--paper);
            padding: 40px 36px;
        }

        .testi-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 20px;
        }

        .testi-quote {
            font-family: 'Libre Baskerville', serif;
            font-size: 16px;
            font-style: italic;
            font-weight: 400;
            color: var(--ink);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .testi-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .testi-avatar {
            width: 40px;
            height: 40px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .testi-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }

        .testi-role {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* CTA */
        .cta-section {
            background: var(--paper);
            border-top: 1px solid var(--border);
            padding: 100px 0;
        }

        .cta-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 48px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 60px;
            align-items: center;
        }

        .cta-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(28px, 3vw, 44px);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin-bottom: 16px;
        }

        .cta-body {
            font-size: 16px;
            font-weight: 300;
            color: var(--muted);
            max-width: 400px;
        }

        .cta-phone {
            text-align: center;
            padding: 36px 48px;
            background: var(--forest);
            border-radius: 2px;
        }

        .cta-phone-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 10px;
        }

        .cta-phone-number {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 42px;
            font-weight: 800;
            color: #fff;
            display: block;
            text-decoration: none;
            letter-spacing: 0.03em;
            line-height: 1;
        }

        .cta-phone-number span {
            color: var(--mint);
        }

        .cta-phone-number:hover {
            color: var(--mint);
        }

        .cta-phone-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
            margin-top: 8px;
        }

        .cta-or {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            margin: 16px 0;
        }

        .btn-cta-online {
            display: block;
            width: 100%;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none;
            padding: 13px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.15s;
        }

        .btn-cta-online:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
        }

        /* FOOTER */
        footer {
            background: var(--ink);
            padding: 40px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-brand {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
        }

        .footer-brand span {
            color: var(--red-lt);
        }

        .footer-copy {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.25);
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-links a:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero-body {
                grid-template-columns: 1fr;
                padding: 110px 32px 60px;
            }

            .booking-panel {
                max-width: 420px;
            }

            .process-layout {
                grid-template-columns: 1fr;
                gap: 48px;
            }

            .why-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-inner {
                grid-template-columns: 1fr 1fr;
            }

            .testimonials-layout {
                grid-template-columns: 1fr;
            }

            .cta-inner {
                grid-template-columns: 1fr;
            }

            .cta-phone {
                text-align: left;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 0 24px;
            }

            nav .nav-center {
                display: none;
            }

            .container {
                padding: 0 24px;
            }

            .hero-body {
                padding: 100px 24px 60px;
            }

            .booking-panel {
                display: none;
            }

            .why-grid {
                grid-template-columns: 1fr;
            }

            .stats-inner {
                grid-template-columns: 1fr 1fr;
            }

            .services-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .services-table th:nth-child(2),
            .services-table td:nth-child(2) {
                display: none;
            }

            footer {
                flex-direction: column;
                padding: 32px 24px;
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
            height: 44px;
            width: auto;
            display: block;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav id="main-nav" class="dark-nav">
        <a href="/" class="logo">
            <!-- <a href="/" class="logo"> -->
            <img src="{{ asset('images/lg-white.png') }}" alt="MedRide" class="logo-img logo-light">
            <img src="{{ asset('images/lg-black.png') }}" alt="MedRide" class="logo-img logo-dark">
            <!-- </a> -->
            <!-- <span class="logo-text">Advocate Transport Service Inc.</span> -->
        </a>

        <ul class="nav-center">
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="#how-it-works" class="nav-link">How it works</a></li>
            <li><a href="#why-us" class="nav-link">Why us</a></li>
        </ul>

        <div class="nav-right">
            @if($isLoggedIn)
            @php
            $dashboard = match($user->role) {
            'admin' => route('admin.dashboard'),
            'driver' => route('driver.dashboard'),
            'client' => route('client.dashboard'),
            'superadmin' => route('admin.dashboard'),
            };
            @endphp
            <a href="{{ $dashboard }}" class="btn-nav-outline">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-nav-outline">Sign out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-nav-outline">Sign in</a>
            <a href="{{ route('register') }}" class="btn-nav-primary">Book online</a>
            @endif
        </div>
    </nav>


    <!-- HERO -->
    <div class="hero">
        <div class="hero-photo"></div>
        <div class="hero-pattern"></div>

        <div class="hero-body">
            <div class="hero-left">
                <div class="hero-eyebrow">
                    <span class="hero-eyebrow-dot"></span>
                    Available 24 hours a day, 7 days a week
                </div>

                <h1 class="hero-h1">
                    Safety is our<br><em>utmost priority.</em>
                </h1>
                <div class="hero-h1-sub">Non-emergency medical transportation.</div>

                <p class="hero-desc">
                    Wheelchair, stretcher, bariatric, and ambulatory transport — handled with care. Book online or call us directly. We handle the rest.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-hero btn-hero-fill">
                        Book online
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="tel:18005551234" class="btn-hero btn-hero-line">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4a2 2 0 0 1 1.98-2.18h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.06 6.06l.92-.93a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        1-800-555-1234
                    </a>
                </div>

                <div class="hero-trust">
                    <div class="trust-item">
                        <div class="trust-big">4,800+</div>
                        <div class="trust-small">Trips completed</div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-big">98%</div>
                        <div class="trust-small">On-time rate</div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-big">24/7</div>
                        <div class="trust-small">Availability</div>
                    </div>
                </div>
            </div>

            <!-- BOOKING PANEL -->
            <div class="booking-panel">
                <div class="panel-top">
                    <span class="panel-top-label">Book a ride</span>
                    <span class="panel-top-status">
                        <span class="status-dot"></span>
                        Dispatching now
                    </span>
                </div>
                <div class="panel-body">

                    <!-- Phone number prominent CTA -->
                    <div class="phone-cta">
                        <div class="phone-cta-label">Call to book instantly</div>
                        <a href="tel:18005551234" class="phone-number">
                            <span>1-800-</span>555-1234
                        </a>
                        <div class="phone-sub">Speak with a dispatcher in under 60 seconds</div>
                    </div>

                    <div class="panel-steps-label">Or follow these steps online</div>
                    <ul class="panel-steps">
                        <li class="panel-step active">
                            <div class="step-circle">1</div>
                            <div>
                                <div class="step-text-main">Create your account</div>
                                <div class="step-text-sub">Takes under 2 minutes</div>
                            </div>
                        </li>
                        <li class="panel-step">
                            <div class="step-circle">2</div>
                            <div>
                                <div class="step-text-main">Choose your service type</div>
                                <div class="step-text-sub">Ambulatory, wheelchair, stretcher, bariatric</div>
                            </div>
                        </li>
                        <li class="panel-step">
                            <div class="step-circle">3</div>
                            <div>
                                <div class="step-text-main">Enter pickup details & pay</div>
                                <div class="step-text-sub">Secure Stripe checkout</div>
                            </div>
                        </li>
                        <li class="panel-step">
                            <div class="step-circle">4</div>
                            <div>
                                <div class="step-text-main">Driver assigned &amp; confirmed</div>
                                <div class="step-text-sub">Track in real time</div>
                            </div>
                        </li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn-panel-online">Book online now →</a>
                </div>
            </div>
        </div>

        <!-- Ticker tape -->
        <div class="ticker">
            <div class="ticker-track">
                <!-- doubled for infinite loop -->
                <div class="ticker-item"><span style="background:var(--red);color:#fff;font-size:9px;font-weight:800;padding:2px 8px;border-radius:2px;letter-spacing:0.12em;">LIVE</span> Dispatching now</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Ambulatory transport</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Wheelchair equipped vehicles</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Stretcher &amp; gurney</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Bariatric certified</div>
                <div class="ticker-item"><span class="ticker-dot"></span> 98% on-time arrivals</div>
                <div class="ticker-item"><span class="ticker-dot"></span> CPR-certified drivers</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Secure Stripe payments</div>
                <div class="ticker-item"><span class="ticker-dot"></span> 24/7 dispatch</div>
                <div class="ticker-item"><span style="background:var(--red);color:#fff;font-size:9px;font-weight:800;padding:2px 8px;border-radius:2px;letter-spacing:0.12em;">LIVE</span> Dispatching now</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Ambulatory transport</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Wheelchair equipped vehicles</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Stretcher &amp; gurney</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Bariatric certified</div>
                <div class="ticker-item"><span class="ticker-dot"></span> 98% on-time arrivals</div>
                <div class="ticker-item"><span class="ticker-dot"></span> CPR-certified drivers</div>
                <div class="ticker-item"><span class="ticker-dot"></span> Secure Stripe payments</div>
                <div class="ticker-item"><span class="ticker-dot"></span> 24/7 dispatch</div>
            </div>
        </div>
    </div>


    <!-- HOW IT WORKS -->
    <section id="how-it-works">
        <div class="container">
            <div class="process-layout">
                <div class="process-sidebar">
                    <div class="tag">Process</div>
                    <h2 class="section-title">Four steps, zero hassle.</h2>
                    <p>No phone queues. No paperwork mountains. Book online in minutes — or just call and a dispatcher handles everything.</p>
                </div>
                <div class="process-steps">
                    <div class="process-step">
                        <div class="process-num-col">
                            <div class="process-num">01</div>
                        </div>
                        <div class="process-content">
                            <h3 class="process-step-title">Create your booking</h3>
                            <p class="process-step-body">Select a service type, enter your pickup and drop-off addresses, pick your date and time. Same-day bookings accepted.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-num-col">
                            <div class="process-num">02</div>
                        </div>
                        <div class="process-content">
                            <h3 class="process-step-title">Pay securely online</h3>
                            <p class="process-step-body">Pay through Stripe Checkout. Instant confirmation with a full receipt emailed to you — no surprises.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-num-col">
                            <div class="process-num">03</div>
                        </div>
                        <div class="process-content">
                            <h3 class="process-step-title">We assign your driver</h3>
                            <p class="process-step-body">A verified, trained driver matched to your transport needs is assigned and you're notified the moment they're en route.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-num-col">
                            <div class="process-num">04</div>
                        </div>
                        <div class="process-content">
                            <h3 class="process-step-title">Track in real time</h3>
                            <p class="process-step-body">Live status updates from assigned → in transit → arrived. You and your family always know where the vehicle is.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- SERVICES TABLE -->
    <section id="services">
        <div class="container">
            <div class="services-header">
                <div>
                    <div class="tag">Services</div>
                    <h2 class="section-title">Every level of transport, covered.</h2>
                </div>
                <a href="{{ route('register') }}" class="btn-nav-primary" style="padding:10px 24px;font-size:14px;">Book a ride</a>
            </div>

            <table class="services-table">
                <thead>
                    <tr>
                        <th style="width:40%">Service</th>
                        <th style="width:35%">Best for</th>
                        <th>Starting price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceTypes as $st)
                    <tr>
                        <td>
                            <div class="svc-name">{{ $st->name }}</div>
                            <!-- <div class="svc-desc">{{ $st->description }}</div> -->
                        </td>
                        <td>
                            <div class="svc-desc">{{ $st->description }}</div>
                        </td>
                        <td>
                            <span class="svc-price-big">${{ number_format($st->base_price, 0) }}</span>
                            @if($st->price_per_mile > 0)
                                <div class="svc-price-small">+ ${{ number_format($st->price_per_mile, 2) }} / mile</div>
                            @endif
                            @if($st->included_miles > 0)
                                <div class="svc-price-small" style="color:var(--forest); margin-top:4px;">
                                    First {{ $st->included_miles }} mi included
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center; padding:40px; color:var(--muted); font-size:14px;">
                            No services available at this time.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>


    <!-- STATS BAR -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-cell">
                <div class="stat-big">4,800+</div>
                <div class="stat-label">Trips completed</div>
            </div>
            <div class="stat-cell">
                <div class="stat-big">98%</div>
                <div class="stat-label">On-time arrivals</div>
            </div>
            <div class="stat-cell">
                <div class="stat-big">120+</div>
                <div class="stat-label">Certified drivers</div>
            </div>
            <div class="stat-cell">
                <div class="stat-big">24 / 7</div>
                <div class="stat-label">Dispatch available</div>
            </div>
        </div>
    </div>


    <!-- WHY US -->
    <section id="why-us">
        <div class="container">
            <div class="tag">Why Advocate Transport</div>
            <h2 class="section-title" style="color:#fff;">Built for patients,<br>not just passengers.</h2>

            <div class="why-grid">
                <div class="why-item">
                    <div class="why-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4d9467" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <div class="why-title">Verified drivers</div>
                    <div class="why-body">Background checks, CPR certification, and sensitivity training before every driver's first trip.</div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4d9467" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" />
                            <line x1="1" y1="10" x2="23" y2="10" />
                        </svg>
                    </div>
                    <div class="why-title">Upfront pricing</div>
                    <div class="why-body">See the exact fare before you pay. No surge pricing, no hidden fees. Invoices available for insurance.</div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4d9467" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div class="why-title">Live tracking</div>
                    <div class="why-body">Know where your driver is from the moment they're assigned. Status updates at every stage.</div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4d9467" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4a2 2 0 0 1 1.98-2.18h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.06 6.06l.92-.93a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </div>
                    <div class="why-title">Always reachable</div>
                    <div class="why-body">24/7 phone dispatch. Same-day bookings accepted. We accommodate dialysis runs, hospital discharges, recurring trips.</div>
                </div>
            </div>
        </div>
    </section>


    <!-- TESTIMONIALS -->
    <!-- <section id="testimonials">
        <div class="container">
            <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:56px;flex-wrap:wrap;gap:20px;">
                <div>
                    <div class="tag">Patient stories</div>
                    <h2 class="section-title">What our riders say.</h2>
                </div>
            </div>

            <div class="testimonials-layout">
                <div class="testimonial">
                    <div class="testi-stars">
                        @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#c8922a" stroke="none">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
                            @endfor
                    </div>
                    <p class="testi-quote">"After my knee replacement, I needed transport three times a week. MedRide was on time every single visit. The driver always helped me to the door."</p>
                    <div class="testi-author">
                        <div class="testi-avatar" style="background:var(--forest);">BM</div>
                        <div>
                            <div class="testi-name">Barbara M.</div>
                            <div class="testi-role">Knee replacement recovery</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testi-stars">
                        @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#c8922a" stroke="none">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
                            @endfor
                    </div>
                    <p class="testi-quote">"My father is in a wheelchair. Previous services were unreliable. MedRide showed up early, the driver secured his chair correctly, and the booking was so simple my dad does it himself."</p>
                    <div class="testi-author">
                        <div class="testi-avatar" style="background:#2d4a8a;">JT</div>
                        <div>
                            <div class="testi-name">James T.</div>
                            <div class="testi-role">Family caregiver</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testi-stars">
                        @for($i=0;$i<5;$i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#c8922a" stroke="none">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
                            @endfor
                    </div>
                    <p class="testi-quote">"We switched our dialysis center's patients to MedRide six months ago. The live tracking, PDF invoices, and 98% on-time rate have made operations so much smoother."</p>
                    <div class="testi-author">
                        <div class="testi-avatar" style="background:#1a2e6e;">RG</div>
                        <div>
                            <div class="testi-name">Rosa G.</div>
                            <div class="testi-role">Dialysis center coordinator</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->


    <!-- CTA -->
    <div class="cta-section">
        <div class="cta-inner">
            <div>
                <h2 class="cta-title">Ready to schedule<br>your first ride?</h2>
                <p class="cta-body">Book online in under two minutes, or call and a dispatcher will take care of everything. No subscription required.</p>
            </div>
            <div class="cta-phone">
                <div class="cta-phone-label">Call to book instantly</div>
                <a href="tel:18005551234" class="cta-phone-number"><span>1-800-</span>555-1234</a>
                <div class="cta-phone-sub">Available 24 / 7 · No hold times</div>
                <div class="cta-or">or</div>
                <a href="{{ route('register') }}" class="btn-cta-online">Book online →</a>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <footer>
        <span class="footer-brand">Advocate Transport Service <span>Inc.</span></span>
        <span class="footer-copy">© {{ date('Y') }} Advocate Transport Service Inc. All rights reserved.</span>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Contact</a>
            <a href="{{ route('login') }}">Driver portal</a>
        </div>
    </footer>


    <script>
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
                nav.classList.remove('dark-nav');
            } else {
                nav.classList.remove('scrolled');
                nav.classList.add('dark-nav');
            }
        }, {
            passive: true
        });
    </script>
</body>

</html>