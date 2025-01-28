<?php

namespace App\Policies;

use App\Models\Lift;
use App\Models\User;

class LiftPolicy
{
    public function view(User $user, Lift $lift)
    {
        return $user->id === $lift->user_id;
    }

    public function update(User $user, Lift $lift)
    {
        return $user->id === $lift->user_id;
    }

    public function delete(User $user, Lift $lift)
    {
        return $user->id === $lift->user_id;
    }
}
