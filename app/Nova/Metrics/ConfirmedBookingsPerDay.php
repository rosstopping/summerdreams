<?php

namespace App\Nova\Metrics;

use App\Models\Booking;
use Carbon\CarbonPeriod;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;
use Laravel\Nova\Nova;

class ConfirmedBookingsPerDay extends Trend
{
    public function name()
    {
        return 'Guests Per Day';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $trend = [];

        $period = CarbonPeriod::create(today()->subDays($request->range), today());

        foreach ($period as $day) {
            $trend[$day->format('Y-m-d')] = Booking::confirmed()->whereDate('confirmed_at', $day)->sum('guests');
        }
        
        return (new TrendResult())->trend($trend)
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ])
            ->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            7 => Nova::__('7 Days'),
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
            365 => Nova::__('365 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(30);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'confirmed-bookings-per-day';
    }
}
