<?php

declare(strict_types=1);

namespace Asseco\PlanRouter;

use Asseco\PlanRouter\App\Contracts\Match;
use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\App\Contracts\PlanModelValue;
use Asseco\PlanRouter\App\Models\Match as IdMatch;
use Asseco\PlanRouter\App\Models\Plan as IdPlan;
use Asseco\PlanRouter\App\Models\PlanModelValue as IdPlanModelValue;
use Asseco\PlanRouter\App\Models\Uuid\Match as UuidMatch;
use Asseco\PlanRouter\App\Models\Uuid\Plan as UuidPlan;
use Asseco\PlanRouter\App\Models\Uuid\PlanModelValue as UuidPlanModelValue;
use Asseco\PlanRouter\App\Services\InboxService;
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
        ], 'asseco-plan-router');

        $this->publishes([
            __DIR__ . '/../config/asseco-plan-router.php' => config_path('asseco-plan-router.php'),
        ], 'asseco-plan-router');

        $this->bindMatchModel();
        $this->bindPlanModel();
        $this->bindPlanModelValueModel();

        $this->app->singleton('inbox-service', function ($app) {
            $plan = $app->make(Plan::class);

            return new InboxService($plan);
        });
    }

    protected function bindMatchModel(): void
    {
        $model = config('asseco-plan-router.match_model');

        if (!$model) {
            if (config('asseco-plan-router.uuid')) {
                $model = UuidMatch::class;
            } else {
                $model = IdMatch::class;
            }
        }

        $this->app->bind(Match::class, $model);
    }

    protected function bindPlanModel(): void
    {
        $model = config('asseco-plan-router.plan_model');

        if (!$model) {
            if (config('asseco-plan-router.uuid')) {
                $model = UuidPlan::class;
            } else {
                $model = IdPlan::class;
            }
        }

        $this->app->bind(Plan::class, $model);
    }

    protected function bindPlanModelValueModel(): void
    {
        $model = config('asseco-plan-router.plan_model_value_model');

        if (!$model) {
            if (config('asseco-plan-router.uuid')) {
                $model = UuidPlanModelValue::class;
            } else {
                $model = IdPlanModelValue::class;
            }
        }

        $this->app->bind(PlanModelValue::class, $model);
    }
}
