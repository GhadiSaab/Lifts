<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = ['user_id', 'name', 'notes', 'muscle_group'];

    const MUSCLE_GROUP_CHEST = 'Chest';
    const MUSCLE_GROUP_BACK = 'Back';
    const MUSCLE_GROUP_LEGS = 'Legs';
    const MUSCLE_GROUP_SHOULDERS = 'Shoulders';
    const MUSCLE_GROUP_TRICEPS = 'Triceps';
    const MUSCLE_GROUP_BICEPS = 'Biceps';
    const MUSCLE_GROUP_ABS = 'Abs';
    const MUSCLE_GROUP_CARDIO = 'Cardio';

    public static function getMuscleGroups()
    {
        return [
            self::MUSCLE_GROUP_CHEST,
            self::MUSCLE_GROUP_BACK,
            self::MUSCLE_GROUP_LEGS,
            self::MUSCLE_GROUP_SHOULDERS,
            self::MUSCLE_GROUP_TRICEPS,
            self::MUSCLE_GROUP_BICEPS,
            self::MUSCLE_GROUP_ABS,
            self::MUSCLE_GROUP_CARDIO,
        ];
    }

    public function progress()
    {
        return $this->hasMany(ExerciseProgress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
