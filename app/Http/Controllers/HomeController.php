<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $latest_articles = Article::with('category')->latest()->take(3)->get();
        $categories = Category::withCount('articles')->take(6)->get();

        // Get 5 latest articles for the slider
        $slides = Article::with('category')->latest()->take(5)->get();

        return view('index', compact('latest_articles', 'categories', 'slides'));
    }
}

