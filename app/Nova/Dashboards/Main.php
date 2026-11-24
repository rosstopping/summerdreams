<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\BalancingPaymentsPerDay;
use App\Nova\Metrics\CancelledBookings;
use App\Nova\Metrics\ConfirmedBookings;
use App\Nova\Metrics\ConfirmedBookingsPerDay;
use App\Nova\Metrics\ConfirmedBookingsTotal;
use App\Nova\Metrics\ConfirmedGuests;
use App\Nova\Metrics\DepositsPerDay;
use App\Nova\Metrics\DepositsPerMonthLineChart;
use App\Nova\Metrics\GuestsPerMonthLineChart;
use App\Nova\Metrics\LeadsPerMonthLineChart;
use App\Nova\Metrics\NewEnquiries;
use App\Nova\Metrics\PotentialBookingsPerDay;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function name()
    {
        return 'Metrics';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            // new Help,
            (new ConfirmedBookingsPerDay)->width('1/2')->canSee(fn ($request) => $request->user()->master),
            (new PotentialBookingsPerDay)->width('1/2')->canSee(fn ($request) => $request->user()->master),
            (new DepositsPerDay)->width('1/2')->canSee(fn ($request) => $request->user()->master),
            (new BalancingPaymentsPerDay)->width('1/2')->canSee(fn ($request) => $request->user()->master),
            (new NewEnquiries)->canSee(fn ($request) => $request->user()->master),
            (new ConfirmedBookings)->canSee(fn ($request) => $request->user()->master),
            (new ConfirmedGuests)->canSee(fn ($request) => $request->user()->master),
            (new CancelledBookings)->canSee(fn ($request) => $request->user()->master),
            (new ConfirmedBookingsTotal)->canSee(fn ($request) => $request->user()->master),
            /**
             * Deposits per day chart
             */
            (new DepositsPerMonthLineChart)->canSee(fn ($request) => $request->user()->master),
            (new GuestsPerMonthLineChart)->canSee(fn ($request) => $request->user()->master),
            (new LeadsPerMonthLineChart)->canSee(fn ($request) => $request->user()->master),
        ];
    }
}
