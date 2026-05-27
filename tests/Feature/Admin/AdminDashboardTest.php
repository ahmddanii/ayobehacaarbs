<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Livewire\Admin\Dashboard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_total_articles_count(): void
    {
        $user = User::factory()->create();
        Article::factory()->count(5)->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('5');
    }

    public function test_dashboard_displays_total_categories_count(): void
    {
        $user = User::factory()->create();
        Category::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('3');
    }

    public function test_dashboard_displays_total_views(): void
    {
        $user = User::factory()->create();
        Article::factory()->create(['views_count' => 100]);
        Article::factory()->create(['views_count' => 200]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('300');
    }

    public function test_dashboard_displays_top_article(): void
    {
        $user = User::factory()->create();
        Article::factory()->create(['title' => 'Artikel Biasa', 'views_count' => 10]);
        Article::factory()->create(['title' => 'Artikel Populer', 'views_count' => 999]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Artikel Populer');
    }

    public function test_dashboard_displays_latest_articles(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['title' => 'Artikel Terbaru']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Artikel Terbaru');
    }

    public function test_dashboard_works_with_no_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('0');
    }

    public function test_dashboard_livewire_component_renders(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertStatus(200)
            ->assertSee('0');
    }
}
