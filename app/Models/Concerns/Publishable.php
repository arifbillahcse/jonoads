<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Shared query scopes for content models that are ordered by hand in the
 * admin panel and can be hidden without being deleted.
 */
trait Publishable
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /** Published records in display order — what every front-end query wants. */
    public function scopeForDisplay(Builder $query): Builder
    {
        return $query->published()->ordered();
    }
}
