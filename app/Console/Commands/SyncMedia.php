<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SyncMedia extends Command
{
    protected $signature = 'media:sync';
    protected $description = 'Sync uploaded files to the Media table';

    public function handle()
    {
        $this->info('Starting media sync...');

        $directories = ['articles', 'media'];
        $count = 0;

        foreach ($directories as $dir) {
            $files = Storage::disk('public')->files($dir);
            
            foreach ($files as $file) {
                $exists = Media::where('file_path', $file)->exists();
                
                if (!$exists) {
                    Media::create([
                        'user_id' => 1, // Default to first user or admin
                        'name' => basename($file),
                        'file_path' => $file,
                        'file_type' => Storage::disk('public')->mimeType($file),
                        'file_size' => Storage::disk('public')->size($file),
                        'disk' => 'public',
                    ]);
                    $count++;
                }
            }
        }

        $this->info("Sync completed. Added {$count} new media records.");
    }
}
