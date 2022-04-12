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

    protected $fillable = ['name', 'description', 'order', 'match_either'];

    protected static function newFactory()
    {
        return PlanFactory::new();
    }

    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(app(Rule::class))
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
}
