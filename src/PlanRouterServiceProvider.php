<?php

declare(strict_types=1);

namespace Asseco\PlanRouter;

use Asseco\PlanRouter\App\Contracts\Match;
use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\App\Contracts\PlanModelValue;
use Asseco\PlanRouter\App\Services\InboxService;
use Illuminate\Support\Facades\Route;
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

        if (config('asseco-plan-router.migrations.run')) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        }
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'asseco-plan-router-migrations');

        $this->publishes([
            __DIR__ . '/../config/asseco-plan-router.php' => config_path('asseco-plan-router.php'),
        ], 'asseco-plan-router-config');

        $this->bindModels();

        $this->app->singleton('inbox-service', function ($app) {
            $plan = $app->make(Plan::class);

            return new InboxService($plan);
        });
    }

    protected function bindModels(): void
    {
        $this->app->bind(Match::class, config('asseco-plan-router.models.match'));
        $this->app->bind(Plan::class, config('asseco-plan-router.models.plan'));
        $this->app->bind(PlanModelValue::class, config('asseco-plan-router.models.plan_model_value'));
    }

    protected function routeModelBinding()
    {
        Route::model('match', get_class(app(Match::class)));
        Route::model('plan', get_class(app(Plan::class)));
        Route::model('plan_model_value', get_class(app(PlanModelValue::class)));
    }
}
