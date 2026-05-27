<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_has_correct_fillable_attributes(): void
    {
        $category = new Category();

        $this->assertEquals(
            ['name', 'slug', 'image'],
            $category->getFillable()
        );
    }

    public function test_category_has_many_articles(): void
    {
        $category = Category::factory()->create();

        Article::factory()->count(3)->create([
            'category_id' => $category->id,
        ]);

        $this->assertCount(3, $category->articles);
        $this->assertInstanceOf(Article::class, $category->articles->first());
    }

    public function test_category_can_be_created_with_factory(): void
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ]);
    }

    public function test_category_slug_is_unique(): void
    {
        Category::factory()->create(['slug' => 'teknologi']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::factory()->create(['slug' => 'teknologi']);
    }
}
