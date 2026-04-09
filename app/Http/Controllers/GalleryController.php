<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __invoke()
    {
        $galleries = Gallery::all();
        
        return view('gallery.index', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        $images = $gallery->getMedia('images')->transform(fn ($image) => $image->getUrl())->toArray();
        
        seo()->title($gallery->name.' | Gallery | Summer Dreams | '.setting('year'));
        seo()->description(data_get($gallery, 'description'));

        return view('gallery.show', compact('gallery', 'images'));
    }
}
