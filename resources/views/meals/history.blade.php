<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Meal History</h1>
            <a href="{{ route('meals.index') }}" class="text-blue-500 hover:text-blue-700">
                Back to Meal Tracking
            </a>
        </div>

        <!-- Date Range Selection -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form action="{{ route('meals.history') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                        Start Date
                    </label>
                    <input 
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">
                        End Date
                    </label>
                    <input 
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Range
                    </button>
                </div>
            </form>
        </div>

        <!-- History Chart -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Calorie History</h2>
            <canvas id="calorieChart"></canvas>
        </div>

        <!-- Daily Summaries -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <h2 class="text-xl font-semibold text-gray-800 p-6 pb-4">Daily Summaries</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Calories</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protein (g)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carbs (g)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fat (g)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($dailySummaries as $date => $summary)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $summary['total_calories'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($summary['total_protein'], 1) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($summary['total_carbs'], 1) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($summary['total_fat'], 1) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No meal data available for this date range
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Initialize calorie history chart
        const ctx = document.getElementById('calorieChart').getContext('2d');
        const summaryData = @json($dailySummaries);
        const dataPoints = Object.keys(summaryData).map(dateStr => ({
            x: dateStr,
            y: summaryData[dateStr].total_calories
        }));

        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Daily Calories',
                    data: dataPoints,
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: (context) => {
                                const date = new Date(context[0].label);
                                return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                            },
                            label: (context) => `${context.raw.y} calories`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Calories'
                        }
                    },
                    x: {
                        type: 'category',
                        labels: Object.keys(summaryData),
                        title: {
                            display: true,
                            text: 'Date'
                        },
                        ticks: {
                            autoSkip: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
