<?php

namespace App\Policies;

use App\Models\MealLog;
use App\Models\User;

class MealLogPolicy
{
    public function view(User $user, MealLog $mealLog)
    {
        return $user->id === $mealLog->user_id;
    }

    public function update(User $user, MealLog $mealLog)
    {
        return $user->id === $mealLog->user_id;
    }

    public function delete(User $user, MealLog $mealLog)
    {
        return $user->id === $mealLog->user_id;
    }
}
