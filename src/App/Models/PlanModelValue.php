<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\Database\Factories\PlanModelValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PlanModelValue extends Model implements \Asseco\PlanRouter\App\Contracts\PlanModelValue
{
    use HasFactory;

    protected $fillable = ['plan_id', 'attribute', 'value'];

    protected static function newFactory()
    {
        return PlanModelValueFactory::new();
    }

    protected static function booted()
    {
        static::created(function (self $planModelValue) {
            config('asseco-plan-router.events.plan_updated')::dispatch($planModelValue->plan);
        });

        static::updated(function (self $planModelValue) {
            config('asseco-plan-router.events.plan_updated')::dispatch($planModelValue->plan);
        });

        static::deleted(function (self $planModelValue) {
            config('asseco-plan-router.events.plan_updated')::dispatch($planModelValue->plan);
        });
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(app(Plan::class));
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public static function getValidationRules(): array
    {
        return [
            'plan_id'   => 'required|exists:plans,id',
            'attribute' => 'required|string',
            'value'     => 'required|string',
        ];
    }
}
