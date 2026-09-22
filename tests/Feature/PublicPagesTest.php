<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\Stat;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public static function pageProvider(): array
    {
        return [
            'home' => ['home'],
            'roas engine' => ['roas-engine'],
            'services' => ['services'],
            'case studies' => ['case-studies'],
            'team' => ['team'],
            'contact' => ['contact'],
            'smb' => ['smb'],
        ];
    }

    /** @dataProvider pageProvider */
    public function test_every_public_page_renders(string $route): void
    {
        $this->seed();

        $this->get(route($route))
            ->assertOk()
            ->assertSee('</html>', false);
    }

    /** @dataProvider pageProvider */
    public function test_every_page_carries_seo_metadata(string $route): void
    {
        $this->seed();

        $response = $this->get(route($route));

        $response->assertSee('rel="canonical"', false);
        $response->assertSee('property="og:title"', false);
        $response->assertSee('name="twitter:card"', false);
        $response->assertSee('application/ld+json', false);
    }

    public function test_a_page_renders_content_from_the_database(): void
    {
        $this->seed();

        CaseStudy::factory()->create(['client' => 'Verifiable Test Client']);

        $this->get(route('case-studies'))->assertSee('Verifiable Test Client');
    }

    public function test_unpublished_content_is_not_shown(): void
    {
        $this->seed();

        CaseStudy::factory()->unpublished()->create(['client' => 'Hidden Client']);
        TeamMember::factory()->create(['name' => 'Hidden Person', 'is_published' => false]);

        $this->get(route('case-studies'))->assertDontSee('Hidden Client');
        $this->get(route('team'))->assertDontSee('Hidden Person');
    }

    public function test_a_static_stat_is_printed_rather_than_animated(): void
    {
        $this->seed();

        Stat::factory()->static('24/7')->create([
            'group' => 'contact_hero',
            'label' => 'Access to your team',
        ]);

        $this->get(route('contact'))
            ->assertSee('stat-number-static', false)
            ->assertSee('24/7');
    }

    public function test_a_missing_page_returns_the_branded_404(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee("That page isn't here.", false);
    }

    public function test_the_skip_link_is_present_for_keyboard_users(): void
    {
        $this->seed();

        $this->get(route('home'))
            ->assertSee('skip-link', false)
            ->assertSee('Skip to content');
    }
}
