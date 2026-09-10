<?php

namespace App\Filament\Widgets;

use App\Models\CaseStudy;
use App\Models\Partner;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Surfaces the content gaps that are easy to forget about — placeholder
 * headshots, a thin testimonial section, anything left unpublished.
 */
class ContentHealth extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $missingPhotos = TeamMember::query()
            ->where('is_published', true)
            ->whereNull('photo_path')
            ->count();

        $testimonials = Testimonial::query()->where('is_published', true)->count();

        $unpublished = CaseStudy::query()->where('is_published', false)->count()
            + TeamMember::query()->where('is_published', false)->count()
            + Partner::query()->where('is_published', false)->count();

        return [
            Stat::make('Missing headshots', $missingPhotos)
                ->description($missingPhotos > 0 ? 'These cards show initials instead' : 'Every published member has a photo')
                ->descriptionIcon(Heroicon::Photo)
                ->color($missingPhotos > 0 ? 'warning' : 'success'),

            Stat::make('Live testimonials', $testimonials)
                ->description($testimonials < 3 ? 'Three or more fills the section properly' : 'Healthy')
                ->descriptionIcon(Heroicon::ChatBubbleLeftRight)
                ->color($testimonials < 3 ? 'warning' : 'success'),

            Stat::make('Hidden from the site', $unpublished)
                ->description('Case studies, team and partners set to unpublished')
                ->descriptionIcon(Heroicon::Star)
                ->color('gray'),
        ];
    }
}
