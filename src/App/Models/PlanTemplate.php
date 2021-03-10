<?php

namespace Asseco\PlanRouter\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function skillGroup(): BelongsTo
    {
        return $this->belongsTo(SkillGroup::class);
    }
}
