<?php

namespace Asseco\PlanRouter\App\Traits;

use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

trait HasPlanValues
{
    /**
     * Modify model attributes based on plan values from DB.
     *
     * @param Plan|null $plan
     */
    public function applyPlanValues(?Plan $plan = null): void
    {
        $values = optional($plan)->values ?: [];
        $className = get_class($this);

        /** @var PlanModelValue $value */
        foreach ($values as $value) {
            if (method_exists($this, $value->attribute)) {
                $this->updateRelation($value, $className);
                continue;
            }

            $this->updateAttribute($value, $className);
        }
    }

    /**
     * If there is no method with that name on a model instance, we are assuming it is
     * a model attribute.
     *
     * @param PlanModelValue $value
     * @param bool $className
     */
    protected function updateAttribute(PlanModelValue $value, bool $className): void
    {
        try {
            /** @var Model $this */
            $this->update([$value->attribute => $value->value]);
        } catch (Exception $e) {
            Log::info("'{$value->attribute}' is not an attribute on {$className} instance.");
        }
    }

    /**
     * If method exists on this model instance, we are assuming it is a relation.
     *
     * @param PlanModelValue $value
     * @param bool $className
     */
    protected function updateRelation(PlanModelValue $value, bool $className): void
    {
        /** @var Model $this */
        $relation = $this->{$value->attribute}();

        if ($relation instanceof BelongsTo) {
            $key = $relation->getForeignKeyName();

            $this->update([
                $key => $value->value,
            ]);
        }

        if ($relation instanceof BelongsToMany) {
            $relation->attach($value->value);
        }

        Log::info("'{$value->attribute}' is a method on {$className} instance, but is not a relation.");
    }
}
