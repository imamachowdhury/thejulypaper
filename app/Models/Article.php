<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Media;
use App\Services\CloudflareService;

class Article extends Model
{
    use Sluggable, HasFactory, \App\Traits\PurgesCloudflareCache;
    
    protected static function booted()
    {
        static::saving(function ($article) {
            if ($article->status === 'published' && is_null($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::saved(function ($article) {
            if ($article->featured_image && $article->wasChanged('featured_image')) {
                // Image Optimization Logic
                try {
                    $originalPath = $article->featured_image;
                    $fullPath = storage_path('app/public/' . $originalPath);
                    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                    
                    if (file_exists($fullPath) && !in_array(strtolower($extension), ['webp', 'svg'])) {
                        $manager = \Intervention\Image\ImageManager::gd();
                        $image = $manager->read($fullPath);
                        
                        $newPath = 'articles/' . pathinfo($originalPath, PATHINFO_FILENAME) . '.webp';
                        $image->toWebp(80)->save(storage_path('app/public/' . $newPath));
                        
                        // Update model without triggering more events
                        $article->withoutEvents(function () use ($article, $newPath) {
                            $article->update(['featured_image' => $newPath]);
                        });
                        
                        // Delete old file
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Image Optimization Error: ' . $e->getMessage());
                }

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

    /**
     * Get published date in Bangla format: মার্চ ১৬, ২০২৬, ১৩:২৫
     */
    public function getBanglaDate()
    {
        if (!$this->published_at) return '';
        
        $date = $this->published_at->locale('bn')->isoFormat('MMMM D, YYYY, HH:mm');
        
        $search = ['0','1','2','3','4','5','6','7','8','9'];
        $replace = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        
        return str_replace($search, $replace, $date);
    }

    /**
     * Get the URL for the featured image, or a placeholder if it doesn't exist.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->featured_image)) {
            return \Illuminate\Support\Facades\Storage::url($this->featured_image);
        }

        return 'https://placehold.co/800x450/f1f5f9/64748b?text=The+July+Paper';
    }
}
