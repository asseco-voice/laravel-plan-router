<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\Database\Factories\RuleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rule extends Model implements \Asseco\PlanRouter\App\Contracts\Rule
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function newFactory()
    {
        return RuleFactory::new();
    }

    protected static function booted()
    {
        static::creating(function (self $rule) {
            foreach ($rule->plans as $plan) {
                config('asseco-plan-router.events.plan_updated')::dispatch($plan);
            }
        });

        static::updated(function (self $rule) {
            foreach ($rule->plans as $plan) {
                config('asseco-plan-router.events.plan_updated')::dispatch($plan);
            }
        });

        static::deleted(function (self $rule) {
            foreach ($rule->plans as $plan) {
                config('asseco-plan-router.events.plan_updated')::dispatch($plan);
            }
        });
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(app(Plan::class));
    }
}
