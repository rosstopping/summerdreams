<?php

namespace App\Providers;

use App\View\Components\Content\ListEvents;
use App\View\Components\Content\ListPackages;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        Blade::directive('setting', function ($exp) {
            return "<?php echo setting($exp);?>";
        });

        Blade::directive('currency', function ($exp) {
            return "<?php echo match(strtolower($exp)) {
                'eur', 'euro' => '€',
                'usd', 'dollar' => '$',
                'gbp', 'pound' => '£',
                default => '£'
            }; ?>";
        });

        /**
         * SEO Defaults
         */
        seo()           
            ->withUrl()
            ->title(default: 'Summer Dreams - Home of Ayia Napa\'s biggest events')
            ->description(default: 'When It Comes to Your Napa Holiday, This Is What Dreams Are Made Of. Summer Dreams.');

        /**
         * Infer Title from URL
         */
        if ($title = (string) Str::of(request()->path())->replace('/', ' ')->replace('-', ' ')->title()) seo()->title($title);
    }
}
