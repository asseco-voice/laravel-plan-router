<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Contracts\Plan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanRule extends Pivot
{
    protected static function booted()
    {
        static::created(function (self $planRule) {
            config('asseco-plan-router.events.plan_updated')::dispatch($planRule->plan);
        });

        static::updated(function (self $planRule) {
            config('asseco-plan-router.events.plan_updated')::dispatch($planRule->plan);
        });

        static::deleted(function (self $planRule) {
            config('asseco-plan-router.events.plan_updated')::dispatch($planRule->plan);
        });
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(app(Plan::class));
    }
}
