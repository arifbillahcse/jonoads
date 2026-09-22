<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CaseStudy extends Model
{
    use FlushesSiteContentCache, HasFactory, Publishable, SoftDeletes;

    protected $fillable = [
        'client',
        'slug',
        'summary',
        'detail',
        'video_url',
        'is_featured',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (CaseStudy $caseStudy) {
            if (blank($caseStudy->slug)) {
                $caseStudy->slug = Str::slug($caseStudy->client);
            }
        });
    }

    public function stats(): HasMany
    {
        return $this->hasMany(CaseStudyStat::class)->orderBy('sort_order');
    }

    /** Detail copy is stored newline-separated and rendered as paragraphs. */
    public function detailParagraphs(): array
    {
        $parts = preg_split('/\n+/', (string) $this->detail) ?: [];

        return array_values(array_filter(array_map('trim', $parts), 'strlen'));
    }

    /** The standout result, used for the featured heading and chart. */
    public function headlineStat(): ?CaseStudyStat
    {
        return $this->stats->firstWhere('is_headline', true) ?? $this->stats->last();
    }

    /**
     * The YouTube id from whatever link was pasted — watch page, youtu.be
     * share link, or an embed URL, with or without extra query parameters.
     * Returns null for anything that isn't recognisably a YouTube link, so a
     * stray paste never reaches the page as an embed.
     */
    public function youtubeId(): ?string
    {
        $url = trim((string) $this->video_url);

        if ($url === '') {
            return null;
        }

        $patterns = [
            '~youtu\.be/([A-Za-z0-9_-]{11})~',
            '~youtube\.com/watch\?(?:.*&)?v=([A-Za-z0-9_-]{11})~',
            '~youtube(?:-nocookie)?\.com/(?:embed|v|shorts|live)/([A-Za-z0-9_-]{11})~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /** Built from the id rather than the pasted URL, so only YouTube loads. */
    public function videoEmbedUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id ? "https://www.youtube-nocookie.com/embed/{$id}" : null;
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
