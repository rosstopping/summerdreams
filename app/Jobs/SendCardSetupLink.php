<?php

namespace App\Jobs;

use App\Mail\CardSetupLinkMail;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCardSetupLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Booking $booking
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Setup stripe payment
         */
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        /**
         * Create the stripe user
         */
        $customer = $stripe->customers->create([
            'name' => $this->booking->name,
            'email' => $this->booking->email
        ]);

        /**
         * Create the check session
         */
        $session = $stripe->checkout->sessions->create([
            'customer' => data_get($customer, 'id'),
            'payment_method_types' => ['card'],
            'mode' => 'setup',
            'success_url' => route('book.success', $this->booking->reference),
            'cancel_url' => route('home'),
        ]);

        /**
         * Add the stripe customer id to all scheduled payments
         */
        $this->booking->scheduled_payments->each(function($payment) use ($customer) {
            $payment->customer_id = data_get($customer, 'id');
            $payment->save();
        });

        $url = $session->url;

        /**
         * Send the mail to the customer
         */
        Mail::queue(new CardSetupLinkMail($this->booking, $url));
    }
}
