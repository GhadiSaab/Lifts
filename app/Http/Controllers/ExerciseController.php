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

    public function index(Request $request)
    {
        $query = Exercise::where('user_id', Auth::id());
        
        if ($request->has('muscle_group')) {
            $query->where('muscle_group', $request->muscle_group);
        }

        $exercises = $query->with(['progress' => function ($query) {
            $query->orderBy('date', 'desc');
        }])->get();

        $muscleGroups = Exercise::getMuscleGroups();
        $streak = Auth::user()->calculateStreak();

        return view('exercises.index', compact('exercises', 'muscleGroups', 'streak'));
    }

    public function create()
    {
        $muscleGroups = Exercise::getMuscleGroups();
        return view('exercises.create', compact('muscleGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,NULL,id,user_id,' . Auth::id(),
            'muscle_group' => 'required|string|in:' . implode(',', Exercise::getMuscleGroups()),
            'notes' => 'nullable|string',
        ]);

        $exercise = Exercise::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'muscle_group' => $validated['muscle_group'],
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
                $data = [
                    'date' => $entry->date->format('Y-m-d'),
                    'sets' => $entry->sets->map(function ($set) {
                        return [
                            'weight' => $set->weight,
                            'reps' => $set->reps,
                            'rest_time' => $set->rest_time,
                            'set_number' => $set->set_number,
                        ];
                    }),
                ];
                if ($entry->notes) {
                    $data['notes'] = $entry->notes;
                }
                return $data;
            });

        return view('exercises.show', compact('exercise', 'progress'));
    }

    public function addProgress(Request $request, Exercise $exercise)
    {
        $this->authorize('update', $exercise);

        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'sets' => 'required|array|min:1',
            'sets.*.weight' => 'required|numeric|min:0',
            'sets.*.reps' => 'required|integer|min:1',
            'sets.*.rest_time' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $progress = $exercise->progress()->create([
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['sets'] as $index => $set) {
            $progress->sets()->create([
                'weight' => $set['weight'],
                'reps' => $set['reps'],
                'rest_time' => $set['rest_time'] ?? null,
                'set_number' => $index + 1,
            ]);
        }

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
