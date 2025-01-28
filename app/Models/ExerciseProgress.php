<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseProgress extends Model
{
    protected $fillable = ['exercise_id', 'date', 'weight', 'reps', 'notes'];

    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:2',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
