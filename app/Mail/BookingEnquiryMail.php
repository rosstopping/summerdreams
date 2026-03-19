<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class BookingEnquiryMail extends Mailable
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
        /**
         * Change api endpoint based on environment
         */
        $api = 'https://api.webexinteract.com/v1/sms/test';

        if (app()->environment('production')) {
            $api = 'https://api.webexinteract.com/v1/sms';
        }

        $response = Http::withHeaders([
            'X-AUTH-KEY' => config('sms.api_key'),
        ])->post($api, [
            'from' => config('sms.sender_id'),
            'message_body' => 'New booking enquiry from '.$this->booking->name.'. https://summerdreams.com/admin/resources/bookings/' . $this->booking->id,
            'to' => [
                [
                    'phone' => ['+447956088925']
                ]
            ],
        ]);

        return $this
            ->to(config('mail.from.address'))
            ->subject('Booking Enquiry | '.config('app.name'))
            ->view('mail.booking-enquiry');
    }
}
