<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Popup;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewView;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function (ViewView $view) {
            /**
             * Check for a page
             */
            $page = Page::whereUrl(request()->path())->first();

            if ($page) {
                seo()->title(data_get($page, 'seo.title'));
                seo()->description(data_get($page, 'seo.description'));
                
                $view->with('page', $page);
            }

            /**
             * Check for a popup
             */
            $popup = Popup::whereJsonContains('pages', request()->path())
                ->orWhereJsonContains('pages', request()->segment(1).'/*')
                ->orWhereNull('pages')
                ->first();
                
            $view->with('popup', $popup);
        });
    }
}
