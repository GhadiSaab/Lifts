<?php

namespace App\Policies;

use App\Models\WeightLog;
use App\Models\User;

class WeightLogPolicy
{
    public function view(User $user, WeightLog $weightLog)
    {
        return $user->id === $weightLog->user_id;
    }

    public function update(User $user, WeightLog $weightLog)
    {
        return $user->id === $weightLog->user_id;
    }

    public function delete(User $user, WeightLog $weightLog)
    {
        return $user->id === $weightLog->user_id;
    }
}
