@extends('layouts.app')

@section('title', 'Meal Tracking')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Home
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Meal Tracking</h1>
            </div>
            <a href="{{ route('meals.history') }}" class="text-blue-500 hover:text-blue-700">
                View History
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Date Selection -->
        <div class="mb-6">
            <form action="{{ route('meals.index') }}" method="GET" class="flex gap-4 items-end">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                        Select Date
                    </label>
                    <input 
                        type="date"
                        id="date"
                        name="date"
                        value="{{ $date }}"
                        class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        onchange="this.form.submit()"
                    >
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Daily Summary -->
            <div class="lg:col-span-3 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Daily Summary</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded">
                        <div class="text-sm text-gray-600">Total Calories</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $summary['total_calories'] }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded">
                        <div class="text-sm text-gray-600">Protein (g)</div>
                        <div class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_protein'], 1) }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded">
                        <div class="text-sm text-gray-600">Carbs (g)</div>
                        <div class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_carbs'], 1) }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded">
                        <div class="text-sm text-gray-600">Fat (g)</div>
                        <div class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_fat'], 1) }}</div>
                    </div>
                </div>
            </div>

            <!-- Add Meal Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Log Meal</h2>
                <form action="{{ route('meals.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="meal_type">
                                Meal Type
                            </label>
                            <select
                                id="meal_type"
                                name="meal_type"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="snack">Snack</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Description
                            </label>
                            <input 
                                type="text"
                                id="description"
                                name="description"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                                placeholder="e.g., Chicken Salad"
                            >
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="calories">
                                Calories
                            </label>
                            <input 
                                type="number"
                                id="calories"
                                name="calories"
                                min="0"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="protein">
                                    Protein (g)
                                </label>
                                <input 
                                    type="number"
                                    id="protein"
                                    name="protein"
                                    min="0"
                                    step="0.1"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="carbs">
                                    Carbs (g)
                                </label>
                                <input 
                                    type="number"
                                    id="carbs"
                                    name="carbs"
                                    min="0"
                                    step="0.1"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="fat">
                                    Fat (g)
                                </label>
                                <input 
                                    type="number"
                                    id="fat"
                                    name="fat"
                                    min="0"
                                    step="0.1"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required
                                >
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Add Meal
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Meals List -->
            <div class="lg:col-span-2 space-y-6">
                @foreach(['breakfast', 'lunch', 'dinner', 'snack'] as $type)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 capitalize">{{ $type }}</h2>
                        @if(isset($meals[$type]))
                            <div class="space-y-4">
                                @foreach($meals[$type] as $meal)
                                    <div class="flex justify-between items-start border-b pb-4">
                                        <div>
                                            <div class="font-medium">{{ $meal->description }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $meal->calories }} cal | 
                                                P: {{ $meal->protein }}g | 
                                                C: {{ $meal->carbs }}g | 
                                                F: {{ $meal->fat }}g
                                            </div>
                                        </div>
                                        <form action="{{ route('meals.destroy', $meal) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No meals logged</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
