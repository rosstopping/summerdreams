<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingPriorArrivalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
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
            ->from('pickup@summerdreams.co.uk')
            ->to($this->booking->email)
            // ->bcc(['office@summerdreams.co.uk', 'ross@digizu.co.uk'])
            ->subject('We can\'t wait to see you soon! | '.config('app.name'))
            ->view('mail.booking-prior-arrival');
    }
}
