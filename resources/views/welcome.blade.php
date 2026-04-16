<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: #0a0a0a;
            color: white;
            overflow-x: hidden;
        }

        /* Animated background */
        .bg-animated {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            background: linear-gradient(135deg, #1a0000 0%, #2d0000 30%, #0d0d0d 70%, #1a0000 100%);
        }

        .bg-animated::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(ellipse at center, rgba(180,0,0,0.15) 0%, transparent 60%);
            animation: pulse 4s ease-in-out infinite;
        }

        .bg-animated::after {
            content: '';
            position: absolute;
            bottom: 0; right: 0;
            width: 600px; height: 600px;
            background: radial-gradient(ellipse, rgba(180,0,0,0.08) 0%, transparent 70%);
            animation: pulse 6s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        /* Floating particles */
        .particles {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 6px; height: 6px;
            background: rgba(220, 20, 20, 0.4);
            border-radius: 50%;
            animation: float linear infinite;
        }

        @keyframes float {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            color: #ff3333;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 40px;
            list-style: none;
        }

        .navbar-links a {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .navbar-links a:hover { color: white; }

        .btn-login {
            padding: 9px 24px;
            border: 1.5px solid rgba(255,255,255,0.4);
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
        }

        /* Hero section */
        .hero {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 20px 60px;
        }

        .hero-content { max-width: 750px; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(180,0,0,0.2);
            border: 1px solid rgba(220,20,20,0.4);
            border-radius: 50px;
            padding: 6px 18px;
            font-size: 13px;
            color: #ff6666;
            margin-bottom: 28px;
            letter-spacing: 0.5px;
        }

        .hero-badge::before {
            content: '';
            width: 8px; height: 8px;
            background: #ff3333;
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.2; }
        }

        .hero h1 {
            font-size: 68px;
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 24px;
            letter-spacing: -2px;
        }

        .hero h1 span { color: #ff3333; }

        .hero p {
            font-size: 18px;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 14px 36px;
            background: #cc0000;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.2s;
            border: 2px solid #cc0000;
        }

        .btn-primary:hover {
            background: #aa0000;
            border-color: #aa0000;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(180,0,0,0.4);
        }

        .btn-secondary {
            padding: 14px 36px;
            background: transparent;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            border: 2px solid rgba(255,255,255,0.25);
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.5);
            transform: translateY(-2px);
        }

        /* Stats bar */
        .stats-bar {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
            gap: 60px;
            padding: 40px 20px;
            background: rgba(255,255,255,0.03);
            border-top: 1px solid rgba(255,255,255,0.06);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-wrap: wrap;
        }

        .stat-item { text-align: center; }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: #ff3333;
            display: block;
        }

        .stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }

        /* Features section */
        .features {
            position: relative;
            z-index: 10;
            padding: 80px 60px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 32px;
            transition: all 0.3s;
        }

        .feature-card:hover {
            background: rgba(180,0,0,0.12);
            border-color: rgba(220,20,20,0.3);
            transform: translateY(-4px);
        }

        .feature-icon {
            font-size: 36px;
            margin-bottom: 16px;
            display: block;
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
        }

        .feature-card p {
            font-size: 14px;
            color: rgba(255,255,255,0.5);
            line-height: 1.6;
        }

        /* CTA section */
        .cta-section {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 80px 20px;
        }

        .cta-box {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(180,0,0,0.1);
            border: 1px solid rgba(220,20,20,0.25);
            border-radius: 20px;
            padding: 60px 40px;
        }

        .cta-box h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .cta-box p {
            color: rgba(255,255,255,0.6);
            margin-bottom: 32px;
            font-size: 16px;
        }

        /* Footer */
        footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 24px;
            color: rgba(255,255,255,0.25);
            font-size: 13px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        @media (max-width: 768px) {
            .navbar { padding: 16px 20px; }
            .hero h1 { font-size: 42px; }
            .features { grid-template-columns: 1fr; padding: 40px 20px; }
            .navbar-links { gap: 16px; }
            .stats-bar { gap: 30px; }
        }
    </style>
</head>
<body>

    <!-- Animated Background -->
    <div class="bg-animated"></div>

    <!-- Floating Particles -->
    <div class="particles" id="particles"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🩸 Blood<span>Donate</span>
        </a>
        <ul class="navbar-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
            <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-badge">
                Save Lives Today
            </div>
            <h1>Every Drop<br>Counts. <span>Donate</span><br>Blood.</h1>
            <p>Join our Blood Donation Management System. Register as a donor, track your donations, and help save lives in your community.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-primary">🩸 Become a Donor</a>
                <a href="{{ route('login') }}" class="btn-secondary">Login to Dashboard</a>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-number">3+</span>
            <div class="stat-label">Blood Types Managed</div>
        </div>
        <div class="stat-item">
            <span class="stat-number">1 Pint</span>
            <div class="stat-label">Can Save 3 Lives</div>
        </div>
        <div class="stat-item">
            <span class="stat-number">24/7</span>
            <div class="stat-label">System Available</div>
        </div>
        <div class="stat-item">
            <span class="stat-number">100%</span>
            <div class="stat-label">Secure & Private</div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features">
        <div class="features">
            <div class="feature-card">
                <span class="feature-icon">📋</span>
                <h3>Easy Registration</h3>
                <p>Register quickly and set up your donor profile with your blood type, contact info, and personal details.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🩸</span>
                <h3>Track Donations</h3>
                <p>Log and monitor all your blood donation records. See your donation history and total packs donated.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">✅</span>
                <h3>Admin Approval</h3>
                <p>Each donation is reviewed and approved by our admin team to ensure accuracy and proper management.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🔒</span>
                <h3>Secure Access</h3>
                <p>Role-based access control keeps your data safe. Only you can view and manage your donation records.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📊</span>
                <h3>Admin Dashboard</h3>
                <p>Admins get a full overview of all donors, donations, and can update statuses in real time.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">❤️</span>
                <h3>Save Lives</h3>
                <p>Your blood donation directly helps patients in need. Every pack you donate can save multiple lives.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="about">
        <div class="cta-box">
            <h2>Ready to Save Lives?</h2>
            <p>Create your donor account today and start making a difference in your community.</p>
            <a href="{{ route('register') }}" class="btn-primary">Get Started — It's Free</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Blood Donation Management System. All rights reserved.
    </footer>

    <script>
        // Generate floating particles
        const container = document.getElementById('particles');
        for (let i = 0; i < 25; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.cssText = `
                left: ${Math.random() * 100}%;
                width: ${Math.random() * 6 + 3}px;
                height: ${Math.random() * 6 + 3}px;
                animation-duration: ${Math.random() * 15 + 10}s;
                animation-delay: ${Math.random() * 10}s;
                opacity: ${Math.random() * 0.5 + 0.1};
            `;
            container.appendChild(p);
        }
    </script>

</body>
</html>