<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    protected $fillable = [
        'label', 
        'url', 
        'category_id', 
        'page_id', 
        'type', 
        'location', 
        'sort_order'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getComputedUrlAttribute()
    {
        if ($this->type === 'category' && $this->category) {
            return route('category.show', $this->category->slug);
        }
        
        if ($this->type === 'page' && $this->page) {
            return route('page.show', $this->page->slug);
        }
        
        return $this->url;
    }
}
