<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseSet extends Model
{
    protected $fillable = [
        'exercise_progress_id',
        'weight',
        'reps',
        'rest_time',
        'set_number'
    ];

    public function progress()
    {
        return $this->belongsTo(ExerciseProgress::class, 'exercise_progress_id');
    }
}
