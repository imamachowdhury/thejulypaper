<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $featuredArticles = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(15)
            ->get();

        $latestArticles = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(9)
            ->get();

        $mostReadArticles = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('view_count', 'desc')
            ->latest('published_at')
            ->take(5)
            ->get();

        $homepageCategories = \App\Models\Category::where('is_homepage', true)
            ->take(7)
            ->get();
        
        foreach($homepageCategories as $category) {
            $category->homepageArticles = $category->articles()
                ->where('status', 'published')
                ->latest('published_at')
                ->take(7)
                ->get();
        }

        return view('home', compact('featuredArticles', 'latestArticles', 'mostReadArticles', 'homepageCategories'));
    }

    public function show(string $slug)
    {
        $article = Article::with(['category', 'user', 'tags', 'comments'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $article->increment('view_count');

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
    public function category(string $slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with(['user', 'category'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('articles.category', compact('category', 'articles'));
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $articles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->latest('published_at')
            ->paginate(12);

        return view('articles.search', compact('articles', 'query'));
    }
}
