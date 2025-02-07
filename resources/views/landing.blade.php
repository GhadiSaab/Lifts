@extends('layouts.app')

@section('title', 'FitTrack - Transform Your Fitness Journey')

@section('styles')
<style>
    /* Override default styles */
    body {
        padding-top: 0 !important;
        background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%) !important;
    }

    /* Override navbar styles for landing page */
    .navbar {
        background: transparent !important;
        box-shadow: none !important;
        position: absolute !important;
        width: 100%;
        z-index: 10;
        padding: 1.5rem 0;
        border: none !important;
    }

    .navbar-brand {
        font-size: 1.75rem !important;
    }

    .nav-link {
        color: var(--slate-gray) !important;
        font-weight: 500 !important;
    }

    .landing-page {
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        overflow-x: hidden;
        position: relative;
    }

    .hero-section {
        padding: 8rem 1.5rem 6rem;
        position: relative;
        background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 83, 73, 0.1) 0%, rgba(255, 83, 73, 0.05) 100%);
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        z-index: 0;
    }

    .hero-section > .container {
        position: relative;
        z-index: 1;
    }

    .hero-section h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        line-height: 1.2;
        background: linear-gradient(135deg, var(--blood-orange) 0%, #ff7b6b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .hero-section .lead {
        font-size: clamp(1.25rem, 2vw, 1.5rem);
        color: var(--slate-gray);
        margin-bottom: 3rem;
        font-weight: 400;
        opacity: 0.9;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-section .btn {
        padding: 1rem 2.5rem !important;
        font-size: 1.125rem !important;
        font-weight: 600 !important;
        border-radius: 12px !important;
        transition: all 0.3s ease !important;
        min-width: 180px !important;
    }

    .hero-section .btn-primary {
        background: linear-gradient(135deg, var(--blood-orange) 0%, #ff7b6b 100%) !important;
        border: none !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(255, 83, 73, 0.2) !important;
    }

    .hero-section .btn-primary:hover,
    .hero-section .btn-primary:focus {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 12px -1px rgba(255, 83, 73, 0.3) !important;
    }

    .hero-section .btn-outline {
        background: transparent !important;
        border: 2px solid var(--blood-orange) !important;
        color: var(--blood-orange) !important;
    }

    .hero-section .btn-outline:hover,
    .hero-section .btn-outline:focus {
        background: linear-gradient(135deg, var(--blood-orange) 0%, #ff7b6b 100%) !important;
        color: white !important;
        transform: translateY(-2px) !important;
    }

    .features-section {
        padding: 6rem 1.5rem;
        background: white;
        position: relative;
        margin-top: -2rem;
    }

    .features-section::before {
        content: '';
        position: absolute;
        top: -50px;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to bottom right, transparent 49.5%, white 50%);
    }

    .feature-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05),
                    0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px -5px rgba(255, 83, 73, 0.2);
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(255, 83, 73, 0.1) 0%, rgba(255, 83, 73, 0.05) 100%);
        border-radius: 16px;
        margin-bottom: 1.5rem;
        color: var(--blood-orange);
    }

    .feature-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--slate-gray);
        margin-bottom: 1rem;
    }

    .feature-card p {
        color: var(--slate-gray);
        opacity: 0.8;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 768px) {
        .navbar {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            padding: 1rem 0;
        }

        .hero-section {
            padding: 7rem 1rem 4rem;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
        }

        .hero-section .lead {
            font-size: 1.125rem;
            padding: 0 1rem;
        }

        .cta-buttons {
            flex-direction: column;
            align-items: stretch;
            padding: 0 2rem;
        }

        .hero-section .btn {
            width: 100% !important;
            margin: 0.5rem 0;
        }

        .features-section {
            padding: 4rem 1rem;
            margin-top: 0;
        }

        .feature-card {
            margin-bottom: 1.5rem;
            padding: 2rem 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .hero-section {
            padding: 6rem 1rem 3rem;
        }

        .hero-section h1 {
            font-size: 2rem;
        }

        .cta-buttons {
            padding: 0 1rem;
        }

        .features-section::before {
            top: -30px;
            height: 60px;
        }
    }
</style>
@endsection

@section('content')
<div class="landing-page">
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <h1>Transform Your<br>Fitness Journey</h1>
                    <p class="lead">Track. Progress. Achieve.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                        <a href="{{ route('register') }}" class="btn btn-outline">Join Free</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M12 7V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3>Track Progress</h3>
                        <p>Monitor your fitness journey with real-time insights</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5 3L14.5 5H19V19H5V5H9.5L10.5 3H13.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3>Stay Motivated</h3>
                        <p>Set goals and celebrate every achievement</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M17 8L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M7 8L17 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3>Build Habits</h3>
                        <p>Create sustainable routines that last</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
