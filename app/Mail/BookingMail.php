<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $subject;
    public $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $subject, $content)
    {
        $this->booking = $booking;
        $this->subject = $subject;
        $this->content = $content;
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
            // ->bcc('ross@digizu.co.uk')
            ->bcc('contact@summerdreamsholidays.com')
            ->subject($this->subject)
            ->view('mail.booking-mail');
    }
}
