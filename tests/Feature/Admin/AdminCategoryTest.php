<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Livewire\Admin\Categories\Index as AdminCategories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_category_page_displays_categories(): void
    {
        Category::factory()->create(['name' => 'Teknologi']);
        Category::factory()->create(['name' => 'Seni']);

        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->assertSee('Teknologi')
            ->assertSee('Seni');
    }

    public function test_can_create_new_category(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('name', 'Kategori Baru')
            ->set('slug', 'kategori-baru')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'name' => 'Kategori Baru',
            'slug' => 'kategori-baru',
        ]);
    }

    public function test_create_category_validates_required_name(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('name', '')
            ->set('slug', 'test-slug')
            ->call('store')
            ->assertHasErrors(['name' => 'required']);
    }

    public function test_create_category_validates_required_slug(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('name', 'Test')
            ->set('slug', '')
            ->call('store')
            ->assertHasErrors(['slug' => 'required']);
    }

    public function test_create_category_validates_unique_slug(): void
    {
        Category::factory()->create(['slug' => 'teknologi']);

        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('name', 'Teknologi Duplicate')
            ->set('slug', 'teknologi')
            ->call('store')
            ->assertHasErrors(['slug' => 'unique']);
    }

    public function test_can_edit_existing_category(): void
    {
        $category = Category::factory()->create([
            'name' => 'Nama Lama',
            'slug' => 'nama-lama',
        ]);

        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->call('edit', $category->id)
            ->assertSet('categoryId', $category->id)
            ->assertSet('name', 'Nama Lama')
            ->assertSet('slug', 'nama-lama')
            ->assertSet('isEdit', true)
            ->set('name', 'Nama Baru')
            ->set('slug', 'nama-baru')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Nama Baru',
            'slug' => 'nama-baru',
        ]);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create(['name' => 'Hapus Ini']);

        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->call('delete', $category->id);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_can_search_categories_by_name(): void
    {
        Category::factory()->create(['name' => 'Teknologi']);
        Category::factory()->create(['name' => 'Seni']);

        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('search', 'Tekno')
            ->assertSee('Teknologi')
            ->assertDontSee('Seni');
    }

    public function test_auto_generate_slug_when_name_updated(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('name', 'Kategori Baru Saya')
            ->assertSet('slug', 'kategori-baru-saya');
    }

    public function test_category_name_max_length_validation(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->set('name', str_repeat('a', 256))
            ->set('slug', 'test-slug')
            ->call('store')
            ->assertHasErrors(['name' => 'max']);
    }

    public function test_category_shows_articles_count(): void
    {
        $category = Category::factory()->create(['name' => 'Teknologi']);
        Article::factory()->count(3)->create(['category_id' => $category->id]);

        Livewire::actingAs($this->user)
            ->test(AdminCategories::class)
            ->assertSee('Teknologi')
            ->assertSee('3');
    }
}
