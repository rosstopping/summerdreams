<?php

namespace Digizu\SeasonalLineChart;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (): void {
            Nova::script('seasonal-line-chart', __DIR__.'/../dist/js/card.js');
        });
    }
}
