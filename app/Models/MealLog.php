<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealLog extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'meal_type',
        'description',
        'calories',
        'protein',
        'carbs',
        'fat'
    ];

    protected $casts = [
        'date' => 'date',
        'calories' => 'integer',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDailySummary($userId, $date)
    {
        $meals = self::where('user_id', $userId)
            ->whereDate('date', $date)
            ->get();

        return [
            'total_calories' => $meals->sum('calories'),
            'total_protein' => $meals->sum('protein'),
            'total_carbs' => $meals->sum('carbs'),
            'total_fat' => $meals->sum('fat'),
            'meals' => $meals
        ];
    }
}
