<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $weightLogs = WeightLog::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        $chartData = WeightLog::getWeightHistory(Auth::id());

        return view('weight.index', compact('weightLogs', 'chartData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'weight' => 'required|numeric|min:20|max:500',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        // Update existing entry for the same date or create new one
        WeightLog::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => $validated['date']
            ],
            $validated
        );

        return redirect()->route('weight.index')
            ->with('success', 'Weight logged successfully.');
    }

    public function destroy(WeightLog $weightLog)
    {
        $this->authorize('delete', $weightLog);
        
        $weightLog->delete();

        return redirect()->route('weight.index')
            ->with('success', 'Weight log deleted successfully.');
    }

    public function getChartData()
    {
        return response()->json(WeightLog::getWeightHistory(Auth::id()));
    }

    public function calorieCalculator()
    {
        return view('calories.calculator');
    }

    public function calculateCalories(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:20|max:500',
            'height' => 'required|numeric|min:100|max:250',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'activity_level' => 'required|in:sedentary,light,moderate,active,very_active'
        ]);

        // BMR calculation using Mifflin-St Jeor Equation
        if ($validated['gender'] === 'male') {
            $bmr = (10 * $validated['weight']) + (6.25 * $validated['height']) - (5 * $validated['age']) + 5;
        } else {
            $bmr = (10 * $validated['weight']) + (6.25 * $validated['height']) - (5 * $validated['age']) - 161;
        }

        // Activity multipliers
        $multipliers = [
            'sedentary' => 1.2,      // Little or no exercise
            'light' => 1.375,        // Light exercise/sports 1-3 days/week
            'moderate' => 1.55,      // Moderate exercise/sports 3-5 days/week
            'active' => 1.725,       // Hard exercise/sports 6-7 days/week
            'very_active' => 1.9     // Very hard exercise/sports & physical job
        ];

        $tdee = $bmr * $multipliers[$validated['activity_level']];

        // Calculate macros (40% protein, 30% carbs, 30% fats)
        $macros = [
            'protein' => round(($tdee * 0.4) / 4), // 4 calories per gram
            'carbs' => round(($tdee * 0.3) / 4),
            'fats' => round(($tdee * 0.3) / 9) // 9 calories per gram
        ];

        return view('calories.result', [
            'bmr' => round($bmr),
            'tdee' => round($tdee),
            'weight_loss' => round($tdee - 500),
            'weight_gain' => round($tdee + 500),
            'macros' => $macros
        ]);
    }
}
