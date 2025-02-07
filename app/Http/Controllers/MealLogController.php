<?php

namespace App\Http\Controllers;

use App\Models\MealLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MealLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $date = request('date', now()->format('Y-m-d'));
        
        $summary = MealLog::getDailySummary(Auth::id(), $date);
        
        $meals = $summary['meals']->groupBy('meal_type');

        return view('meals.index', compact('meals', 'summary', 'date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'description' => 'required|string|max:255',
            'calories' => 'required|integer|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = Auth::id();

        MealLog::create($validated);

        return redirect()->route('meals.index', ['date' => $validated['date']])
            ->with('success', 'Meal logged successfully.');
    }

    public function destroy(MealLog $mealLog)
    {
        $this->authorize('delete', $mealLog);
        
        $date = $mealLog->date;
        $mealLog->delete();

        return redirect()->route('meals.index', ['date' => $date])
            ->with('success', 'Meal log deleted successfully.');
    }

    public function history()
    {
        $startDate = request('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = request('end_date', now()->format('Y-m-d'));

        $dailySummaries = MealLog::where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(date) as date'),
                DB::raw('SUM(calories) as total_calories'),
                DB::raw('SUM(protein) as total_protein'),
                DB::raw('SUM(carbs) as total_carbs'),
                DB::raw('SUM(fat) as total_fat')
            )
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date', 'desc')
            ->get()
            ->keyBy('date')
            ->map(function($log) {
                return [
                    'total_calories' => $log->total_calories,
                    'total_protein' => $log->total_protein,
                    'total_carbs' => $log->total_carbs,
                    'total_fat' => $log->total_fat,
                ];
            });

        return view('meals.history', compact('dailySummaries', 'startDate', 'endDate'));
    }
}
