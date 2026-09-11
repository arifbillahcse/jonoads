<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SeoController extends Controller
{
    /** Every public page, in the order a reader would meet them. */
    private const PAGES = [
        'home' => ['priority' => '1.0', 'frequency' => 'weekly'],
        'roas-engine' => ['priority' => '0.9', 'frequency' => 'monthly'],
        'services' => ['priority' => '0.9', 'frequency' => 'monthly'],
        'work' => ['priority' => '0.8', 'frequency' => 'monthly'],
        'team' => ['priority' => '0.7', 'frequency' => 'monthly'],
        'smb' => ['priority' => '0.7', 'frequency' => 'monthly'],
        'contact' => ['priority' => '0.6', 'frequency' => 'yearly'],
    ];

    public function sitemap(): Response
    {
        $urls = collect(self::PAGES)
            ->filter(fn (array $meta, string $name) => Route::has($name))
            ->map(fn (array $meta, string $name) => [
                'loc' => route($name),
                'priority' => $meta['priority'],
                'frequency' => $meta['frequency'],
            ])
            ->values();

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            // The panel and the one-time newsletter links have nothing to index.
            'Disallow: /admin',
            'Disallow: /newsletter/',
            '',
            'Sitemap: ' . route('sitemap'),
        ];

        return response(implode("\n", $lines) . "\n")
            ->header('Content-Type', 'text/plain');
    }
}
