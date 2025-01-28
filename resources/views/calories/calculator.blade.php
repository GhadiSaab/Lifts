@extends('layouts.app')

@section('title', 'Calorie Calculator')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="max-w-md mx-auto">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Home
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Calorie Calculator</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4">
                    <form action="{{ route('calories.calculate') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight (kg)</label>
                            <input type="number" name="weight" id="weight" step="0.1" required min="20"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="e.g., 70">
                        </div>

                        <div class="mb-4">
                            <label for="height" class="block text-gray-700 text-sm font-bold mb-2">Height (cm)</label>
                            <input type="number" name="height" id="height" required min="100"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="e.g., 175">
                        </div>

                        <div class="mb-4">
                            <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                            <input type="number" name="age" id="age" required min="15" max="100"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="e.g., 25">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                            <div class="mt-2 space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="male" required
                                        class="form-radio text-blue-500">
                                    <span class="ml-2">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="female" required
                                        class="form-radio text-blue-500">
                                    <span class="ml-2">Female</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="activity" class="block text-gray-700 text-sm font-bold mb-2">Activity Level</label>
                            <select name="activity" id="activity" required
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select activity level</option>
                                <option value="sedentary">Sedentary (little or no exercise)</option>
                                <option value="light">Light (exercise 1-3 times/week)</option>
                                <option value="moderate">Moderate (exercise 3-5 times/week)</option>
                                <option value="active">Active (exercise 6-7 times/week)</option>
                                <option value="very_active">Very Active (hard exercise & physical job)</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Calculate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
