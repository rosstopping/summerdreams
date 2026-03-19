<?php

namespace App\Jobs;

use App\Mail\BookingBalanceMail;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BookingBalancesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $bookings;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->bookings = Booking::confirmed()->where('arrival_date', today()->addDays(7))->get();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->bookings as $booking) {
            Mail::queue(new BookingBalanceMail($booking));
        }
    }
}
