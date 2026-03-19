<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Extra;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ExtraBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $extra;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, Extra $extra)
    {
        $this->extra = $extra;
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to(config('mail.from.address'))
            ->bcc(config('mail.from.address'))
            ->subject($this->extra->name . ' | Payment Confirmed | '.config('app.name'))
            ->view('mail.extra-booked');
    }
}
