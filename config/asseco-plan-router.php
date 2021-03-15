<?php

use Illuminate\Support\Facades\Log;

return [

    /**
     * Should the package run the migrations. Set to false if you're publishing
     * and changing default migrations.
     */
    'runs_migrations' => true,

    'inbox_callback' => function (int $skillGroupId) {
        Log::info("Plan match found for skill group ID: $skillGroupId.");
    },

    'inbox_fallback' => function () {
        Log::info('Plan match not found. Triggering fallback...');
    },
];
