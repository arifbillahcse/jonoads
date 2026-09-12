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

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
