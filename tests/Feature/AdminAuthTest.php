<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Pages\Auth\Login;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    public function test_admin_user_can_authenticate_via_filament(): void
    {
        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'portal@admin.com',
                'password' => 'P@ssw0rd',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect('/admin');

        $this->assertAuthenticated();
    }

    public function test_legacy_management_user_can_authenticate_via_filament(): void
    {
        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'management@chandradaya-investasi.com',
                'password' => 'P@ssw0rd',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect('/admin');

        $this->assertAuthenticated();
    }

    public function test_authenticated_admin_can_access_dashboard_and_pages(): void
    {
        $user = User::where('email', 'management@chandradaya-investasi.com')->first();
        $this->assertNotNull($user);

        $routes = [
            '/admin',
            '/admin/home-page-content',
            '/admin/about-us-page-content',
            '/admin/governance-page-content',
            '/admin/global-settings-page',
            '/admin/seo-metadata-page',
            '/admin/utility/quick-links',
            '/admin/utility/preferences',
            '/admin/users',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($user)->get($route);
            $response->assertStatus(200);
        }
    }
}
