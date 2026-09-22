<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'type',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    public const CACHE_KEY = 'site_settings';

    /** All settings as key => value, cached until one is edited. */
    public static function all_values(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::query()->pluck('value', 'key')->all());
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::all_values()[$key] ?? $default;
    }

    /**
     * URL for a setting that holds an image.
     *
     * Values arrive two ways: uploaded through the panel, which stores a path
     * on the public disk, or shipped with the site under public/ — the
     * placeholders do that, so they survive a deploy without needing an
     * upload. Resolving both here keeps the templates from caring which.
     */
    public static function imageUrl(string $key): ?string
    {
        $value = static::get($key);

        if (blank($value)) {
            return null;
        }

        if (str_contains($value, '://')) {
            return $value;
        }

        return is_file(public_path($value))
            ? asset($value)
            : Storage::disk('public')->url($value);
    }
}
