<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Contracts\PlanModelValue;
use Asseco\PlanRouter\App\Contracts\Rule;
use Asseco\PlanRouter\Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Plan extends Model implements \Asseco\PlanRouter\App\Contracts\Plan
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'order', 'match_either', 'priority'];

    protected $casts = [
        'match_either' => 'boolean',
    ];

    protected static function newFactory()
    {
        return PlanFactory::new();
    }

    protected static function booted()
    {
        static::created(function (self $plan) {
            config('asseco-plan-router.events.plan_created')::dispatch($plan);
        });

        static::updated(function (self $plan) {
            config('asseco-plan-router.events.plan_updated')::dispatch($plan);
        });

        static::deleted(function (self $plan) {
            config('asseco-plan-router.events.plan_deleted')::dispatch($plan->id);
        });
    }

    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(app(Rule::class))
            ->using(app(PlanRule::class))
            ->withPivot('regex')
            ->withTimestamps();
    }

    public function values(): HasMany
    {
        return $this->hasMany(app(PlanModelValue::class));
    }

    public static function getWithRelations(): Collection
    {
        return self::with(['rules'])->get();
    }

    public static function getValidationRules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'priority' => 'integer',
            'match_either' => 'boolean',
        ];
    }
}
