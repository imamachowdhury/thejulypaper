<?php

namespace App\Traits;

use App\Services\CloudflareService;
use Illuminate\Support\Facades\Log;

trait PurgesCloudflareCache
{
    protected static function bootPurgesCloudflareCache()
    {
        static::saved(function ($model) {
            static::triggerCloudflarePurge();
        });

        static::deleted(function ($model) {
            static::triggerCloudflarePurge();
        });
    }

    protected static function triggerCloudflarePurge()
    {
        try {
            app(CloudflareService::class)->purgeEverything();
        } catch (\Exception $e) {
            Log::error('Cloudflare Purge Error (' . class_basename(static::class) . '): ' . $e->getMessage());
        }
    }
}
