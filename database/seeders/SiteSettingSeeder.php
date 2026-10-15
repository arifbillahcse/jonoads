<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Several values ship blank on purpose. Podcast and merch point at
        // anchors that do not exist yet; logo_image waits on an asset from
        // the client, and the site falls back gracefully until it arrives —
        // the contact page for booking, the wordmark for the logo.
        // calendly_url is the client's real booking link, supplied directly.
        foreach ([
            [
                'key' => 'contact_email',
                'value' => 'info@jonoadvertising.com',
                'group' => 'contact',
                'label' => 'Contact email',
                'type' => 'email',
            ],
            [
                'key' => 'site_domain',
                'value' => 'jonoads.com',
                'group' => 'general',
                'label' => 'Display domain',
                'type' => 'text',
            ],
            [
                'key' => 'skool_url',
                'value' => 'https://www.skool.com',
                'group' => 'links',
                'label' => 'Skool community URL',
                'type' => 'url',
            ],
            [
                'key' => 'podcast_url',
                'value' => '',
                'group' => 'links',
                'label' => 'Podcast URL',
                'type' => 'url',
            ],
            [
                'key' => 'merch_url',
                'value' => '',
                'group' => 'links',
                'label' => 'Merch store URL',
                'type' => 'url',
            ],
            [
                'key' => 'calendly_url',
                'value' => 'https://calendly.com/d/d2mc-3p7-qjh/digital-ads-strategy-call-w-jono-ads',
                'group' => 'links',
                'label' => 'Calendly booking link',
                'type' => 'url',
            ],
            [
                'key' => 'hero_image',
                'value' => 'placeholders/hero-miami-night.jpg',
                'group' => 'general',
                'label' => 'Homepage hero image',
                'type' => 'text',
            ],
            [
                'key' => 'logo_image',
                'value' => 'placeholders/logo-cursive.webp',
                'group' => 'general',
                'label' => 'Logo image',
                'type' => 'text',
            ],
            [
                'key' => 'share_image',
                'value' => '',
                'group' => 'general',
                'label' => 'Social share image',
                'type' => 'text',
            ],
            [
                'key' => 'footer_note',
                'value' => 'Jono Advertising. All rights reserved.',
                'group' => 'general',
                'label' => 'Footer copyright line',
                'type' => 'text',
            ],
            [
                'key' => 'tracking_head_code',
                'value' => <<<'HTML'
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async=true;j.src="https://load.sst.jonoadvertising.com/5canubtjb.js?"+i;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','2sg=Cw5JJSEjTDNVWC4vTSYvRRRXRkxESAUNXwAbDBoPBRUHGAALBgcPBEwJGw8%3D');</script>
                <!-- End Google Tag Manager -->
                HTML,
                'group' => 'advanced',
                'label' => 'Tracking code (head)',
                'type' => 'textarea',
            ],
            [
                'key' => 'tracking_body_code',
                'value' => <<<'HTML'
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://load.sst.jonoadvertising.com/ns.html?id=GTM-P72ZM8HN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
                HTML,
                'group' => 'advanced',
                'label' => 'Tracking code (body)',
                'type' => 'textarea',
            ],
        ] as $row) {
            SiteSetting::updateOrCreate(['key' => $row['key']], $row);
        }
    }
}
