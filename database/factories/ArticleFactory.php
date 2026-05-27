<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'is_published' => true,
            'views_count' => fake()->numberBetween(0, 500),
        ];
    }

    /**
     * Indicate that the article is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    /**
     * Indicate that the article has a specific views count.
     */
    public function withViews(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => $count,
        ]);
    }
}
