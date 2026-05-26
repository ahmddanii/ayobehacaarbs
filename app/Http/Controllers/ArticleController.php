<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['category', 'user'])->latest();
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $categories = Category::all();
        $articles = $query->paginate(9)->withQueryString()->fragment('kumpulan-artikel');

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->with(['category', 'user'])->firstOrFail();
        $related_articles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();
            
        return view('articles.show', compact('article', 'related_articles'));
    }
}
