@extends('layouts.app')

@section('title', 'Add New Exercise')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-2">Add New Exercise</h1>
                    <p class="text-muted mb-0">Track your progress with a new exercise</p>
                </div>
                <a href="{{ route('exercises.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Exercises
                </a>
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

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('exercises.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4 position-relative">
                            <label for="name" class="form-label">Exercise Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required
                                placeholder="e.g., Bench Press">
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4 position-relative">
                            <label for="muscle_group" class="form-label">Muscle Group</label>
                            <select class="form-select" id="muscle_group" name="muscle_group" required>
                                <option value="">Select a muscle group</option>
                                @foreach($muscleGroups as $group)
                                    <option value="{{ $group }}" {{ old('muscle_group') == $group ? 'selected' : '' }}>
                                        {{ $group }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                placeholder="Add any notes about form, equipment setup, etc.">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('exercises.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Exercise
                            </button>
                        </div>
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

.form-control.is-valid,
.form-select.is-valid {
    border-color: var(--blood-orange);
    padding-right: 2.5rem;
    background-image: none;
}

.form-control.is-valid ~ .valid-feedback,
.form-select.is-valid ~ .valid-feedback {
    display: block;
}

.form-select {
    background-position: right 0.75rem center;
}

@keyframes checkmark {
    0% { transform: translateY(-50%) scale(0); }
    70% { transform: translateY(-50%) scale(1.2); }
    100% { transform: translateY(-50%) scale(1); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required]');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
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
