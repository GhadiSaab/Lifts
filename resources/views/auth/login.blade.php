@extends('layouts.app')

@section('title', 'Login - FitTrack')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-dumbbell fa-2x mb-3" style="color: var(--blood-orange);"></i>
                        <h1 class="h3 mb-3">Welcome Back!</h1>
                        <p class="text-muted mb-4">One rep closer to your goals</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-4">
                            Sign In
                        </button>

                        <p class="text-center mb-0">
                            New to FitTrack? 
                            <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--blood-orange);">
                                Create account
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<style>
.card {
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
