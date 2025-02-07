@extends('layouts.app')

@section('title', 'Register - FitTrack')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-dumbbell fa-2x mb-3" style="color: var(--blood-orange);"></i>
                        <h1 class="h3 mb-3">Start Your Fitness Journey</h1>
                        <p class="text-muted mb-4">Every champion starts somewhere</p>
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

                    <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                required minlength="8">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-4">
                            Create Account
                        </button>

                        <p class="text-center mb-0">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--blood-orange);">
                                Sign in
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
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity() || password.value !== confirmPassword.value) {
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
