<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_index_page_can_be_rendered(): void
    {
        $response = $this->get('/articles');

        $response->assertStatus(200);
    }

    public function test_article_index_displays_articles(): void
    {
        $articles = Article::factory()->count(3)->create();

        $response = $this->get('/articles');

        $response->assertStatus(200);
        $response->assertSee($articles->first()->title);
    }

    public function test_article_search_by_title(): void
    {
        Article::factory()->create(['title' => 'Laravel Tutorial Lengkap']);
        Article::factory()->create(['title' => 'React JS Guide']);

        $response = $this->get('/articles?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Tutorial Lengkap');
        $response->assertDontSee('React JS Guide');
    }

    public function test_article_search_by_content(): void
    {
        Article::factory()->create([
            'title' => 'Artikel Satu',
            'content' => 'Pembahasan tentang pemrograman PHP yang mendalam',
        ]);
        Article::factory()->create([
            'title' => 'Artikel Dua',
            'content' => 'Pembahasan tentang desain grafis',
        ]);

        $response = $this->get('/articles?search=PHP');

        $response->assertStatus(200);
        $response->assertSee('Artikel Satu');
        $response->assertDontSee('Artikel Dua');
    }

    public function test_article_filter_by_category(): void
    {
        $techCategory = Category::factory()->create(['name' => 'Teknologi', 'slug' => 'teknologi']);
        $artCategory = Category::factory()->create(['name' => 'Seni', 'slug' => 'seni']);

        Article::factory()->create([
            'title' => 'Artikel Teknologi',
            'category_id' => $techCategory->id,
        ]);
        Article::factory()->create([
            'title' => 'Artikel Seni',
            'category_id' => $artCategory->id,
        ]);

        $response = $this->get('/articles?category=teknologi');

        $response->assertStatus(200);
        $response->assertSee('Artikel Teknologi');
        $response->assertDontSee('Artikel Seni');
    }

    public function test_article_search_and_filter_combined(): void
    {
        $techCategory = Category::factory()->create(['slug' => 'teknologi']);
        $artCategory = Category::factory()->create(['slug' => 'seni']);

        Article::factory()->create([
            'title' => 'Belajar Laravel Framework',
            'category_id' => $techCategory->id,
        ]);
        Article::factory()->create([
            'title' => 'Belajar Melukis Canvas',
            'category_id' => $artCategory->id,
        ]);
        Article::factory()->create([
            'title' => 'Tips Coding PHP',
            'category_id' => $techCategory->id,
        ]);

        $response = $this->get('/articles?search=Belajar&category=teknologi');

        $response->assertStatus(200);
        $response->assertSee('Belajar Laravel Framework');
        $response->assertDontSee('Belajar Melukis Canvas');
        $response->assertDontSee('Tips Coding PHP');
    }

    public function test_article_detail_page_can_be_rendered(): void
    {
        $article = Article::factory()->create(['slug' => 'artikel-testing']);

        $response = $this->get('/articles/artikel-testing');

        $response->assertStatus(200);
        $response->assertSee($article->title);
    }

    public function test_article_detail_shows_related_articles(): void
    {
        $category = Category::factory()->create();
        $mainArticle = Article::factory()->create([
            'slug' => 'main-article',
            'category_id' => $category->id,
        ]);
        $relatedArticle = Article::factory()->create([
            'title' => 'Artikel Terkait',
            'category_id' => $category->id,
        ]);

        $response = $this->get('/articles/main-article');

        $response->assertStatus(200);
        $response->assertSee('Artikel Terkait');
    }

    public function test_article_detail_increments_views_count(): void
    {
        $article = Article::factory()->create([
            'slug' => 'artikel-views',
            'views_count' => 0,
        ]);

        $this->get('/articles/artikel-views');

        $article->refresh();
        $this->assertEquals(1, $article->views_count);
    }

    public function test_article_detail_increments_views_count_multiple_times(): void
    {
        $article = Article::factory()->create([
            'slug' => 'artikel-multi-views',
            'views_count' => 5,
        ]);

        $this->get('/articles/artikel-multi-views');
        $this->get('/articles/artikel-multi-views');

        $article->refresh();
        $this->assertEquals(7, $article->views_count);
    }

    public function test_article_detail_returns_404_for_nonexistent_slug(): void
    {
        $response = $this->get('/articles/slug-tidak-ada');

        $response->assertStatus(404);
    }

    public function test_article_index_pagination_works(): void
    {
        // Create 12 articles (pagination is 9 per page)
        Article::factory()->count(12)->create();

        $response = $this->get('/articles');

        $response->assertStatus(200);

        // Page 2 should also work
        $responsePage2 = $this->get('/articles?page=2');
        $responsePage2->assertStatus(200);
    }

    public function test_article_index_with_empty_search_returns_all(): void
    {
        Article::factory()->count(3)->create();

        $response = $this->get('/articles?search=');

        $response->assertStatus(200);
    }

    public function test_article_index_with_empty_category_returns_all(): void
    {
        Article::factory()->count(3)->create();

        $response = $this->get('/articles?category=');

        $response->assertStatus(200);
    }
}
