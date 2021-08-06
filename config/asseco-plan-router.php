<?php

use Asseco\PlanRouter\App\Models\Match;
use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;
use Asseco\PlanRouter\App\Models\Uuid;

return [

    /**
     * Should primary keys be UUIDs.
     */
    'uuid'   => false,

    /**
     * Models defined here take precedence over package models, so be
     * sure to align them correctly if using UUIDs or standard IDs.
     */
    'models' => [
        'match'            => Match::class,
        'plan'             => Plan::class,
        'plan_model_value' => PlanModelValue::class,
    ],

    /**
     * Decorator classes to be applied on all models
     */
    'decorators'      => [
        Uuid::class
    ],

    /**
     * Should the package run the migrations. Set to false if you're publishing
     * and changing default migrations.
     */
    'runs_migrations' => true,
];
