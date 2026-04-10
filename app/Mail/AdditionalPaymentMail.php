<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdditionalPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $payment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $payment)
    {
        $this->booking = $booking;
        $this->payment = $payment;
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
            ->subject('Thank you for payment')
            ->view('mail.additional-payment-mail');
    }
}
