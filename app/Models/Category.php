<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Sluggable, \App\Traits\PurgesCloudflareCache;

    protected $fillable = ['name', 'slug', 'description', 'is_homepage'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
