<?php

declare(strict_types=1);

namespace Asseco\PlanRouter;

use Illuminate\Support\ServiceProvider;

class PlanRouterServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/asseco-plan-router.php', 'asseco-plan-router');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/asseco-plan-router.php' => config_path('asseco-plan-router.php'),
        ], 'asseco-plan-router');
    }
}
