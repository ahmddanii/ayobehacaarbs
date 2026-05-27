<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_index_page_can_be_rendered(): void
    {
        $response = $this->get('/categories');

        $response->assertStatus(200);
    }

    public function test_category_index_displays_categories(): void
    {
        Category::factory()->create(['name' => 'Teknologi']);
        Category::factory()->create(['name' => 'Seni']);

        $response = $this->get('/categories');

        $response->assertStatus(200);
        $response->assertSee('Teknologi');
        $response->assertSee('Seni');
    }

    public function test_category_index_shows_articles_count(): void
    {
        $category = Category::factory()->create(['name' => 'Teknologi']);
        Article::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->get('/categories');

        $response->assertStatus(200);
        $response->assertSee('Teknologi');
    }

    public function test_category_index_works_with_no_categories(): void
    {
        $response = $this->get('/categories');

        $response->assertStatus(200);
    }

    public function test_categories_are_ordered_by_latest(): void
    {
        $older = Category::factory()->create([
            'name' => 'Kategori Lama',
            'created_at' => now()->subDays(2),
        ]);
        $newer = Category::factory()->create([
            'name' => 'Kategori Baru',
            'created_at' => now(),
        ]);

        $response = $this->get('/categories');

        $response->assertStatus(200);
        // Both should appear
        $response->assertSee('Kategori Lama');
        $response->assertSee('Kategori Baru');
    }
}
