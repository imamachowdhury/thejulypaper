<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareService
{
    protected ?string $zoneId;
    protected ?string $apiKey;
    protected ?string $email;

    public function __construct()
    {
        $this->zoneId = config('services.cloudflare.zone_id');
        $this->apiKey = config('services.cloudflare.api_key');
        $this->email = config('services.cloudflare.email');
    }

    /**
     * Purge everything from Cloudflare cache.
     */
    public function purgeEverything(): bool
    {
        if (!$this->zoneId || !$this->apiKey || !$this->email) {
            return false;
        }

        $response = Http::withHeaders([
            'X-Auth-Email' => $this->email,
            'X-Auth-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("https://api.cloudflare.com/client/v4/zones/{$this->zoneId}/purge_cache", [
            'purge_everything' => true,
        ]);

        if ($response->successful()) {
            Log::info('Cloudflare cache purged successfully.');
            return true;
        }

        Log::error('Cloudflare cache purge failed: ' . $response->body());
        return false;
    }

    /**
     * Purge specific URLs from Cloudflare cache.
     */
    public function purgeUrls(array $urls): bool
    {
        if (!$this->zoneId || !$this->apiKey || !$this->email) {
            return false;
        }

        $response = Http::withHeaders([
            'X-Auth-Email' => $this->email,
            'X-Auth-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("https://api.cloudflare.com/client/v4/zones/{$this->zoneId}/purge_cache", [
            'files' => $urls,
        ]);

        return $response->successful();
    }
}
