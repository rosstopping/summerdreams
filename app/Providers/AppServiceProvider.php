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
            ->title(default: 'Zante Boat Party 2023 | VVIP Yacht Party | Zante Events | Zante Nightlife')
            ->description(default: 'Voted the Best Boat Party in Europe the VVIP Yacht Party is not your average booze cruise. Guaranteed best night of your holiday. Book tickets for 2023.');

        /**
         * Infer Title from URL
         */
        if ($title = (string) Str::of(request()->path())->replace('/', ' ')->replace('-', ' ')->title()) seo()->title($title);
    }
}
