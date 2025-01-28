<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = ['user_id', 'name', 'notes'];

    public function progress()
    {
        return $this->hasMany(ExerciseProgress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
