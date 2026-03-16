<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Media;

class Article extends Model
{
    use Sluggable, HasFactory;
    
    protected static function booted()
    {
        static::saved(function ($article) {
            if ($article->featured_image && $article->wasChanged('featured_image')) {
                Media::updateOrCreate(
                    ['file_path' => $article->featured_image],
                    [
                        'user_id' => $article->user_id ?? auth()->id() ?? 1,
                        'name' => basename($article->featured_image),
                        'disk' => 'public',
                    ]
                );
            }
        });
    }

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'featured_image',
        'status', 'published_at', 'user_id', 'category_id',
        'meta_title', 'meta_description', 'is_featured', 'view_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
