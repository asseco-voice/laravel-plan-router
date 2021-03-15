<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'order', 'match_either', 'template_id', 'skill_group_id'];

    protected static function newFactory()
    {
        return PlanFactory::new();
    }

    public function matches(): BelongsToMany
    {
        return $this->belongsToMany(Match::class)
            ->withPivot('regex')
            ->withTimestamps();
    }

    public function planTemplate(): BelongsTo
    {
        return $this->belongsTo(PlanTemplate::class);
    }

    public function skillGroup(): BelongsTo
    {
        return $this->belongsTo(SkillGroup::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(PlanModelValue::class);
    }

    public static function getWithRelations(): self
    {
        return self::load(['matches', 'skillGroup']);
    }
}
