<?php

return [
    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],
        'public' => [
            'driver' => 'local',
            // Files land directly inside public/, not storage/app/public via a
            // symlink. Several hosts running this site block Apache from
            // following the public/storage symlink `storage:link` normally
            // creates (a 403 on every uploaded image, everything else on the
            // site unaffected) — a restriction a project-level .htaccess
            // can't always override. Writing straight into public/ sidesteps
            // that on any host, symlink-friendly or not.
            'root' => public_path('storage'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],
    ],

    // No symlink to create — the 'public' disk already points inside public/.
    // Running `storage:link` on this project is unnecessary; on older
    // deployments where one exists from before this change, remove it
    // (`rm public/storage`) and see docs/deployment.md for moving existing
    // uploads into the new location.
    'links' => [],
];
