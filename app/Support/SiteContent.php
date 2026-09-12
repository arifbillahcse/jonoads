<?php

namespace App\Support;

use App\Models\BrandLogo;
use App\Models\CaseStudy;
use App\Models\ComparisonCheck;
use App\Models\ComparisonMetric;
use App\Models\EngagementModel;
use App\Models\Industry;
use App\Models\Location;
use App\Models\Partner;
use App\Models\RoasStep;
use App\Models\SmbContent;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Every read the public site makes, cached. Content changes rarely and pages
 * are read constantly, so each query runs once until an editor saves something
 * — see the FlushesSiteContentCache trait on the models.
 */
class SiteContent
{
    /** Cache keys this class owns, cleared together whenever content changes. */
    public const KEYS = [
        'site.stats',
        'site.brand_logos',
        'site.services',
        'site.engagement_models',
        'site.roas_steps',
        'site.case_studies',
        'site.testimonials',
        'site.comparison_metrics',
        'site.comparison_checks',
        'site.team_members',
        'site.partners',
        'site.locations',
        'site.industries',
        'site.smb',
    ];

    public static function flush(): void
    {
        foreach (self::KEYS as $key) {
            Cache::forget($key);
        }
    }

    /** Stats keyed by group, so a page can pull one strip without another query. */
    public static function stats(string $group): Collection
    {
        $all = Cache::rememberForever(
            'site.stats',
            fn () => Stat::forDisplay()->get()->groupBy('group'),
        );

        return $all->get($group) ?? new Collection;
    }

    public static function brandLogos(): Collection
    {
        return Cache::rememberForever('site.brand_logos', fn () => BrandLogo::forDisplay()->get());
    }

    public static function services(): Collection
    {
        return Cache::rememberForever(
            'site.services',
            fn () => \App\Models\Service::forDisplay()->with('features')->get(),
        );
    }

    public static function engagementModels(): Collection
    {
        return Cache::rememberForever(
            'site.engagement_models',
            fn () => EngagementModel::forDisplay()->with('features')->get(),
        );
    }

    public static function roasSteps(): Collection
    {
        return Cache::rememberForever(
            'site.roas_steps',
            fn () => RoasStep::published()->with('features')->orderBy('number')->get(),
        );
    }

    public static function caseStudies(): Collection
    {
        return Cache::rememberForever(
            'site.case_studies',
            fn () => CaseStudy::forDisplay()->with('stats')->get(),
        );
    }

    public static function featuredCase(): ?CaseStudy
    {
        return self::caseStudies()->firstWhere('is_featured', true);
    }

    public static function testimonials(): Collection
    {
        return Cache::rememberForever('site.testimonials', fn () => Testimonial::forDisplay()->get());
    }

    public static function featuredTestimonial(): ?Testimonial
    {
        return self::testimonials()->firstWhere('is_featured', true) ?? self::testimonials()->first();
    }

    public static function comparisonMetrics(): Collection
    {
        return Cache::rememberForever('site.comparison_metrics', fn () => ComparisonMetric::forDisplay()->get());
    }

    public static function comparisonChecks(): Collection
    {
        return Cache::rememberForever('site.comparison_checks', fn () => ComparisonCheck::forDisplay()->get());
    }

    public static function teamMembers(): Collection
    {
        return Cache::rememberForever('site.team_members', fn () => TeamMember::forDisplay()->get());
    }

    public static function founder(): ?TeamMember
    {
        return self::teamMembers()->firstWhere('is_founder', true);
    }

    /** Everyone except the founder, who gets their own block. */
    public static function team(): Collection
    {
        return self::teamMembers()->where('is_founder', false)->values();
    }

    public static function partners(): Collection
    {
        return Cache::rememberForever('site.partners', fn () => Partner::forDisplay()->get());
    }

    public static function locations(): Collection
    {
        return Cache::rememberForever('site.locations', fn () => Location::forDisplay()->get());
    }

    public static function industries(): Collection
    {
        return Cache::rememberForever('site.industries', fn () => Industry::forDisplay()->get());
    }

    public static function smb(): ?SmbContent
    {
        return Cache::rememberForever('site.smb', fn () => SmbContent::query()->first());
    }
}
