<?php

namespace Digizu\Calendar;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class Calendar extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('calendar', __DIR__.'/../dist/js/tool.js');
        Nova::style('calendar', __DIR__.'/../dist/css/tool.css');

        Nova::style('fullcalendar-css', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css');
        Nova::script('fullcalendar-js', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js');
        Nova::script('alpine-js', 'https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make('Calendar')
            ->path('/calendar')
            ->icon('calendar');
    }
}
