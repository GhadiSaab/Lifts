<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiftController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\MealLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Landing/Home page routes
Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('home');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Calorie Calculator Routes
    Route::get('/calories', [WeightLogController::class, 'calorieCalculator'])->name('calories.calculator');
    Route::post('/calories/calculate', [WeightLogController::class, 'calculateCalories'])->name('calories.calculate');

    // Exercise Routes
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');
    Route::post('/exercises/{exercise}/progress', [ExerciseController::class, 'addProgress'])->name('exercises.progress.store');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');

    // Weight Tracking Routes
    Route::get('/weight', [WeightLogController::class, 'index'])->name('weight.index');
    Route::post('/weight', [WeightLogController::class, 'store'])->name('weight.store');
    Route::delete('/weight/{weightLog}', [WeightLogController::class, 'destroy'])->name('weight.destroy');
    Route::get('/weight/chart-data', [WeightLogController::class, 'getChartData'])->name('weight.chart-data');

    // Meal Logging Routes
    Route::get('/meals', [MealLogController::class, 'index'])->name('meals.index');
    Route::post('/meals', [MealLogController::class, 'store'])->name('meals.store');
    Route::delete('/meals/{mealLog}', [MealLogController::class, 'destroy'])->name('meals.destroy');
    Route::get('/meals/history', [MealLogController::class, 'history'])->name('meals.history');

    // Lift Routes
    Route::get('/lifts', [LiftController::class, 'index'])->name('lifts.index');
    Route::get('/lifts/create', [LiftController::class, 'create'])->name('lifts.create');
    Route::post('/lifts', [LiftController::class, 'store'])->name('lifts.store');
    Route::get('/lifts/{lift}/edit', [LiftController::class, 'edit'])->name('lifts.edit');
    Route::put('/lifts/{lift}', [LiftController::class, 'update'])->name('lifts.update');
    Route::delete('/lifts/{lift}', [LiftController::class, 'destroy'])->name('lifts.destroy');
});
