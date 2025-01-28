<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    protected $fillable = ['user_id', 'date', 'weight', 'notes'];

    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getWeightHistory($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($log) {
                return [
                    'date' => $log->date->format('Y-m-d'),
                    'weight' => $log->weight,
                ];
            });
    }
}
