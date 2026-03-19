<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class ConvertImagesToWebP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-images-to-webp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Media::all() as $media) {
            $media->file_name = (string) Str::of($media->file_name)
                ->replace('.jpeg', '.webp')
                ->replace('.jpg', '.webp')
                ->replace('.JPG', '.webp')
                ->replace('.png', '.webp');

            $media->mime_type = 'image/webp';

            if ($media->responsive_images) {
                $urls = [];

                foreach (data_get($media->responsive_images, 'media_library_original.urls') as $url) {
                    $url = (string) Str::of($url)
                        ->replace('.jpeg', '.webp')
                        ->replace('.jpg', '.webp')
                        ->replace('.JPG', '.webp')
                        ->replace('.png', '.webp');
    
                    array_push($urls, $url);
                }
    
                $media->responsive_images = [
                    'media_library_original' => [
                        'urls' => $urls
                    ]
    
                ];
            }

            $media->save();
        }
    }
}
