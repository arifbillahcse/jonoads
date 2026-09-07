<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Podcast and merch URLs are intentionally blank: both footer links
        // point at anchors that do not exist yet and depend on add-ons that
        // are not in the core scope.
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
