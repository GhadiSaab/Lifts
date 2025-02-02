@extends('layouts.app')

@section('content')
<div class="landing-page">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <div class="logo-container mb-4">
                        <i class="fas fa-dumbbell fa-4x gradient-text"></i>
                    </div>
                    <h1 class="display-3 mb-4 gradient-text">Transform Your Fitness Journey</h1>
                    <p class="lead mb-5">Your all-in-one platform for tracking workouts, managing nutrition, and achieving your fitness goals</p>
                    <div class="cta-buttons">
                        <a href="{{ route('login') }}" class="btn btn-gradient btn-lg mx-2">Get Started</a>
                        <a href="{{ route('register') }}" class="btn btn-gradient btn-lg mx-2">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="icon-container">
                            <i class="fas fa-bolt gradient-text"></i>
                        </div>
                        <h3>Real-time Progress</h3>
                        <p>Track your fitness journey with instant updates and detailed progress visualization</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="icon-container">
                            <i class="fas fa-cloud gradient-text"></i>
                        </div>
                        <h3>Cloud Sync</h3>
                        <p>Access your fitness data anywhere, anytime with secure cloud storage</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="icon-container">
                            <i class="fas fa-mobile-alt gradient-text"></i>
                        </div>
                        <h3>Cross-platform</h3>
                        <p>Seamlessly switch between devices while maintaining your workout flow</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="icon-container">
                            <i class="fas fa-shield-alt gradient-text"></i>
                        </div>
                        <h3>Advanced Security</h3>
                        <p>Your fitness data is protected with enterprise-grade security measures</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Proof Section -->
    <div class="social-proof-section">
        <div class="container">
            <h2 class="text-center mb-5">Trusted by Fitness Enthusiasts</h2>
            <div class="row testimonials">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="avatar">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </div>
                        <p class="quote">"This app has completely transformed how I track my fitness progress. The interface is intuitive and the features are exactly what I needed."</p>
                        <p class="author">- Sarah J.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="avatar">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </div>
                        <p class="quote">"The best fitness tracking app I've ever used. The progress visualization really keeps me motivated!"</p>
                        <p class="author">- Mike R.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="avatar">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </div>
                        <p class="quote">"Finally, an all-in-one solution that handles both workout tracking and nutrition monitoring. Exactly what I was looking for."</p>
                        <p class="author">- Emily T.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .landing-page {
        background: linear-gradient(135deg, #1a1c2c 0%, #4a4e69 100%);
        color: white;
        min-height: 100vh;
    }

    .gradient-text {
        background: linear-gradient(45deg, var(--blood-orange), #4ecdc4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-section {
        padding: 120px 0;
        background: rgba(0, 0, 0, 0.2);
    }

    .hero-section h1 {
        font-size: 4rem;
        margin-bottom: 1.5rem;
    }

    .hero-section .lead {
        font-size: 1.5rem;
        margin-bottom: 3rem;
        opacity: 0.9;
    }

    .features-section {
        padding: 100px 0;
        background: rgba(255, 255, 255, 0.05);
    }

    .social-proof-section {
        padding: 100px 0;
    }

    .feature-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 40px;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .icon-container {
        font-size: 3em;
        margin-bottom: 25px;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .feature-card p {
        font-size: 1.1rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .btn-gradient {
        background: linear-gradient(45deg, var(--blood-orange), #4ecdc4);
        border: none;
        color: white;
        padding: 15px 40px;
        font-size: 1.2rem;
        font-weight: 600;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255, 83, 73, 0.4);
        color: white;
    }

    .btn-outline-light {
        border: 2px solid white;
        padding: 15px 40px;
        font-size: 1.2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background: white;
        color: var(--blood-orange);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
    }

    .testimonial-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 30px;
        text-align: center;
        height: 100%;
    }

    .avatar {
        margin-bottom: 25px;
        color: var(--blood-orange);
    }

    .quote {
        font-style: italic;
        margin-bottom: 25px;
        font-size: 1.1rem;
        line-height: 1.6;
        opacity: 0.9;
    }

    .author {
        color: var(--blood-orange);
        font-weight: bold;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 80px 0;
        }

        .hero-section h1 {
            font-size: 3rem;
        }
        
        .cta-buttons .btn {
            display: block;
            margin: 15px auto;
            width: 250px;
        }

        .feature-card {
            margin-bottom: 30px;
        }
    }
</style>
@endpush
@endsection
