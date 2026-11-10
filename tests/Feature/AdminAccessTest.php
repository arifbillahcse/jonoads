<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Pages\ManageSiteSettings;
use App\Filament\Resources\CaseStudies\CaseStudyResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_panel_requires_a_login(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_an_editor_can_reach_everything_an_admin_can(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $this->actingAs($editor);

        $this->assertTrue(CaseStudyResource::canAccess());
        $this->assertTrue(ManageSiteSettings::canAccess());
        $this->assertTrue(UserResource::canAccess());
    }

    public function test_an_editor_cannot_delete_or_change_an_admin_account(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $policy = new UserPolicy;

        $this->assertFalse($policy->delete($editor, $admin));
        $this->assertFalse($policy->update($editor, $admin));
    }

    public function test_an_editor_can_delete_and_change_another_editor(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $other = User::factory()->create(['role' => UserRole::Editor]);
        $policy = new UserPolicy;

        $this->assertTrue($policy->delete($editor, $other));
        $this->assertTrue($policy->update($editor, $other));
    }

    public function test_an_admin_can_delete_and_change_an_admin_but_not_themselves(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $otherAdmin = User::factory()->create(['role' => UserRole::Admin]);
        $policy = new UserPolicy;

        $this->assertTrue($policy->delete($admin, $otherAdmin));
        $this->assertTrue($policy->update($admin, $otherAdmin));
        $this->assertFalse($policy->delete($admin, $admin));
    }
}
