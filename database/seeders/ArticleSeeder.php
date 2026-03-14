<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Technology', 'Business', 'Lifestyle', 'Health', 'Science'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
                'description' => "Latest news in $cat",
            ]);
        }

        $tags = ['Breaking', 'Trending', 'Local', 'Global', 'In-depth'];
        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        $admin = User::first();
        $cats = Category::all();
        $allTags = Tag::all();

        for ($i = 1; $i <= 10; $i++) {
            $title = "Sample News Article $i";
            $article = Article::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "This is the content for sample news article $i. It contains details about current events and interesting facts.",
                'excerpt' => "Short summary of sample news article $i.",
                'status' => 'published',
                'published_at' => now(),
                'user_id' => $admin->id,
                'category_id' => $cats->random()->id,
                'is_featured' => $i <= 3,
            ]);

            $article->tags()->attach($allTags->random(mt_rand(1, 3))->pluck('id'));
        }
    }
}
