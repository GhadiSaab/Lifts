@extends('layouts.app')

@section('title', 'Exercise Progress')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Metric Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-fire fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Sets</h6>
                        <h2 class="card-title mb-0">{{ $exercises->sum(function($exercise) { 
                            return $exercise->progress->sum(function($progress) {
                                return $progress->sets->count();
                            });
                        }) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-fire fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Current Streak</h6>
                        <h2 class="card-title mb-0"> {{ $streak }} Days</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-chart-line fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Active Exercises</h6>
                        <h2 class="card-title mb-0">{{ $exercises->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exercise Timeline -->
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Exercise Progress</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
                        <i class="fas fa-plus me-2"></i>Add Exercise
                    </button>
                </div>

                <!-- Muscle Group Filter -->
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('exercises.index') }}" 
                        class="btn btn-outline-secondary {{ !request('muscle_group') ? 'active' : '' }}">
                        All
                    </a>
                    @foreach($muscleGroups as $group)
                        <a href="{{ route('exercises.index', ['muscle_group' => $group]) }}" 
                            class="btn btn-outline-{{ \App\Helpers\MuscleGroupHelper::getColor($group) }} {{ request('muscle_group') == $group ? 'active' : '' }}">
                            <i class="fas @muscleGroupIcon($group) me-2"></i>{{ $group }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="timeline">
                @forelse($exercises as $exercise)
                    <div class="card mb-4 exercise-card" data-exercise-id="{{ $exercise->id }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $exercise->name }}</h5>
                                    <span class="badge bg-{{ \App\Helpers\MuscleGroupHelper::getColor($exercise->muscle_group) }}">
                                        <i class="fas @muscleGroupIcon($exercise->muscle_group) me-1"></i>
                                        {{ $exercise->muscle_group }}
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('exercises.show', $exercise) }}">
                                                <i class="fas fa-chart-bar me-2"></i>View Progress
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('exercises.destroy', $exercise) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if($exercise->notes)
                                <p class="card-text text-muted mb-3">{{ $exercise->notes }}</p>
                            @endif

                            @if($exercise->progress->isNotEmpty())
                                @php
                                    $latestProgress = $exercise->progress->first();
                                    $progressPercentage = 0;
                                    
                                    if ($latestProgress && $latestProgress->sets->isNotEmpty() && 
                                        $exercise->progress->last() && $exercise->progress->last()->sets->isNotEmpty()) {
                                        
                                        $firstSet = $exercise->progress->last()->sets->first();
                                        $latestSet = $latestProgress->sets->first();
                                        
                                        if ($firstSet && $latestSet) {
                                            $firstWeight = $firstSet->weight;
                                            $currentWeight = $latestSet->weight;
                                            $progressPercentage = $firstWeight > 0 ? 
                                                min(100, round(($currentWeight - $firstWeight) / $firstWeight * 100)) : 0;
                                        }
                                    }
                                @endphp
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: {{ max(5, $progressPercentage) }}%; background-color: var(--blood-orange);" 
                                        aria-valuenow="{{ $progressPercentage }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>Last: {{ $latestProgress->date->format('M d, Y') }}</span>
                                    @if($latestProgress->sets->isNotEmpty() && $latestProgress->sets->first())
                                        <span>{{ $latestProgress->sets->first()->weight }}kg × {{ $latestProgress->sets->first()->reps }}</span>
                                    @else
                                        <span>No sets recorded</span>
                                    @endif
                                </div>
                            @else
                                <p class="text-muted mb-0">No progress recorded yet</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-dumbbell fa-3x mb-3" style="color: var(--slate-gray);"></i>
                        <h5>No exercises added yet</h5>
                        <p class="text-muted">Start by adding your first exercise!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Quick Stats</h5>
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Most Active Exercise</h6>
                        @if($exercises->isNotEmpty() && $exercises->first()->progress->isNotEmpty())
                            <p class="h4">{{ $exercises->sortByDesc(function($exercise) { 
                                return $exercise->progress->count(); 
                            })->first()->name }}</p>
                        @else
                            <p class="text-muted">No data available</p>
                        @endif
                    </div>
                    <div>
                        <h6 class="text-muted mb-2">Last Workout</h6>
                        @php
                            $lastWorkout = $exercises->flatMap->progress->sortByDesc('date')->first();
                        @endphp
                        @if($lastWorkout)
                            <p class="h4">{{ $lastWorkout->date->format('M d, Y') }}</p>
                        @else
                            <p class="text-muted">No workouts logged</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1000;">
    <button type="button" class="btn btn-primary rounded-circle shadow-lg p-3" 
        data-bs-toggle="modal" data-bs-target="#quickLogModal" 
        style="width: 60px; height: 60px;">
        <i class="fas fa-plus"></i>
    </button>
</div>

<!-- Add Exercise Modal -->
<div class="modal fade" id="addExerciseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Add New Exercise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('exercises.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Exercise Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="muscle_group" class="form-label">Muscle Group</label>
                        <select class="form-select" id="muscle_group" name="muscle_group" required>
                            <option value="">Select a muscle group</option>
                            @foreach($muscleGroups as $group)
                                <option value="{{ $group }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Exercise</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quick Log Modal -->
<div class="modal fade" id="quickLogModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Quick Log Workout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Simplified form approach -->
                <form id="quickLogForm">
                    @csrf
                    <div class="mb-3">
                        <label for="exercise_dropdown" class="form-label">Exercise</label>
                        <select class="form-select" id="exercise_dropdown" required>
                            @foreach($exercises as $exercise)
                                <option value="{{ $exercise->id }}">
                                    {{ $exercise->name }} 
                                    <small>({{ $exercise->muscle_group }})</small>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="workout_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="workout_date" required>
                    </div>
                    
                    <div id="sets-container">
                        <div class="set-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Set 1</h6>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-set" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" class="form-control weight-input" name="sets[0][weight]" required step="0.5">
                                </div>
                                <div class="col">
                                    <label class="form-label">Reps</label>
                                    <input type="number" class="form-control reps-input" name="sets[0][reps]" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Rest (sec)</label>
                                    <input type="number" class="form-control rest-input" name="sets[0][rest_time]">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-outline-primary mb-3" id="add-set">
                        <i class="fas fa-plus me-2"></i>Add Set
                    </button>
                    
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="logProgressBtn">Log Progress</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.exercise-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.exercise-card:hover {
    transform: translateY(-2px);
}

.timeline::before {
    content: '';
    position: absolute;
    left: 2rem;
    height: 100%;
    width: 2px;
    background: rgba(45, 55, 72, 0.1);
}

.btn-primary {
    transition: transform 0.2s ease;
}

.btn-primary:active {
    transform: scale(0.95);
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.animate-weight {
    animation: bounce 0.5s ease;
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set management
    const setsContainer = document.getElementById('sets-container');
    const addSetBtn = document.getElementById('add-set');
    let setCount = 1;

    // Set today's date as default for date input
    const dateInput = document.getElementById('date');
    if (dateInput) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        dateInput.value = `${yyyy}-${mm}-${dd}`;
    }

    addSetBtn.addEventListener('click', function() {
        setCount++;
        const setHtml = `
            <div class="set-group mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Set ${setCount}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-set">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" class="form-control weight-input" name="sets[${setCount-1}][weight]" required step="0.5">
                    </div>
                    <div class="col">
                        <label class="form-label">Reps</label>
                        <input type="number" class="form-control reps-input" name="sets[${setCount-1}][reps]" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Rest (sec)</label>
                        <input type="number" class="form-control rest-input" name="sets[${setCount-1}][rest_time]">
                    </div>
                </div>
            </div>
        `;
        setsContainer.insertAdjacentHTML('beforeend', setHtml);
        
        if (setCount > 1) {
            document.querySelector('.set-group:first-child .remove-set').style.display = 'block';
        }
    });

    setsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-set')) {
            e.target.closest('.set-group').remove();
            setCount--;
            
            // Update set numbers
            document.querySelectorAll('.set-group').forEach((group, index) => {
                group.querySelector('h6').textContent = `Set ${index + 1}`;
                group.querySelectorAll('input').forEach(input => {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                });
            });

            // Hide remove button if only one set remains
            if (setCount === 1) {
                document.querySelector('.set-group:first-child .remove-set').style.display = 'none';
            }
        }
    });

    // Super simplified approach that will definitely work
    document.getElementById('logProgressBtn').addEventListener('click', function() {
        const exerciseId = document.getElementById('exercise_dropdown').value;
        const workoutDate = document.getElementById('workout_date').value;
        
        // Create a temporary form
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = '/exercises/' + exerciseId + '/progress';
        tempForm.style.display = 'none';
        
        // Add CSRF token
        let csrfToken;
        // Try to get from meta tag
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            csrfToken = metaTag.getAttribute('content');
        } else {
            // Fallback to getting from the form
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) {
                csrfToken = tokenInput.value;
            }
        }
        
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page and try again.');
            return;
        }
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        tempForm.appendChild(csrfInput);
        
        // Add date
        const dateInput = document.createElement('input');
        dateInput.type = 'hidden';
        dateInput.name = 'date';
        dateInput.value = workoutDate;
        tempForm.appendChild(dateInput);
        
        // Add sets data
        const setGroups = document.querySelectorAll('.set-group');
        setGroups.forEach((group, index) => {
            const weight = group.querySelector('.weight-input').value;
            const reps = group.querySelector('.reps-input').value;
            const rest = group.querySelector('.rest-input').value || 0;
            
            const weightInput = document.createElement('input');
            weightInput.type = 'hidden';
            weightInput.name = `sets[${index}][weight]`;
            weightInput.value = weight;
            tempForm.appendChild(weightInput);
            
            const repsInput = document.createElement('input');
            repsInput.type = 'hidden';
            repsInput.name = `sets[${index}][reps]`;
            repsInput.value = reps;
            tempForm.appendChild(repsInput);
            
            const restInput = document.createElement('input');
            restInput.type = 'hidden';
            restInput.name = `sets[${index}][rest_time]`;
            restInput.value = rest;
            tempForm.appendChild(restInput);
        });
        
        // Submit the form
        document.body.appendChild(tempForm);
        tempForm.submit();
    });
    
    // Set today's date for workout date
    const workoutDateInput = document.getElementById('workout_date');
    if (workoutDateInput) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        workoutDateInput.value = `${yyyy}-${mm}-${dd}`;
    }
    
    // Initialize form with first exercise if available
    const exerciseSelect = document.getElementById('exercise_dropdown');
    const quickLogForm = document.getElementById('quickLogForm');
    
    if (exerciseSelect?.options.length > 0) {
        const firstExerciseId = exerciseSelect.options[0].value;
        if (quickLogForm) {
            quickLogForm.setAttribute('data-exercise-id', firstExerciseId);
        }
    }
});
</script>
@endsection
