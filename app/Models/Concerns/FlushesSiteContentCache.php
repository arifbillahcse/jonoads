<?php

namespace App\Models\Concerns;

use App\Support\SiteContent;

/**
 * Content is cached indefinitely for the public site, so every model that feeds
 * a page clears that cache when an editor saves, deletes or restores a record.
 */
trait FlushesSiteContentCache
{
    public static function bootFlushesSiteContentCache(): void
    {
        $flush = fn () => SiteContent::flush();

        static::saved($flush);
        static::deleted($flush);

        if (method_exists(static::class, 'restored')) {
            static::restored($flush);
        }
    }
}
