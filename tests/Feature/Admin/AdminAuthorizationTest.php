<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    // --- Guest users should be redirected to login ---

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_is_redirected_from_admin_categories(): void
    {
        $response = $this->get('/admin/categories');

        $response->assertRedirect('/login');
    }

    public function test_guest_is_redirected_from_admin_articles(): void
    {
        $response = $this->get('/admin/articles');

        $response->assertRedirect('/login');
    }

    public function test_guest_is_redirected_from_admin_settings(): void
    {
        $response = $this->get('/admin/settings');

        $response->assertRedirect('/login');
    }

    // --- Authenticated users can access admin pages ---

    public function test_authenticated_user_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_admin_categories(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/categories');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_admin_articles(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/articles');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_admin_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/settings');

        $response->assertStatus(200);
    }

    // --- Profile routes also require auth ---

    public function test_guest_is_redirected_from_profile(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }
}
