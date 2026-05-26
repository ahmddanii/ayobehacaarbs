<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'semua');

        $articlesQuery = Article::with('category');

        if ($filter === 'populer') {
            $articlesQuery->orderBy('views_count', 'desc');
        } elseif ($filter === 'terlama') {
            $articlesQuery->orderBy('created_at', 'asc');
        } else {
            $articlesQuery->latest();
        }

        $latest_articles = $articlesQuery->take(3)->get();
        
        $categories = Category::withCount('articles')->take(6)->get();

        // Get 5 latest articles for the slider
        $slides = Article::with('category')->latest()->take(5)->get();

        return view('index', compact('latest_articles', 'categories', 'slides'));
    }
}
