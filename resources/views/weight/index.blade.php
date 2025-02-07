@extends('layouts.app')

@section('title', 'Weight Tracking')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Daily Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-weight fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Current Weight</h6>
                        <h2 class="card-title mb-0">{{ $weightLogs->first() ? $weightLogs->first()->weight . ' kg' : '-' }}</h2>
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
                        <h6 class="card-subtitle mb-1 text-muted">Total Change</h6>
                        @php
                            $firstWeight = $weightLogs->last()?->weight;
                            $currentWeight = $weightLogs->first()?->weight;
                            $change = $firstWeight && $currentWeight ? $currentWeight - $firstWeight : 0;
                        @endphp
                        <h2 class="card-title mb-0">{{ $change ? sprintf('%+.1f kg', $change) : '-' }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: rgba(255, 83, 73, 0.1);">
                        <i class="fas fa-calendar-check fa-2x" style="color: var(--blood-orange);"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Entries</h6>
                        <h2 class="card-title mb-0">{{ $weightLogs->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Weight Chart -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Weight Progress</h5>
                    <div class="chart-container">
                        <canvas id="weightChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Weight Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Log Weight</h5>
                    <form action="{{ route('weight.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3 position-relative">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ old('date', date('Y-m-d')) }}" required>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control" id="weight" name="weight"
                                step="0.1" min="20" max="500" value="{{ old('weight') }}" required>
                            <div class="valid-feedback">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Log Weight
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Weight History -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Weight History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Weight (kg)</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($weightLogs as $log)
                                    <tr>
                                        <td>{{ $log->date->format('Y-m-d') }}</td>
                                        <td>{{ $log->weight }}</td>
                                        <td>{{ $log->notes ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('weight.destroy', $log) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" 
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="fas fa-weight fa-2x mb-2"></i>
                                            <p class="mb-0">No weight logs yet</p>
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

.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}

.table tbody tr {
    transition: background-color 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(255, 83, 73, 0.05);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
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

    // Initialize weight chart
    const ctx = document.getElementById('weightChart').getContext('2d');
    const chartData = @json($chartData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(entry => entry.date),
            datasets: [{
                label: 'Weight (kg)',
                data: chartData.map(entry => entry.weight),
                borderColor: 'rgb(255, 83, 73)',
                backgroundColor: 'rgba(255, 83, 73, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
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
                        title: (context) => {
                            const date = new Date(context[0].label);
                            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        },
                        label: function(context) {
                            const entry = chartData[context.dataIndex];
                            return `Weight: ${entry.weight}kg`;
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
        }
    });
});
</script>
@endsection
