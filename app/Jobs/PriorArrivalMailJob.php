<?php

namespace App\Jobs;

use App\Mail\BookingPriorArrivalMail;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PriorArrivalMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bookings = Booking::confirmed()->where('arrival_date', '=', today()->addDays(10))->get();

        foreach ($bookings as $booking) {
            Mail::queue(new BookingPriorArrivalMail($booking));
        }
    }
}
