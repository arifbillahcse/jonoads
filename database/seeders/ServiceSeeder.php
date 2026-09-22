<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Client feedback round 1: CMO Advisory moved to slot 02 and Creative
     * Services to 03, and every summary was rewritten. The `summary` is what
     * the homepage list renders; `detail` and `features` belong to the
     * services page and were left as they were.
     */
    public function run(): void
    {
        foreach ([
            [
                'number' => '01',
                'title' => 'Digital Advertising',
                'summary' => 'Media planning, optimization and attribution across Meta, Google, TikTok, X, CTV, podcasts, Reddit, etc. Executed by pros who\'ve managed 9-figures in ad spend.',
                'detail' => 'Media planning, optimization, and attribution run by buyers who\'ve managed nine figures in spend.',
                'features' => [
                    'Meta, Google, TikTok, X, Reddit',
                    'CTV, podcasts, and Pinterest',
                    'Daily bid and budget management',
                    'Cross-channel attribution',
                ],
            ],
            [
                'number' => '02',
                'title' => 'CMO Advisory',
                'summary' => 'Go-to-market plans (GTM), organizational alignment and leadership, omni-channel and full-funnel customer acquisition strategy. Best practices used over 200 times to future-proof growth programs at billion-dollar brands.',
                'detail' => 'The full-funnel best practices we\'ve used to future-proof media programs at billion-dollar brands.',
                'features' => [
                    'Business alignment',
                    'Competitive intelligence',
                    'Operational improvements',
                    'Full-funnel strategy',
                ],
            ],
            [
                'number' => '03',
                'title' => 'Creative Services',
                'summary' => 'High-caliber creative to fuel consistent growth. Integrate with client internal teams or utilize ours. Brief writing, concepting, project management and optimization pipeline.',
                'detail' => 'Concept to production, integrated directly with your internal team.',
                'features' => [
                    'Creative brief and concepting',
                    'Asset production',
                    'Direct integration with your team',
                    'Performance data feeds the next round',
                ],
            ],
            [
                'number' => '04',
                'title' => 'CRM Strategy',
                'summary' => 'Email and SMS optimization, database monetization, customer journey planning.',
                'detail' => 'Email, SMS, and lifecycle work — plus the creative production to actually ship the campaigns.',
                'features' => [
                    'Email and SMS optimization',
                    'Database monetization',
                    'Customer journey mapping',
                    'Campaign creative production',
                ],
            ],
        ] as $i => $row) {
            $features = $row['features'];
            unset($row['features']);

            $service = Service::create($row + ['sort_order' => $i + 1]);

            foreach ($features as $j => $text) {
                $service->features()->create(['text' => $text, 'sort_order' => $j + 1]);
            }
        }
    }
}
