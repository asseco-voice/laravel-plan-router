<?php

namespace Asseco\PlanRouter\App\Traits;

use Asseco\PlanRouter\App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Skillable
{
    public function skillGroups(): MorphToMany
    {
        return $this->morphToMany(SkillGroup::class, 'skillable')
            ->withTimestamps();
    }
}
