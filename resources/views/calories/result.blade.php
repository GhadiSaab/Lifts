@extends('layouts.app')

@section('title', 'Calorie Results')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="max-w-md mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Home
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Your Results</h1>
                </div>
                <a href="{{ route('calories.calculator') }}" class="text-blue-500 hover:text-blue-600">
                    Recalculate
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4">
                    <!-- Daily Calorie Needs -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daily Calorie Needs</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Basal Metabolic Rate (BMR):</span>
                                <span class="font-semibold">{{ $bmr }} calories</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Daily Energy Expenditure (TDEE):</span>
                                <span class="font-semibold">{{ $tdee }} calories</span>
                            </div>
                        </div>
                    </div>

                    <!-- Macronutrient Breakdown -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recommended Macros</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Protein (40%):</span>
                                <span class="font-semibold">{{ $macros['protein'] }}g</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Carbohydrates (30%):</span>
                                <span class="font-semibold">{{ $macros['carbs'] }}g</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Fats (30%):</span>
                                <span class="font-semibold">{{ $macros['fats'] }}g</span>
                            </div>
                        </div>
                    </div>

                    <!-- Weight Goals -->
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Weight Goals</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Weight Loss:</span>
                                <span class="font-semibold">{{ $tdee - 500 }} calories/day</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Weight Gain:</span>
                                <span class="font-semibold">{{ $tdee + 500 }} calories/day</span>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-500">
                            * Weight loss/gain calculations based on ±500 calories per day, which typically results in ±0.5kg per week.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
