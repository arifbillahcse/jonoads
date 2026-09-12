<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Pages\ManageSiteSettings;
use App\Filament\Resources\CaseStudies\CaseStudyResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_panel_requires_a_login(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_an_editor_can_reach_content_but_not_settings_or_users(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $this->actingAs($editor);

        $this->assertTrue(CaseStudyResource::canAccess(), 'editors manage content');
        $this->assertFalse(ManageSiteSettings::canAccess(), 'editors must not change settings');
        $this->assertFalse(UserResource::canAccess(), 'editors must not manage users');
    }

    public function test_an_admin_can_reach_everything(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $this->actingAs($admin);

        $this->assertTrue(CaseStudyResource::canAccess());
        $this->assertTrue(ManageSiteSettings::canAccess());
        $this->assertTrue(UserResource::canAccess());
    }
}
