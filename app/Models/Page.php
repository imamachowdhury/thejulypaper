<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use Sluggable, \App\Traits\PurgesCloudflareCache;

    protected $fillable = ['title', 'slug', 'content', 'status'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
