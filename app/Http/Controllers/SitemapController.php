<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Add Categories
        Category::all()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(Url::create(route('category.show', $category->slug))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        });

        // Add Published Articles
        Article::where('status', 'published')->latest('published_at')->get()->each(function (Article $article) use ($sitemap) {
            $sitemap->add(Url::create(route('articles.show', $article->slug))
                ->setPriority(0.6)
                ->setLastModificationDate($article->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        });

        // Add Pages
        Page::where('status', 'published')->get()->each(function (Page $page) use ($sitemap) {
            $sitemap->add(Url::create(route('page.show', $page->slug))
                ->setPriority(0.4)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));
        });

        return $sitemap->toResponse(request());
    }
}
