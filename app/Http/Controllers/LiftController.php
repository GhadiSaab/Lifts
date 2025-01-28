<?php

namespace App\Http\Controllers;

use App\Models\Lift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['calorieCalculator', 'calculateCalories']);
    }

    public function index()
    {
        $lifts = Lift::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('lifts.index', compact('lifts'));
    }

    public function create()
    {
        return view('lifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'reps' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();
        Lift::create($validated);

        return redirect()->route('lifts.index')
            ->with('success', 'Lift recorded successfully!');
    }

    public function edit(Lift $lift)
    {
        $this->authorize('update', $lift);
        return view('lifts.edit', compact('lift'));
    }

    public function update(Request $request, Lift $lift)
    {
        $this->authorize('update', $lift);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'reps' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $lift->update($validated);

        return redirect()->route('lifts.index')
            ->with('success', 'Lift updated successfully!');
    }

    public function destroy(Lift $lift)
    {
        $this->authorize('delete', $lift);
        
        $lift->delete();

        return redirect()->route('lifts.index')
            ->with('success', 'Lift deleted successfully!');
    }

    public function calorieCalculator()
    {
        return view('calories.calculator');
    }

    public function calculateCalories(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:20',
            'height' => 'required|numeric|min:100',
            'age' => 'required|integer|min:15|max:100',
            'gender' => 'required|in:male,female',
            'activity' => 'required|in:sedentary,light,moderate,active,very_active'
        ]);

        // Harris-Benedict BMR Formula
        if ($validated['gender'] === 'male') {
            $bmr = 88.362 + (13.397 * $validated['weight']) + 
                   (4.799 * $validated['height']) - (5.677 * $validated['age']);
        } else {
            $bmr = 447.593 + (9.247 * $validated['weight']) + 
                   (3.098 * $validated['height']) - (4.330 * $validated['age']);
        }

        // Activity multipliers
        $multipliers = [
            'sedentary' => 1.2,      // Little/no exercise
            'light' => 1.375,        // Light exercise 1-3 times/week
            'moderate' => 1.55,      // Moderate exercise 3-5 times/week
            'active' => 1.725,       // Heavy exercise 6-7 times/week
            'very_active' => 1.9     // Very heavy exercise, physical job
        ];

        $tdee = $bmr * $multipliers[$validated['activity']];
        
        // Calculate macros (example split: 40% protein, 30% carbs, 30% fat)
        $macros = [
            'protein' => round(($tdee * 0.4) / 4), // 4 calories per gram of protein
            'carbs' => round(($tdee * 0.3) / 4),   // 4 calories per gram of carbs
            'fats' => round(($tdee * 0.3) / 9)     // 9 calories per gram of fat
        ];

        return view('calories.result', [
            'tdee' => round($tdee),
            'bmr' => round($bmr),
            'macros' => $macros
        ]);
    }
}
