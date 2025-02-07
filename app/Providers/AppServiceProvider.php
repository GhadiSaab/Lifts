<?php

namespace App\Providers;

use App\Helpers\MuscleGroupHelper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register muscle group directives
        Blade::directive('muscleGroupColor', function ($expression) {
            return "<?php echo \App\Helpers\MuscleGroupHelper::getColor($expression); ?>";
        });

        Blade::directive('muscleGroupIcon', function ($expression) {
            return "<?php echo \App\Helpers\MuscleGroupHelper::getIcon($expression); ?>";
        });
    }
}
