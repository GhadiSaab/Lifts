@extends('layouts.app')

@section('title', 'Calorie Results')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-2">Your Results</h1>
                    <p class="text-muted mb-0">Daily calorie and macro breakdown</p>
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ route('calories.calculator') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calculator me-2"></i>Recalculate
                    </a>
                </div>
            </div>

            <!-- Daily Calorie Needs -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                                <i class="fas fa-fire fa-2x" style="color: var(--blood-orange);"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 text-muted">Basal Metabolic Rate</h6>
                                <h2 class="card-title mb-0">{{ $bmr }} <small class="text-muted">cal</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                                <i class="fas fa-bolt fa-2x" style="color: var(--blood-orange);"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 text-muted">Daily Energy Expenditure</h6>
                                <h2 class="card-title mb-0">{{ $tdee }} <small class="text-muted">cal</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Macronutrient Breakdown -->
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-chart-pie me-2" style="color: var(--blood-orange);"></i>
                                Recommended Macros
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="text-center p-3" style="background: rgba(255, 83, 73, 0.1); border-radius: 8px;">
                                        <i class="fas fa-drumstick-bite mb-2" style="color: var(--blood-orange);"></i>
                                        <h6 class="mb-2">Protein</h6>
                                        <h4 class="mb-1">{{ $macros['protein'] }}g</h4>
                                        <small class="text-muted">40%</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3" style="background: rgba(255, 83, 73, 0.1); border-radius: 8px;">
                                        <i class="fas fa-bread-slice mb-2" style="color: var(--blood-orange);"></i>
                                        <h6 class="mb-2">Carbs</h6>
                                        <h4 class="mb-1">{{ $macros['carbs'] }}g</h4>
                                        <small class="text-muted">30%</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3" style="background: rgba(255, 83, 73, 0.1); border-radius: 8px;">
                                        <i class="fas fa-cheese mb-2" style="color: var(--blood-orange);"></i>
                                        <h6 class="mb-2">Fats</h6>
                                        <h4 class="mb-1">{{ $macros['fats'] }}g</h4>
                                        <small class="text-muted">30%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weight Goals -->
                <div class="col-lg-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-bullseye me-2" style="color: var(--blood-orange);"></i>
                                Weight Goals
                            </h5>
                            <div class="d-flex align-items-center mb-3 p-3" style="background: rgba(255, 83, 73, 0.1); border-radius: 8px;">
                                <div class="me-3">
                                    <i class="fas fa-arrow-down" style="color: var(--blood-orange);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Weight Loss</h6>
                                    <h4 class="mb-0">{{ $tdee - 500 }} <small class="text-muted">cal/day</small></h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center p-3" style="background: rgba(255, 83, 73, 0.1); border-radius: 8px;">
                                <div class="me-3">
                                    <i class="fas fa-arrow-up" style="color: var(--blood-orange);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Weight Gain</h6>
                                    <h4 class="mb-0">{{ $tdee + 500 }} <small class="text-muted">cal/day</small></h4>
                                </div>
                            </div>
                            <p class="text-muted small mt-3 mb-0">
                                * Weight loss/gain calculations based on ±500 calories per day, which typically results in ±0.5kg per week.
                            </p>
                        </div>
                    </div>
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

.card h4 {
    color: var(--slate-gray);
}

.card h6 {
    color: var(--slate-gray);
}

.text-muted {
    color: #6c757d !important;
}
</style>
@endsection
