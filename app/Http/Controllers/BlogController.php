<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __invoke()
    {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        seo()->title(data_get($post, 'seo.title', data_get($post, 'title')));
        seo()->description(data_get($post, 'seo.description', data_get($post, 'excerpt')));

        return view('blog.show', compact('post'));
    }
}
