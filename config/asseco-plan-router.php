<?php

use Asseco\PlanRouter\App\Models\Match;
use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;

return [

    'match_model'            => Match::class,
    'plan_model'             => Plan::class,
    'plan_model_value_model' => PlanModelValue::class,

    /**
     * Should the package run the migrations. Set to false if you're publishing
     * and changing default migrations.
     */
    'runs_migrations'        => true,
];
