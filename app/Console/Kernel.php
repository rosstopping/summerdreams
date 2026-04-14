<?php

namespace App\Console;

use App\Jobs\BookingBalancesJob;
use App\Jobs\PaymentReminderJob;
use App\Jobs\PriorArrivalMailJob;
use App\Jobs\ScheduledPayments;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:fix-upgrade-bookings')->daily();
        $schedule->command('app:remove-broken-confirmed-bookings')->daily();
        $schedule->job(new ScheduledPayments)->everyMinute();
        $schedule->job(new PaymentReminderJob)->everyMinute();
        // $schedule->job(new BookingBalancesJob)->dailyAt('11:00');
        // $schedule->job(new PriorArrivalMailJob)->dailyAt('11:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
