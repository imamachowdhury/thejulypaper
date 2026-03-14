<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(5);
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => 'এটি একটি পরীক্ষামূলক প্রবন্ধের বিষয়বস্তু। এখানে আমরা বাংলার বিভিন্ন খবরাখবর তুলে ধরি। ' . $this->faker->paragraphs(3, true),
            'excerpt' => 'সংক্ষিপ্ত সারসংক্ষেপ: এটি একটি সংবাদ প্রবন্ধের অংশ।',
            'featured_image' => 'articles/' . $this->faker->randomElement(['business.png', 'sports.png', 'politics.png']),
            'status' => 'published',
            'published_at' => now()->subMinutes(rand(10, 500)),
            'user_id' => 1,
            'category_id' => 1, // Will be overridden
            'is_featured' => false,
            'view_count' => rand(10, 1000),
        ];
    }
}
