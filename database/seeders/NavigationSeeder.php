<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\MenuLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing menus
        MenuLink::truncate();
        Page::truncate();

        // 1. Create Static Pages
        $pages = [
            ['title' => 'আমাদের কথা', 'content' => '<p>জুলাই পেপার (The July Paper) একটি স্বতন্ত্র সংবাদ মাধ্যম। আমরা সত্য ও বস্তুনিষ্ঠ সংবাদ পরিবেশনে প্রতিশ্রুতিবদ্ধ।</p>'],
            ['title' => 'যোগাযোগ', 'content' => '<p>আমাদের সাথে যোগাযোগ করতে ইমেল করুন: contact@thejulypaper.com</p>'],
            ['title' => 'গোপনীয়তা নীতি', 'content' => '<p>আপনার তথ্য আমাদের কাছে সুরক্ষিত। আমরা কঠোরভাবে গোপনীয়তা নীতি মেনে চলি।</p>'],
            ['title' => 'ব্যবহারের শর্তাবলী', 'content' => '<p>এই ওয়েবসাইট ব্যবহারের মাধ্যমে আপনি আমাদের শর্তাবলীর সাথে একমত পোষণ করছেন।</p>'],
        ];

        foreach ($pages as $p) {
            Page::create([
                'title' => $p['title'],
                'slug' => Str::slug($p['title']),
                'content' => $p['content'],
                'status' => 'published',
            ]);
        }

        $allPages = Page::all();
        $categories = Category::all();

        // 2. Primary Menu (Header)
        $order = 1;
        foreach ($categories as $cat) {
            MenuLink::create([
                'label' => $cat->name,
                'type' => 'category',
                'category_id' => $cat->id,
                'location' => 'primary',
                'sort_order' => $order++,
            ]);
        }

        // 3. Footer Menu - Categories
        $footerCatOrder = 1;
        foreach ($categories->take(4) as $cat) {
            MenuLink::create([
                'label' => $cat->name,
                'type' => 'category',
                'category_id' => $cat->id,
                'location' => 'footer',
                'sort_order' => $footerCatOrder++,
            ]);
        }

        // 4. Footer Menu - Pages
        $footerPageOrder = 1;
        foreach ($allPages as $page) {
            MenuLink::create([
                'label' => $page->title,
                'type' => 'page',
                'page_id' => $page->id,
                'location' => 'footer',
                'sort_order' => $footerPageOrder++,
            ]);
        }
    }
}
