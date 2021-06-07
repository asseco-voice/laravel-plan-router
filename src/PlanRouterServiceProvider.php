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

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        app()->singleton('inbox-service', InboxService::class);
    }
}
