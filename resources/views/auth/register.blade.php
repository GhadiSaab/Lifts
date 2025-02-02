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
                        <div class="mb-4 position-relative">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                value="{{ old('name') }}" required>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4 position-relative">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ old('email') }}" required>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                required minlength="8">
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4 position-relative">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                name="password_confirmation" required>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
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
    const inputs = form.querySelectorAll('input[required]');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.id === 'password_confirmation') {
                if (this.value === password.value && this.value !== '') {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else {
                if (this.checkValidity()) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            }
        });
    });

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
.valid-feedback {
    display: none;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--blood-orange);
    animation: checkmark 0.3s ease-in-out;
}

.form-control.is-valid {
    border-color: var(--blood-orange);
    padding-right: 2.5rem;
    background-image: none;
}

.form-control.is-valid ~ .valid-feedback {
    display: block;
}

@keyframes checkmark {
    0% { transform: translateY(-50%) scale(0); }
    70% { transform: translateY(-50%) scale(1.2); }
    100% { transform: translateY(-50%) scale(1); }
}

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
