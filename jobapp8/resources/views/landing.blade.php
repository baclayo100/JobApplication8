<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect - Find Your Dream Job</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('landing') }}" class="logo">JobConnect</a>
            <ul class="nav-links">
                <li><a href="{{ route('landing') }}">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Find Your Dream Job Today</h1>
            <p>Connect with top employers and discover opportunities that match your skills and aspirations</p>
            @guest
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    <a href="{{ route('login') }}" class="btn">Login</a>
                </div>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2>Why Choose JobConnect?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>For Job Seekers</h3>
                    <p>Browse thousands of job opportunities, apply with ease, and track your applications all in one place.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏢</div>
                    <h3>For Employers</h3>
                    <p>Post job openings, manage applications, and find the perfect candidates for your organization.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Fast & Easy</h3>
                    <p>Streamlined application process with real-time updates and instant notifications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="features" id="about" style="background: #f8f9fa;">
        <div class="container">
            <h2>How It Works</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>1. Create Account</h3>
                    <p>Sign up as a job seeker or employer to get started with your journey.</p>
                </div>
                <div class="feature-card">
                    <h3>2. Browse & Apply</h3>
                    <p>Job seekers can browse opportunities and apply with just a few clicks.</p>
                </div>
                <div class="feature-card">
                    <h3>3. Connect & Hire</h3>
                    <p>Employers can review applications and connect with potential candidates.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 JobConnect. All rights reserved.</p>
        </div>
    </footer>

    @if(session('success'))
        <div class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
