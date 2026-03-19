<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class RemoveBrokenConfirmedBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-broken-confirmed-bookings';

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
            ->whereDoesntHave('upgrade')
            ->where('confirmed_at', '<', now()->subDays(1))
            ->get()
            ->each(function($booking) {
                $booking->confirmed_at = null;
                $booking->save();
            });
    }
}
