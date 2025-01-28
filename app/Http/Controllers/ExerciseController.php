<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\ExerciseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $exercises = Exercise::where('user_id', Auth::id())
            ->with(['progress' => function ($query) {
                $query->orderBy('date', 'desc');
            }])
            ->get();

        return view('exercises.index', compact('exercises'));
    }

    public function create()
    {
        return view('exercises.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,NULL,id,user_id,' . Auth::id(),
            'notes' => 'nullable|string',
        ]);

        $exercise = Exercise::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('exercises.show', $exercise)
            ->with('success', 'Exercise created successfully.');
    }

    public function show(Exercise $exercise)
    {
        $this->authorize('view', $exercise);
        
        $progress = $exercise->progress()
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($entry) {
                return [
                    'date' => $entry->date->format('Y-m-d'),
                    'weight' => $entry->weight,
                    'reps' => $entry->reps,
                ];
            });

        return view('exercises.show', compact('exercise', 'progress'));
    }

    public function addProgress(Request $request, Exercise $exercise)
    {
        $this->authorize('update', $exercise);

        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'weight' => 'required|numeric|min:0',
            'reps' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $progress = $exercise->progress()->create($validated);

        return redirect()->route('exercises.show', $exercise)
            ->with('success', 'Progress added successfully.');
    }

    public function destroy(Exercise $exercise)
    {
        $this->authorize('delete', $exercise);
        
        $exercise->delete();

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise deleted successfully.');
    }
}
