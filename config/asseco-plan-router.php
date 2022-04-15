<?php

use Asseco\BlueprintAudit\App\MigrationMethodPicker;
use Asseco\PlanRouter\App\Events\PlanCreated;
use Asseco\PlanRouter\App\Events\PlanDeleted;
use Asseco\PlanRouter\App\Events\PlanUpdated;
use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;
use Asseco\PlanRouter\App\Models\Rule;

return [

    /**
     * Model bindings.
     */
    'models' => [
        'rule'             => Rule::class,
        'plan'             => Plan::class,
        'plan_model_value' => PlanModelValue::class,
    ],

    'events' => [
        'plan_created' => PlanCreated::class,
        'plan_updated' => PlanUpdated::class,
        'plan_deleted' => PlanDeleted::class,
    ],

    'migrations' => [

        /**
         * UUIDs as primary keys.
         */
        'uuid'       => false,

        /**
         * Timestamp types.
         *
         * @see https://github.com/asseco-voice/laravel-common/blob/master/config/asseco-common.php
         */
        'timestamps' => MigrationMethodPicker::PLAIN,

        /**
         * Should the package run the migrations. Set to false if you're publishing
         * and changing default migrations.
         */
        'run'        => true,
    ],

    'plan_event_topic' => env('PLAN_EVENT_TOPIC', 'plan_changed')
];
