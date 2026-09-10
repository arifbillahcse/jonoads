<?php

namespace App\Filament\Widgets;

use App\Models\CaseStudy;
use App\Models\ContactLead;
use App\Models\NewsletterSubscriber;
use App\Models\TeamMember;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newLeads = ContactLead::query()->where('status', 'new')->count();
        $leadsThisWeek = ContactLead::query()->where('created_at', '>=', now()->subWeek())->count();
        $subscribers = NewsletterSubscriber::query()->where('status', 'confirmed')->count();
        $pending = NewsletterSubscriber::query()->where('status', 'pending')->count();

        return [
            Stat::make('Unhandled enquiries', $newLeads)
                ->description($leadsThisWeek . ' received in the last 7 days')
                ->descriptionIcon(Heroicon::Inbox)
                ->color($newLeads > 0 ? 'warning' : 'success'),

            Stat::make('Confirmed subscribers', $subscribers)
                ->description($pending . ' awaiting confirmation')
                ->descriptionIcon(Heroicon::Envelope)
                ->color('info'),

            Stat::make('Published case studies', CaseStudy::query()->where('is_published', true)->count())
                ->description(TeamMember::query()->where('is_published', true)->count() . ' team members published')
                ->descriptionIcon(Heroicon::Trophy)
                ->color('gray'),
        ];
    }
}
