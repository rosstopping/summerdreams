<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __invoke()
    {
        $videos = Video::all();
        
        return view('pages.video', compact('videos'));
    }
}
