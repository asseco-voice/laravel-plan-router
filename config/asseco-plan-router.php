<?php

use Asseco\PlanRouter\App\Models\Decorators\Audit;
use Asseco\PlanRouter\App\Models\Decorators\SoftDelete;
use Asseco\PlanRouter\App\Models\Decorators\SoftDeleteAudit;
use Asseco\PlanRouter\App\Models\Match;
use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;

return [

    /**
     * Should primary keys be UUIDs.
     */
    'uuid'  => false,

    /**
     * How will migrations remember data (be sure to provide appropriate traits
     * to models if using something other than default).
     * Possible values:
     *    null      => will call timestamps() method on migrations
     *    'soft'    => will call timestamps() & softDeletes()
     *    'partial' => will call audit() method instead
     *    'full'    => will call softDeleteAudit() method instead
     *
     * @see https://github.com/asseco-voice/laravel-blueprint-audit
     */
    'audit' => null,

    'audit_decorators' => [
        'soft'    => SoftDelete::class,
        'partial' => Audit::class,
        'full'    => SoftDeleteAudit::class,
    ],

    /**
     * Models defined here take precedence over package models, so be
     * sure to align them correctly if using UUIDs or standard IDs.
     */
    'models'           => [
        'match'            => Match::class,
        'plan'             => Plan::class,
        'plan_model_value' => PlanModelValue::class,
    ],

    /**
     * Should the package run the migrations. Set to false if you're publishing
     * and changing default migrations.
     */
    'runs_migrations'  => true,
];
