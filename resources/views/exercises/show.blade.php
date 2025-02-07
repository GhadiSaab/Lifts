@extends('layouts.app')

@section('title', $exercise->name . ' - Progress')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2">{{ $exercise->name }}</h1>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-{{ \App\Helpers\MuscleGroupHelper::getColor($exercise->muscle_group) }}">
                    <i class="fas @muscleGroupIcon($exercise->muscle_group) me-1"></i>
                    {{ $exercise->muscle_group }}
                </span>
                @if($exercise->notes)
                    <p class="text-muted mb-0">{{ $exercise->notes }}</p>
                @endif
            </div>
        </div>
        <a href="{{ route('exercises.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Exercises
        </a>
    </div>

    <div class="row g-4">
        <!-- Progress Chart -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Progress Chart</h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="showAllSets">
                            <label class="form-check-label" for="showAllSets">Show All Sets</label>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Progress Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Log Progress</h5>
                    <form action="{{ route('exercises.progress.store', $exercise) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ old('date', date('Y-m-d')) }}" required>
                            <div class="invalid-feedback">
                                Please select a date
                            </div>
                        </div>

                        <div id="sets-container">
                            @php $firstSetId = 'set-' . time(); @endphp
                            <div class="set-group mb-3" data-set-id="{{ $firstSetId }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Set 1</h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-set" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label class="form-label" for="weight-{{ $firstSetId }}">Weight (kg)</label>
                                        <input type="number" class="form-control" id="weight-{{ $firstSetId }}"
                                            name="sets[0][weight]" required step="0.5" min="0">
                                        <div class="invalid-feedback">
                                            Please enter a weight value
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="reps-{{ $firstSetId }}">Reps</label>
                                        <input type="number" class="form-control" id="reps-{{ $firstSetId }}"
                                            name="sets[0][reps]" required min="1">
                                        <div class="invalid-feedback">
                                            Please enter number of reps
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="rest-{{ $firstSetId }}">Rest (sec)</label>
                                        <input type="number" class="form-control" id="rest-{{ $firstSetId }}"
                                            name="sets[0][rest_time]" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary mb-3 w-100" id="add-set">
                            <i class="fas fa-plus me-2"></i>Add Set
                        </button>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Save Progress
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Progress History -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Progress History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sets</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($progress as $entry)
                                    <tr>
                                        <td>{{ $entry['date'] }}</td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                @foreach($entry['sets'] as $set)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-light text-dark">Set {{ $set['set_number'] }}</span>
                                                        <span>{{ $set['weight'] }}kg × {{ $set['reps'] }}</span>
                                                        @if($set['rest_time'])
                                                            <small class="text-muted">({{ $set['rest_time'] }}s rest)</small>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>{{ $entry['notes'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-clipboard fa-2x mb-2"></i>
                                            <p class="mb-0">No progress entries yet</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Check all required inputs
        form.querySelectorAll('input[required]').forEach(input => {
            if (!input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });

    // Set management
    let setCount = 1;
    const setsContainer = document.getElementById('sets-container');
    const addSetBtn = document.getElementById('add-set');

    function resetValidation() {
        form.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });
        form.classList.remove('was-validated');
    }

    addSetBtn.addEventListener('click', function() {
        resetValidation();
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
                        <input type="number" class="form-control" name="sets[${setCount-1}][weight]" 
                            required step="0.5" min="0">
                        <div class="invalid-feedback">
                            Please enter a weight value
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">Reps</label>
                        <input type="number" class="form-control" name="sets[${setCount-1}][reps]" 
                            required min="1">
                        <div class="invalid-feedback">
                            Please enter number of reps
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">Rest (sec)</label>
                        <input type="number" class="form-control" name="sets[${setCount-1}][rest_time]" 
                            min="0">
                    </div>
                </div>
            </div>
        `;
        setsContainer.insertAdjacentHTML('beforeend', setHtml);
        
        // Show all remove buttons when there's more than one set
        if (setCount > 1) {
            document.querySelectorAll('.remove-set').forEach(btn => {
                btn.style.display = 'block';
            });
        }
    });

    // Event delegation for remove buttons
    setsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-set')) {
            resetValidation();
            e.target.closest('.set-group').remove();
            setCount--;
            
            // Update set numbers and names
            document.querySelectorAll('.set-group').forEach((group, index) => {
                group.querySelector('h6').textContent = `Set ${index + 1}`;
                group.querySelectorAll('input').forEach(input => {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/sets\[\d+\]/, `sets[${index}]`));
                });
            });
            
            // Hide remove button if only one set remains
            if (setCount === 1) {
                document.querySelector('.remove-set').style.display = 'none';
            }
        }
    });

    // Initialize progress chart
    const ctx = document.getElementById('progressChart').getContext('2d');
    const progressData = @json($progress)
        .sort((a, b) => new Date(a.date) - new Date(b.date)); // Sort by date ascending
    let chart;

    function showEmptyState(message) {
        const canvas = document.getElementById('progressChart');
        const container = canvas.parentElement;
        
        // Clear existing content
        container.innerHTML = '';
        
        // Create and append empty state message
        const emptyState = document.createElement('div');
        emptyState.className = 'text-center text-muted py-5';
        emptyState.innerHTML = `
            <i class="fas fa-chart-line fa-3x mb-3"></i>
            <p class="mb-0">${message}</p>
        `;
        container.appendChild(emptyState);
    }
    
    function initChart(showAllSets = false) {
        try {
            // Clear any existing chart
            if (chart) {
                chart.destroy();
            }

            // Get fresh canvas context
            const canvas = document.getElementById('progressChart');
            const ctx = canvas.getContext('2d');

            if (!progressData || !progressData.length) {
                showEmptyState('No progress entries yet');
                return;
            }

            // Sort data chronologically
            const sortedData = [...progressData].sort((a, b) => new Date(a.date) - new Date(b.date));

            // Prepare datasets
            const datasets = [];
            const colors = ['#FF5349', '#4994FF', '#49FF53', '#FF49FF', '#FFC849'];

            if (showAllSets) {
                // Find maximum number of sets across all entries
                const maxSets = Math.max(...sortedData.map(entry => entry.sets.length));

                // Create a dataset for each set number
                for (let i = 0; i < maxSets; i++) {
                    const setData = sortedData.map(entry => ({
                        x: new Date(entry.date),
                        y: entry.sets[i]?.weight || null
                    })).filter(point => point.y !== null);

                    if (setData.length > 0) {
                        datasets.push({
                            label: `Set ${i + 1}`,
                            data: setData,
                            borderColor: colors[i % colors.length],
                            backgroundColor: colors[i % colors.length] + '20',
                            borderWidth: 2,
                            tension: 0.1,
                            fill: true
                        });
                    }
                }
            } else {
                // Show only first set
                const firstSetData = sortedData
                    .filter(entry => entry.sets && entry.sets.length > 0)
                    .map(entry => ({
                        x: new Date(entry.date),
                        y: entry.sets[0].weight
                    }));

                datasets.push({
                    label: 'First Set',
                    data: firstSetData,
                    borderColor: colors[0],
                    backgroundColor: colors[0] + '20',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: true
                });
            }

            // Create new chart
            chart = new Chart(ctx, {
                type: 'line',
                data: { datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                displayFormats: {
                                    day: 'MMM d'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Weight (kg)'
                            }
                        }
                    },
                    plugins: {
                    tooltip: {
                        callbacks: {
                            title: (context) => {
                                const date = new Date(context[0].raw.x);
                                return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                            },
                            label: function(context) {
                                const dataIndex = context.dataIndex;
                                const datasetIndex = context.datasetIndex;
                                const entry = sortedData[dataIndex];
                                const set = entry.sets[datasetIndex];
                                return set ? 
                                    `Weight: ${set.weight}kg, Reps: ${set.reps}` : 
                                    `Weight: ${context.parsed.y}kg`;
                            }
                        }
                    }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        } catch (error) {
            console.error('Chart initialization error:', error);
            showEmptyState('Error loading chart');
        }
    }

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        scales: {
            y: {
                beginAtZero: false,
                title: {
                    display: true,
                    text: 'Weight (kg)'
                },
                grid: {
                    color: 'rgba(45, 55, 72, 0.1)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Date'
                },
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const entry = progressData[context.dataIndex];
                        const set = entry.sets[context.datasetIndex];
                        return set ? `Weight: ${set.weight}kg, Reps: ${set.reps}` : '';
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        },
        animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    };

    // Initialize chart with first set only
    initChart(false);

    // Handle toggle switch
    document.getElementById('showAllSets').addEventListener('change', function() {
        initChart(this.checked);
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

.table tbody tr {
    transition: background-color 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(255, 83, 73, 0.05);
}

.chart-container {
    position: relative;
    min-height: 400px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

canvas#progressChart {
    width: 100% !important;
    height: 100% !important;
}
</style>
@endsection
