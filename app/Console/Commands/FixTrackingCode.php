<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the tracking_head_code
 * and tracking_body_code settings existed. Installs the client's Google
 * Tag Manager (via a Stape server-side tagging domain) snippets. Safe to
 * run more than once.
 */
class FixTrackingCode extends Command
{
    protected $signature = 'fix:tracking-code';

    protected $description = 'Install the GTM head/body tracking snippets into site settings';

    public function handle(): void
    {
        SiteSetting::updateOrCreate(
            ['key' => 'tracking_head_code'],
            [
                'value' => <<<'HTML'
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async=true;j.src="https://load.sst.jonoadvertising.com/5canubtjb.js?"+i;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','2sg=Cw5JJSEjTDNVWC4vTSYvRRRXRkxESAUNXwAbDBoPBRUHGAALBgcPBEwJGw8%3D');</script>
                <!-- End Google Tag Manager -->
                HTML,
                'group' => 'advanced',
                'label' => 'Tracking code (head)',
                'type' => 'textarea',
            ],
        );

        SiteSetting::updateOrCreate(
            ['key' => 'tracking_body_code'],
            [
                'value' => <<<'HTML'
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://load.sst.jonoadvertising.com/ns.html?id=GTM-P72ZM8HN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
                HTML,
                'group' => 'advanced',
                'label' => 'Tracking code (body)',
                'type' => 'textarea',
            ],
        );

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info('Tracking code installed.');
    }
}
