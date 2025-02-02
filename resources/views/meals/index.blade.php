@extends('layouts.app')

@section('title', 'Meal Tracking')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Date Selection -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2">Meal Tracking</h1>
            <p class="text-muted mb-0">Track your daily nutrition</p>
        </div>
        <div class="d-flex gap-3">
            <form action="{{ route('meals.index') }}" method="GET" class="d-flex align-items-center">
                <input type="date" class="form-control me-2" id="date" name="date"
                    value="{{ $date }}" onchange="this.form.submit()">
            </form>
            <a href="{{ route('meals.history') }}" class="btn btn-outline-primary">
                <i class="fas fa-history me-2"></i>View History
            </a>
        </div>
    </div>

    <!-- Daily Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-fire fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Calories</h6>
                        <h2 class="card-title mb-0">{{ $summary['total_calories'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-drumstick-bite fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Protein</h6>
                        <h2 class="card-title mb-0">{{ number_format($summary['total_protein'], 1) }}g</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-bread-slice fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Carbs</h6>
                        <h2 class="card-title mb-0">{{ number_format($summary['total_carbs'], 1) }}g</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-cheese fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Fat</h6>
                        <h2 class="card-title mb-0">{{ number_format($summary['total_fat'], 1) }}g</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Add Meal Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Log Meal</h5>
                    <form action="{{ route('meals.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">
                        
                        <div class="mb-3">
                            <label for="meal_type" class="form-label">Meal Type</label>
                            <select class="form-select" id="meal_type" name="meal_type" required>
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="snack">Snack</option>
                            </select>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                required placeholder="e.g., Chicken Salad">
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="calories" class="form-label">Calories</label>
                            <input type="number" class="form-control" id="calories" name="calories"
                                min="0" required>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-4 position-relative">
                                <label for="protein" class="form-label">Protein (g)</label>
                                <input type="number" class="form-control" id="protein" name="protein"
                                    min="0" step="0.1" required>
                                <div class="valid-feedback">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>

                            <div class="col-4 position-relative">
                                <label for="carbs" class="form-label">Carbs (g)</label>
                                <input type="number" class="form-control" id="carbs" name="carbs"
                                    min="0" step="0.1" required>
                                <div class="valid-feedback">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>

                            <div class="col-4 position-relative">
                                <label for="fat" class="form-label">Fat (g)</label>
                                <input type="number" class="form-control" id="fat" name="fat"
                                    min="0" step="0.1" required>
                                <div class="valid-feedback">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Add Meal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Meals List -->
        <div class="col-lg-8">
            @foreach(['breakfast', 'lunch', 'dinner', 'snack'] as $type)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-{{ $type === 'breakfast' ? 'sun' : ($type === 'lunch' ? 'cloud-sun' : ($type === 'dinner' ? 'moon' : 'cookie-bite')) }} me-2" 
                                style="color: var(--blood-orange);"></i>
                            <h5 class="card-title mb-0 text-capitalize">{{ $type }}</h5>
                        </div>
                        
                        @if(isset($meals[$type]))
                            <div class="meal-list">
                                @foreach($meals[$type] as $meal)
                                    <div class="meal-item d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div>
                                            <div class="fw-medium">{{ $meal->description }}</div>
                                            <div class="text-muted small">
                                                {{ $meal->calories }} cal | 
                                                P: {{ $meal->protein }}g | 
                                                C: {{ $meal->carbs }}g | 
                                                F: {{ $meal->fat }}g
                                            </div>
                                        </div>
                                        <form action="{{ route('meals.destroy', $meal) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0" 
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No meals logged</p>
                        @endif
                    </div>
                </div>
            @endforeach
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

.meal-item {
    transition: all 0.2s ease;
}

.meal-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

.meal-item:hover {
    background-color: rgba(255, 83, 73, 0.05);
    border-radius: 8px;
    padding: 0.5rem;
    margin: -0.5rem;
    margin-bottom: calc(0.75rem - 0.5rem);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required]');

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
