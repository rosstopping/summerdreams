<?php

namespace App\Nova\Metrics;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\CarbonPeriod;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;
use Laravel\Nova\Nova;

class BalancingPaymentsPerDay extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // return $this->sumByDays($request, Booking::class, 'deposit');

        $trend = [];

        $period = CarbonPeriod::create(today()->subDays($request->range), today());

        foreach ($period as $day) {
            $trend[$day->format('Y-m-d')] = Payment::whereDate('confirmed_at', $day)
                ->whereHas('booking', function ($booking) use ($day) {
                        $booking
                        ->confirmed()
                        ->whereDate('confirmed_at', '!=', $day);
                })
                ->sum('amount') / 100;
            // $payments = Payment::whereDate('confirmed_at', $day)->sum('amount') / 100;
            // $deposits = Booking::confirmed()->whereDate('confirmed_at', $day)->get()->sum('deposit');
            // $trend[$day->format('Y-m-d')] = $payments - $deposits;
        }
        
        return (new TrendResult())->trend($trend)
            ->prefix('£')
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
        return 'balancing-payments-per-day';
    }
}
