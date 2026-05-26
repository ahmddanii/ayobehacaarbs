<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'total_articles' => Article::count(),
            'total_categories' => Category::count(),
            'latest_articles' => Article::with('category')->latest()->take(5)->get(),
        ]);
    }
}
