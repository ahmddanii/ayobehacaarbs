<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Livewire\Admin\Articles\Index as AdminArticles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminArticleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_article_page_displays_articles(): void
    {
        $article = Article::factory()->create(['title' => 'Artikel Testing']);

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->assertSee('Artikel Testing');
    }

    public function test_can_create_new_article(): void
    {
        $category = Category::factory()->create();

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->call('create')
            ->assertSet('isWriting', true)
            ->set('title', 'Artikel Baru')
            ->set('slug', 'artikel-baru')
            ->set('content', 'Ini adalah konten artikel baru yang ditulis untuk testing.')
            ->set('categoryId', $category->id)
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('articles', [
            'title' => 'Artikel Baru',
            'slug' => 'artikel-baru',
            'category_id' => $category->id,
        ]);
    }

    public function test_create_article_validates_required_title(): void
    {
        $category = Category::factory()->create();

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', '')
            ->set('slug', 'test-slug')
            ->set('content', 'Konten testing')
            ->set('categoryId', $category->id)
            ->call('store')
            ->assertHasErrors(['title' => 'required']);
    }

    public function test_create_article_validates_required_content(): void
    {
        $category = Category::factory()->create();

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', 'Test Title')
            ->set('slug', 'test-slug')
            ->set('content', '')
            ->set('categoryId', $category->id)
            ->call('store')
            ->assertHasErrors(['content' => 'required']);
    }

    public function test_create_article_validates_required_category(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', 'Test Title')
            ->set('slug', 'test-slug')
            ->set('content', 'Test content')
            ->set('categoryId', null)
            ->call('store')
            ->assertHasErrors(['categoryId' => 'required']);
    }

    public function test_create_article_validates_invalid_category(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', 'Test Title')
            ->set('slug', 'test-slug')
            ->set('content', 'Test content')
            ->set('categoryId', 9999)
            ->call('store')
            ->assertHasErrors(['categoryId' => 'exists']);
    }

    public function test_create_article_validates_unique_slug(): void
    {
        Article::factory()->create(['slug' => 'existing-slug']);
        $category = Category::factory()->create();

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', 'New Article')
            ->set('slug', 'existing-slug')
            ->set('content', 'Content here')
            ->set('categoryId', $category->id)
            ->call('store')
            ->assertHasErrors(['slug' => 'unique']);
    }

    public function test_can_edit_existing_article(): void
    {
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'title' => 'Judul Lama',
            'slug' => 'judul-lama',
            'content' => 'Konten lama',
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->call('edit', $article->id)
            ->assertSet('articleId', $article->id)
            ->assertSet('title', 'Judul Lama')
            ->assertSet('slug', 'judul-lama')
            ->assertSet('isEdit', true)
            ->assertSet('isWriting', true)
            ->set('title', 'Judul Baru')
            ->set('slug', 'judul-baru')
            ->set('content', 'Konten baru yang sudah diupdate')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Judul Baru',
            'slug' => 'judul-baru',
        ]);
    }

    public function test_can_delete_article(): void
    {
        $article = Article::factory()->create(['title' => 'Hapus Artikel Ini']);

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->call('delete', $article->id);

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    public function test_can_search_articles_by_title(): void
    {
        Article::factory()->create(['title' => 'Belajar Laravel']);
        Article::factory()->create(['title' => 'Tutorial React']);

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('search', 'Laravel')
            ->assertSee('Belajar Laravel')
            ->assertDontSee('Tutorial React');
    }

    public function test_auto_generate_slug_when_title_updated(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', 'Artikel Baru Saya')
            ->assertSet('slug', 'artikel-baru-saya');
    }

    public function test_create_method_resets_fields_and_opens_writing(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', 'Test')
            ->set('content', 'Content')
            ->call('create')
            ->assertSet('title', '')
            ->assertSet('content', '')
            ->assertSet('isEdit', false)
            ->assertSet('isWriting', true);
    }

    public function test_title_max_length_validation(): void
    {
        $category = Category::factory()->create();

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->set('title', str_repeat('a', 256))
            ->set('slug', 'test-slug')
            ->set('content', 'Content here')
            ->set('categoryId', $category->id)
            ->call('store')
            ->assertHasErrors(['title' => 'max']);
    }

    public function test_confirm_delete_dispatches_event(): void
    {
        $article = Article::factory()->create();

        Livewire::actingAs($this->user)
            ->test(AdminArticles::class)
            ->call('confirmDelete', $article->id)
            ->assertDispatched('swal:confirm');
    }
}
