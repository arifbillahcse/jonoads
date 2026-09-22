<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_sitemap_lists_every_public_page(): void
    {
        $response = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml');

        foreach (['home', 'roas-engine', 'services', 'case-studies', 'team', 'smb', 'contact'] as $name) {
            $response->assertSee(route($name), false);
        }
    }

    public function test_the_sitemap_is_well_formed_xml(): void
    {
        $xml = simplexml_load_string($this->get('/sitemap.xml')->getContent());

        $this->assertNotFalse($xml, 'the sitemap should parse as XML');
        $this->assertCount(7, $xml->url);
    }

    public function test_robots_points_at_the_sitemap_and_hides_the_panel(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee(route('sitemap'), false);
    }

    public function test_security_headers_are_applied(): void
    {
        $this->seed();

        $this->get(route('home'))
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
