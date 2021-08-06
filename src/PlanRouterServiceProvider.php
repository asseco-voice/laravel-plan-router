<?php

declare(strict_types=1);

namespace Asseco\PlanRouter;

use Asseco\PlanRouter\App\Contracts\Match;
use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\App\Contracts\PlanModelValue;
use Asseco\PlanRouter\App\Models\Decorators\Uuid;
use Asseco\PlanRouter\App\Services\InboxService;
use Exception;
use Illuminate\Support\ServiceProvider;

class PlanRouterServiceProvider extends ServiceProvider
{
    protected array $contracts = [
        Match::class,
        Plan::class,
        PlanModelValue::class,
    ];

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/asseco-plan-router.php', 'asseco-plan-router');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if (config('asseco-plan-router.runs_migrations')) {
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
        $this->decorateUuid();

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

    protected function decorateUuid()
    {
        if (!config('asseco-plan-router.uuid')) {
            return;
        }

        foreach ($this->contracts as $contract) {
            $this->app->extend($contract, function ($model, $app) {
                return new Uuid($model);
            });
        }
    }

    /**
     * @throws Exception
     */
    protected function decorateAudit()
    {
        $audit = config('asseco-plan-router.audit');

        if (!$audit) {
            return;
        }

        $decorator = config('asseco-plan-router.audit_decorators')[$audit];

        if (!$decorator) {
            throw new Exception("Decorator $audit must be defined.");
        }

        foreach ($this->contracts as $contract) {
            $this->app->extend($contract, function ($model, $app) use ($decorator) {
                return new $decorator($model);
            });
        }
    }
}
