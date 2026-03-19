<?php

namespace Digizu\Calendar;

use App\Models\Arrival;
use App\Models\Booking;
use App\Models\Event;
use Digizu\Calendar\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Cache;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {

            $events = Cache::remember('calendar_events', 60 * 60 * 3, function () {

                $events = [];

                foreach (Event::get() as $event) {
                    foreach ($event->dates(include_sold_out: true) as $date) {
                        /**
                         * Build the filter url
                         */
                        $filter = base64_encode(json_encode([
                            ['class' => \App\Nova\Filters\EventFilter::class, 'value' => $event->name],
                            ['class' => \App\Nova\Filters\EventDateFilter::class, 'value' => $date->format('Y-m-d')],
                        ]));

                        /**
                         * Get the bookings count
                         */
                        $bookings_count = Booking::where('dates->'.$event->name, $date->toDateTimeString())->confirmed()->sum('guests');

                        array_push($events, [
                            'id' => $event->id . $date,
                            'title' => '('.$bookings_count.') ' . $event->name,
                            'start' => $date->format('Y-m-d'),
                            'url' => '/admin/resources/bookings?bookings_filter='.urlencode($filter)
                        ]);
                    }
                }

                return $events;
            });

            Nova::provideToScript([
                'events' => $events
            ]);
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'calendar')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/calendar')
            ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
