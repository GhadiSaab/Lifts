@extends('layouts.app')

@section('title', 'Exercise Progress')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Exercise Tracking</h1>
            <a href="{{ route('exercises.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add New Exercise
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($exercises as $exercise)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $exercise->name }}</h2>
                        <form action="{{ route('exercises.destroy', $exercise) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </div>

                    @if($exercise->notes)
                        <p class="text-gray-600 mb-4">{{ $exercise->notes }}</p>
                    @endif

                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Latest Progress:</h3>
                        @if($exercise->progress->isNotEmpty())
                            <div class="text-sm text-gray-600">
                                <p>Date: {{ $exercise->progress->first()->date->format('Y-m-d') }}</p>
                                <p>Weight: {{ $exercise->progress->first()->weight }} kg</p>
                                <p>Reps: {{ $exercise->progress->first()->reps }}</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No progress recorded yet</p>
                        @endif
                    </div>

                    <a href="{{ route('exercises.show', $exercise) }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        View Details & Progress
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No exercises added yet. Start by adding your first exercise!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
