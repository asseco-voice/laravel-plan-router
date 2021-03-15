<?php

namespace Asseco\PlanRouter\App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPlanValue
{
    public function models(): MorphMany
    {
        return $this->morphMany(self::class, 'models');
    }
}
