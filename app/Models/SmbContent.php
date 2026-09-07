<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Single-row content for the SMB landing page. The industry list lives in its
 * own table so it can be reordered independently.
 */
class SmbContent extends Model
{
    protected $fillable = [
        'eyebrow',
        'headline',
        'intro',
        'industries_heading',
        'approach_heading',
        'cta_heading',
        'cta_body',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
