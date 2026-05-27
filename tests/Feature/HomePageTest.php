<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_displays_latest_articles(): void
    {
        $category = Category::factory()->create();
        $articles = Article::factory()->count(3)->create([
            'category_id' => $category->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($articles->first()->title);
    }

    public function test_homepage_displays_categories(): void
    {
        $category = Category::factory()->create(['name' => 'Teknologi']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Teknologi');
    }

    public function test_homepage_displays_slider_articles(): void
    {
        $articles = Article::factory()->count(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        // Slider should contain at most 5 latest articles
        $response->assertSee($articles->first()->title);
    }

    public function test_homepage_works_with_no_data(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
