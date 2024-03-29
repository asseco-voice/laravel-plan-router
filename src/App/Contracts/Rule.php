<?php

namespace Asseco\PlanRouter\App\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model|\Asseco\PlanRouter\App\Models\Rule
 */
interface Rule
{
    public static function getValidationRules(): array;
}
