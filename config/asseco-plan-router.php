<?php

use Illuminate\Support\Facades\Log;

return [

    'inbox_callback' => function (int $skillGroupId) {
        Log::info("Plan match found for skill group ID: $skillGroupId.");
    },

    'inbox_fallback' => function () {
        Log::info('Plan match not found. Triggering fallback...');
    },
];
