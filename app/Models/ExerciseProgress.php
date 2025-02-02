<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseProgress extends Model
{
    protected $fillable = ['exercise_id', 'date', 'notes'];

    protected $casts = [
        'date' => 'date',
    ];

    public function sets()
    {
        return $this->hasMany(ExerciseSet::class);
    }

    public function firstSet()
    {
        return $this->hasOne(ExerciseSet::class)->where('set_number', 1);
    }

    public function getFirstSetWeightAttribute()
    {
        return $this->firstSet?->weight;
    }

    public function getFirstSetRepsAttribute()
    {
        return $this->firstSet?->reps;
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
