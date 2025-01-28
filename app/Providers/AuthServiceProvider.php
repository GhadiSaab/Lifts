<?php

namespace App\Providers;

use App\Models\Exercise;
use App\Models\WeightLog;
use App\Models\MealLog;
use App\Models\Lift;
use App\Policies\ExercisePolicy;
use App\Policies\WeightLogPolicy;
use App\Policies\MealLogPolicy;
use App\Policies\LiftPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Exercise::class => ExercisePolicy::class,
        WeightLog::class => WeightLogPolicy::class,
        MealLog::class => MealLogPolicy::class,
        Lift::class => LiftPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
