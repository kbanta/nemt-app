<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advocate Transport Service Inc.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Barlow+Condensed:wght@400;500;600;700;800&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#0f172a">


    <!-- Primary SEO -->
    <meta name="description" content="Advocate Transport Service Inc. offers safe, reliable non-emergency medical transportation — wheelchair, stretcher, bariatric, and ambulatory transport. Available 24/7. Book online or call 1-800-555-1234.">
    <meta name="keywords" content="non-emergency medical transportation, NEMT, wheelchair transport, stretcher transport, bariatric transport, ambulatory transport, medical ride service">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.kb-multi-page.online/">

    <!-- Open Graph (Facebook, LinkedIn previews) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.kb-multi-page.online/">
    <meta property="og:title" content="Advocate Transport Service Inc.">
    <meta property="og:description" content="Safe, reliable NEMT services — wheelchair, stretcher, bariatric & ambulatory. Available 24/7. Book online or call us directly.">
    <meta property="og:image" content="https://www.kb-multi-page.online/favicon_io/favicon-32x32.jpg">
    <meta property="og:site_name" content="Advocate Transport Service Inc.">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Advocate Transport Service Inc.">
    <meta name="twitter:description" content="Safe, reliable NEMT services — wheelchair, stretcher, bariatric & ambulatory. Available 24/7.">
    <meta name="twitter:image" content="https://www.kb-multi-page.online/favicon_io/favicon-32x32.jpg">

    <script type="application/ld+json">
    {
    "@@context": "https://schema.org",
    "@@type": "LocalBusiness",
    "name": "Advocate Transport Service Inc.",
    "url": "https://www.kb-multi-page.online/",
    "telephone": "+18005551234",
    "description": "Non-emergency medical transportation including wheelchair, stretcher, bariatric, and ambulatory transport. Available 24/7.",
    "openingHours": "Mo-Su 00:00-23:59",
    "priceRange": "$$",
    "serviceType": ["Wheelchair Transport", "Stretcher Transport", "Bariatric Transport", "Ambulatory Transport"]
    }
    </script>

</head>

<body>

    <!-- NAV -->
    <nav id="main-nav" class="dark-nav">
        <a href="/" class="logo">
            <img src="{{ asset('images/lg-white.png') }}" alt="Advocate Transport Service Inc." class="logo-img logo-light">
            <img src="{{ asset('images/lg-black.png') }}" alt="Advocate Transport Service Inc." class="logo-img logo-dark">
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

        <!-- Hamburger (mobile only) -->
        <button class="hamburger" id="hamburger-btn" aria-label="Toggle menu" aria-expanded="false">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </nav>

    <!-- MOBILE MENU DRAWER -->
    <div class="mobile-menu" id="mobile-menu" role="navigation" aria-label="Mobile navigation">
        <div class="mobile-menu-inner">
            <a href="#services" class="mobile-nav-link" onclick="closeMobileMenu()">Services</a>
            <a href="#how-it-works" class="mobile-nav-link" onclick="closeMobileMenu()">How it works</a>
            <a href="#why-us" class="mobile-nav-link" onclick="closeMobileMenu()">Why us</a>

            <div class="mobile-menu-actions">
                @if($isLoggedIn)
                <a href="{{ $dashboard }}" class="btn-nav-outline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;flex:1;">
                    @csrf
                    <button type="submit" class="btn-nav-outline" style="width:100%;cursor:pointer;">Sign out</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn-nav-outline">Sign in</a>
                <a href="{{ route('register') }}" class="btn-nav-primary">Book online</a>
                @endif
            </div>
        </div>
    </div>


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

            <!-- BOOKING PANEL (desktop only) -->
            <div class="booking-panel">
                <div class="panel-top">
                    <span class="panel-top-label">Book a ride</span>
                    <span class="panel-top-status">
                        <span class="status-dot"></span>
                        Dispatching now
                    </span>
                </div>
                <div class="panel-body">
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

            <!-- MOBILE BOOKING BAR (mobile only, inside hero-body) -->
            <div class="mobile-booking-bar">
                <div class="mobile-booking-bar-top">
                    <div>
                        <a href="tel:18005551234" class="mobile-booking-phone"><span>1-800-</span>555-1234</a>
                        <div class="mobile-booking-label">Speak with a dispatcher in under 60 seconds</div>
                    </div>
                    <span class="panel-top-status">
                        <span class="status-dot"></span>
                        Live
                    </span>
                </div>
                <div class="mobile-booking-bar-divider"></div>
                <div class="mobile-booking-bar-actions">
                    <a href="{{ route('register') }}" class="mbba-online">Book online</a>
                    <a href="tel:18005551234" class="mbba-call">Call now</a>
                </div>
            </div>
        </div>

        <!-- Ticker tape -->
        <div class="ticker">
            <div class="ticker-track">
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
                <div class="process-sidebar reveal">
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
            <div class="services-header reveal">
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
                <div class="stat-big" data-count="4800" data-suffix="+">4,800+</div>
                <div class="stat-label">Trips completed</div>
            </div>
            <div class="stat-cell">
                <div class="stat-big" data-count="98" data-suffix="%">98%</div>
                <div class="stat-label">On-time arrivals</div>
            </div>
            <div class="stat-cell">
                <div class="stat-big" data-count="120" data-suffix="+">120+</div>
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
            <div class="tag reveal">Why Advocate Transport</div>
            <h2 class="section-title reveal" style="color:#fff;">Built for patients,<br>not just passengers.</h2>

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
        // ── Nav scroll behaviour (original)
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

        // ── Hamburger / mobile menu (original)
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        let menuOpen = false;

        function openMobileMenu() {
            menuOpen = true;
            hamburgerBtn.classList.add('open');
            hamburgerBtn.setAttribute('aria-expanded', 'true');
            mobileMenu.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            menuOpen = false;
            hamburgerBtn.classList.remove('open');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
        }

        hamburgerBtn.addEventListener('click', () => {
            menuOpen ? closeMobileMenu() : openMobileMenu();
        });

        document.addEventListener('click', (e) => {
            if (menuOpen && !mobileMenu.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                closeMobileMenu();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && menuOpen) closeMobileMenu();
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && menuOpen) closeMobileMenu();
        });

        // ── SCROLL REVEAL ─────────────────────────────────────────
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        // Single reveal elements
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // Process steps container
        const processStepsEl = document.querySelector('.process-steps');
        if (processStepsEl) revealObserver.observe(processStepsEl);

        // Why grid
        const whyGridEl = document.querySelector('.why-grid');
        if (whyGridEl) revealObserver.observe(whyGridEl);

        // Stats inner
        const statsInnerEl = document.querySelector('.stats-inner');
        if (statsInnerEl) revealObserver.observe(statsInnerEl);

        // CTA inner
        const ctaInnerEl = document.querySelector('.cta-inner');
        if (ctaInnerEl) revealObserver.observe(ctaInnerEl);

        // Services table
        const servicesTableEl = document.querySelector('.services-table');
        if (servicesTableEl) revealObserver.observe(servicesTableEl);

        // ── COUNT-UP for stat numbers ──────────────────────────────
        function animateCount(el, target, suffix, duration) {
            const start = performance.now();
            const isLarge = target > 999;

            function step(now) {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                // ease out cubic
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = Math.round(eased * target);
                el.textContent = isLarge ?
                    current.toLocaleString() + suffix :
                    current + suffix;
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        const countObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('[data-count]').forEach(el => {
                        const target = parseInt(el.dataset.count, 10);
                        const suffix = el.dataset.suffix || '';
                        animateCount(el, target, suffix, 1400);
                    });
                    countObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        });

        const statsBar = document.querySelector('.stats-bar');
        if (statsBar) countObserver.observe(statsBar);
    </script>
</body>

</html>