<?php

namespace App\Helpers;

class MuscleGroupHelper
{
    public static function getColor(string $group): string
    {
        return match($group) {
            'Chest' => 'danger',
            'Back' => 'primary',
            'Legs' => 'success',
            'Shoulders' => 'secondary',
            'Triceps' => 'info',
            'Biceps' => 'warning',
            'Abs' => 'secondary',
            'Cardio' => 'dark',
            default => 'secondary'
        };
    }

    public static function getIcon(string $group): string
    {
        return match($group) {
            'Chest' => 'fa-dumbbell',
            'Back' => 'fa-arrows-up-down',
            'Legs' => 'fa-person-walking',
            'Shoulders' => 'fa-dumbbell',
            'Triceps' => 'fa-hand-fist',
            'Biceps' => 'fa-hand-back-fist',
            'Abs' => 'fa-circle',
            'Cardio' => 'fa-heart-pulse',
            default => 'fa-dumbbell'
        };
    }
}
