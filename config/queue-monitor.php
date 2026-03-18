<?php

declare(strict_types=1);

return [
    'path' => 'queue-monitor',

    // Add 'auth' or custom middleware in consuming apps for protection.
    'middleware' => ['web'],

    // Retain job history for this many days.
    'retention_days' => 14,

    // Dashboard refresh interval.
    'ui' => [
        'refresh_seconds' => 10,

        // Force HTTPS for all API endpoints (recommended for production)
        'force_https' => env('QUEUE_MONITOR_FORCE_HTTPS', false),

        // CDN configuration - use HTTPS URLs to prevent mixed-content errors
        'cdn' => [
            'tailwind' => 'https://cdn.tailwindcss.com',
            'vue' => 'https://unpkg.com/vue@3/dist/vue.global.js',
            'axios' => 'https://unpkg.com/axios/dist/axios.min.js',
        ],
    ],

    // Default release delay when a queue is paused or throttled.
    'control' => [
        'pause_release_seconds' => 10,
        'throttle_default_rate_per_minute' => 60,
        'throttle_release_seconds' => 5,
    ],
];

