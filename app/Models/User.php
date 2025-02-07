<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function lifts()
    {
        return $this->hasMany(Lift::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function weightLogs()
    {
        return $this->hasMany(WeightLog::class);
    }

    public function mealLogs()
    {
        return $this->hasMany(MealLog::class);
    }

    public function calculateStreak()
    {
        $streak = 0;
        $currentDate = now()->startOfDay();
        $lastWorkoutDate = null;

        // Get all exercise dates in descending order
        $workoutDates = $this->exercises()
            ->selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderByDesc('date')
            ->get()
            ->map(function ($item) {
                return \Carbon\Carbon::parse($item->date)->startOfDay();
            });

        if ($workoutDates->isEmpty()) {
            return 0;
        }

        // If last workout was not today or yesterday, streak is 0
        $lastWorkout = $workoutDates->first();
        if ($currentDate->diffInDays($lastWorkout) > 1) {
            return 0;
        }

        // Calculate streak by counting consecutive days
        foreach ($workoutDates as $date) {
            if (!$lastWorkoutDate) {
                $lastWorkoutDate = $date;
                $streak = 1;
                continue;
            }

            // If there's a gap larger than 1 day, break the streak
            if ($lastWorkoutDate->diffInDays($date) > 1) {
                break;
            }

            $streak++;
            $lastWorkoutDate = $date;
        }

        return $streak;
    }
}
