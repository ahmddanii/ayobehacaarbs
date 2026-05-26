<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Ayo Behacaar',
            'email' => 'admin@ayobehacaar.com',
        ]);

        $categories = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Kebudayaan', 'slug' => 'kebudayaan'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
        ];

        foreach ($categories as $cat) {
            $category = Category::create($cat);

            Article::create([
                'title' => 'Mengenal Literasi di Era Digital: Tantangan ' . $cat['name'],
                'slug' => Str::slug('Mengenal Literasi di Era Digital Tantangan ' . $cat['name']),
                'content' => 'Ini adalah konten artikel tentang ' . $cat['name'] . '. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category_id' => $category->id,
                'user_id' => $user->id,
                'is_published' => true,
            ]);
        }
    }
}
