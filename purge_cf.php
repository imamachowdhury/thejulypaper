<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\CloudflareService;

$service = app(CloudflareService::class);
if ($service->purgeEverything()) {
    echo "Cloudflare cache purged successfully.\n";
} else {
    echo "Cloudflare cache purge failed.\n";
}
