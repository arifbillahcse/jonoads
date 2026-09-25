<?php

namespace App\Support;

/**
 * The site's version number, bumped by hand in the VERSION file at the
 * project root — not a site_settings row, since it describes this codebase's
 * release, not editable content.
 *
 * A plain file rather than an .env value on purpose: env() outside a config
 * file returns null once `php artisan optimize`/config:cache has run, which
 * would make the version silently vanish after every production deploy.
 */
class AppVersion
{
    public static function current(): string
    {
        $path = base_path('VERSION');

        if (! is_file($path)) {
            return '0.0.0';
        }

        $version = trim((string) file_get_contents($path));

        return $version !== '' ? $version : '0.0.0';
    }
}
