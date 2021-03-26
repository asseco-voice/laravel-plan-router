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
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/asseco-plan-router.php' => config_path('asseco-plan-router.php'),
        ], 'asseco-plan-router');

        $timestamp = now()->format('Y_m_d_His');

        $migrations = [];
        foreach (glob(__DIR__ . '/../stubs/Repository/*.stub') as $stub) {
            $stub = preg_replace('/\d\d_/', '', $stub);

            $migrations[] = [
                __DIR__ . '/../database/migrations' => database_path("migrations/{$timestamp}_{$stub}"),
            ];
        }

        $this->publishes($migrations, 'asseco-containers');
    }
}
