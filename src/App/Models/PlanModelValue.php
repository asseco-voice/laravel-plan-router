<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\Database\Factories\PlanModelValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PlanModelValue extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'attribute', 'value'];

    protected static function newFactory()
    {
        return PlanModelValueFactory::new();
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(config('asseco-plan-router.plan_model'));
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
