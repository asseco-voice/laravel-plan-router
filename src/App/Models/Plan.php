<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'order', 'match_either'];

    protected static function newFactory()
    {
        return PlanFactory::new();
    }

    public function matches(): BelongsToMany
    {
        return $this->belongsToMany(config('asseco-plan-router.match_model'))
            ->withPivot('regex')
            ->withTimestamps();
    }

    public function values(): HasMany
    {
        return $this->hasMany(config('asseco-plan-router.plan_model_value_model'));
    }

    public static function getWithRelations(): Collection
    {
        return self::with(['matches'])->get();
    }
}
