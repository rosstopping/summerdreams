<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class FixUpgradeBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-upgrade-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Booking::query()
            ->confirmed()
            ->whereDoesntHave('packages')
            ->whereDoesntHave('events')
            ->whereHas('upgrade')
            ->get()
            ->each(function($booking) {
                $booking->packages()->attach($booking->upgrade->package->id);
            });
    }
}
