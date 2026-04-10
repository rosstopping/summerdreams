<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerBookingConfirmationMail extends Mailable
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
            ->to($this->booking->email)
            ->bcc('contact@summerdreamsholidays.com')
            ->subject('Thank you for booking with '.config('app.name'))
            ->view('mail.seller-booking-confirmation');
    }
}
