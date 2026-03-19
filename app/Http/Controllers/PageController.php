<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PageController extends Controller
{
    public function __invoke($url = '/')
    {
        $page = Page::whereUrl($url)->first();

        if ($page) {

            seo()->title(data_get($page, 'seo.title'));
            seo()->description(data_get($page, 'seo.description'));
    
            if ($page->template) return view('pages.templates.'.$page->template, compact('page'));
                
            return View::first(['pages.' . $page->slug, 'pages.default'], compact('page'));
        }

        /**
         * Check for a post
         */
        $post = Post::where('slug', $url)->first();

        if ($post) {

            seo()->title(data_get($post, 'seo.title', data_get($post, 'title')));
            seo()->description(data_get($post, 'seo.description', data_get($post, 'excerpt')));

            return view('blog.show', compact('post'));
        }

        /**
         * Check for redirect
         */
        $redirect = Redirect::where('from', $url)->firstOrFail();

        return redirect()->to(url($redirect->to));
    }
}
