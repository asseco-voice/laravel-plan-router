<?php

declare(strict_types=1);

namespace Asseco\PlanRouter;

use Asseco\PlanRouter\App\Services\InboxService;
use Illuminate\Support\ServiceProvider;

class PlanRouterServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        app()->singleton('inbox-service', InboxService::class);

        $migrations = [];
        $stubPath = __DIR__ . '/../stubs/';

        foreach (glob($stubPath . '*.stub') as $stub) {
            $migration = preg_replace('/\d\d_/', '', $stub);
            $migration = str_replace([$stubPath, '.stub'], '', $migration);

            $timestamp = now()->format('Y_m_d_Hisu');

            $migrations = array_merge($migrations, [
                $stub => database_path("migrations/{$timestamp}_{$migration}"),
            ]);
        }

        $this->publishes($migrations, 'asseco-plan-router');
    }
}
