<?php

return [
    'paths' => [
        resource_path('views'),
    ],
    // No realpath() wrapper: it silently returns false (not an error) when
    // the directory doesn't exist yet, which it won't right after a fresh
    // deploy if storage/framework/views didn't survive the file transfer -
    // zip tools and some upload flows drop empty directories (this one is
    // only kept in git via a .gitignore placeholder). A bare, unresolved
    // path still lets the framework create the directory and compile into
    // it, instead of writing into a bogus path built from `false` and
    // failing with a cryptic tempnam() error.
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),
];
