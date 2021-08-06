<?php

return [

    /**
     * Should primary keys be UUIDs.
     */
    'uuid'                   => false,

    /**
     * Models defined here take precedence over package models, so be
     * sure to align them correctly if using UUIDs or standard IDs.
     */
    'match_model'            => null, // Match::class,
    'plan_model'             => null, // Plan::class,
    'plan_model_value_model' => null, // PlanModelValue::class,

    /**
     * Should the package run the migrations. Set to false if you're publishing
     * and changing default migrations.
     */
    'runs_migrations'        => true,
];
