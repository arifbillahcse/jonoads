<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Several values ship blank on purpose. Podcast and merch point at
        // anchors that do not exist yet; calendly_url and logo_image wait on
        // assets from the client, and the site falls back gracefully until
        // each arrives — the contact page for booking, the wordmark for the
        // logo.
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
                'value' => '',
                'group' => 'links',
                'label' => 'Calendly booking link',
                'type' => 'url',
            ],
            [
                'key' => 'hero_image',
                'value' => 'placeholders/hero-placeholder.jpg',
                'group' => 'general',
                'label' => 'Homepage hero image',
                'type' => 'text',
            ],
            [
                'key' => 'logo_image',
                'value' => '',
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
        ] as $row) {
            SiteSetting::updateOrCreate(['key' => $row['key']], $row);
        }
    }
}
