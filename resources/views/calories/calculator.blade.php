@extends('layouts.app')

@section('title', 'Calorie Calculator')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-2">Calorie Calculator</h1>
                    <p class="text-muted mb-0">Calculate your daily calorie needs</p>
                </div>
                <a href="{{ route('exercises.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('calories.calculate') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-3 position-relative">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control" name="weight" id="weight" 
                                step="0.1" required min="20" placeholder="e.g., 70">
                            <div class="valid-feedback" style="color: var(--blood-orange); position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                ✓
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" class="form-control" name="height" id="height" 
                                required min="100" placeholder="e.g., 175">
                            <div class="valid-feedback" style="color: var(--blood-orange); position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                ✓
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" name="age" id="age" 
                                required min="15" max="100" placeholder="e.g., 25">
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Gender</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="gender" id="male" value="male" required>
                                <label class="btn btn-outline-primary" for="male">
                                    <i class="fas fa-mars me-2"></i>Male
                                </label>
                                
                                <input type="radio" class="btn-check" name="gender" id="female" value="female" required>
                                <label class="btn btn-outline-primary" for="female">
                                    <i class="fas fa-venus me-2"></i>Female
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="activity" class="form-label">Activity Level</label>
                            <select class="form-select" name="activity_level" id="activity_level" required>
                                <option value="">Select activity level</option>
                                <option value="sedentary">
                                    <i class="fas fa-couch"></i> Sedentary (little or no exercise)
                                </option>
                                <option value="light">
                                    <i class="fas fa-walking"></i> Light (exercise 1-3 times/week)
                                </option>
                                <option value="moderate">
                                    <i class="fas fa-running"></i> Moderate (exercise 3-5 times/week)
                                </option>
                                <option value="active">
                                    <i class="fas fa-dumbbell"></i> Active (exercise 6-7 times/week)
                                </option>
                                <option value="very_active">
                                    <i class="fas fa-fire"></i> Very Active (hard exercise & physical job)
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-calculator me-2"></i>Calculate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

.btn-check:checked + .btn-outline-primary {
    background-color: var(--blood-orange);
    border-color: var(--blood-orange);
    color: white;
}

.btn-outline-primary {
    border-color: var(--blood-orange);
    color: var(--blood-orange);
}

.btn-outline-primary:hover {
    background-color: var(--blood-orange);
    border-color: var(--blood-orange);
    color: white;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FF5349' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required]');

    inputs.forEach(input => {
        if (input.type !== 'radio') {
            input.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        }
    });

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endsection
