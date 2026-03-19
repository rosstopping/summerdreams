<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
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
        $view = 'mail.booking-confirmation-packages';

        if ($this->booking->events()->count() > 0) {
            $view = 'mail.booking-confirmation';
        }

        return $this
            ->to($this->booking->email)
            ->bcc(['office@summerdreams.co.uk'])
            ->subject('Thank you for booking with '.config('app.name'))
            ->view($view);
    }
}
