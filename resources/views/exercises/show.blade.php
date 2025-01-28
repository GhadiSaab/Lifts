<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exercise->name }} - Progress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">{{ $exercise->name }}</h1>
                <a href="{{ route('exercises.index') }}" class="text-blue-500 hover:text-blue-700">
                    Back to Exercises
                </a>
            </div>
            @if($exercise->notes)
                <p class="text-gray-600 mt-2">{{ $exercise->notes }}</p>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Progress Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Progress Chart</h2>
                <canvas id="progressChart"></canvas>
            </div>

            <!-- Add Progress Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Log Progress</h2>
                <form action="{{ route('exercises.progress.add', $exercise) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                                Date
                            </label>
                            <input 
                                type="date"
                                id="date"
                                name="date"
                                value="{{ old('date', date('Y-m-d')) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="weight">
                                Weight (kg)
                            </label>
                            <input 
                                type="number"
                                id="weight"
                                name="weight"
                                step="0.5"
                                min="0"
                                value="{{ old('weight') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="reps">
                                Reps
                            </label>
                            <input 
                                type="number"
                                id="reps"
                                name="reps"
                                min="1"
                                value="{{ old('reps') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                                Notes (Optional)
                            </label>
                            <textarea
                                id="notes"
                                name="notes"
                                rows="2"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            >{{ old('notes') }}</textarea>
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Add Progress
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Progress History -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
                <h2 class="text-xl font-semibold text-gray-800 p-6 pb-4">Progress History</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (kg)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reps</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($progress as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry['date'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry['weight'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry['reps'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $entry['notes'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No progress entries yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize progress chart
        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressData = @json($progress);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: progressData.map(entry => entry.date),
                datasets: [{
                    label: 'Weight (kg)',
                    data: progressData.map(entry => entry.weight),
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Weight (kg)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const entry = progressData[context.dataIndex];
                                return `Weight: ${entry.weight}kg, Reps: ${entry.reps}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
