<?php

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('page')) {
    function page($slug)
    {
        return Cache::remember('page_'.$slug, 60 * 60 * 24, fn () => Page::whereSlug($slug)->first());
    }
}

if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        $setting = Cache::remember('setting_'.$key, 60 * 60 * 24, fn () => Setting::key($key));

        return $setting === '' && $default ? $default : $setting;
    }
}

if (! function_exists('menu')) {
    function menu($menu)
    {
        return Cache::remember('menu_'.$menu, 60 * 60 * 24, fn () => data_get(nova_get_menu_by_slug($menu), 'menuItems', []));
    }
}

if (! function_exists('format_currency')) {
    function format_currency($amount, $currency = null)
    {
        $symbol = match($currency?->value ?? 'EUR') {
            'GBP' => '£',
            default => '€',
        };
        
        return $symbol . number_format($amount, 2);
    }
}
