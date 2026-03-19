<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduledPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $scheduled_payments = Payment::query()
            ->whereHas('booking', fn ($booking) => $booking->confirmed())
            ->whereNotNull('scheduled_at')
            ->whereNotNull('customer_id')
            ->whereNotNull('payment_method_id')
            ->whereNull('confirmed_at')
            ->where('scheduled_at', '<=', now())
            ->where('attempts', '<', 3)
            ->get();

        foreach ($scheduled_payments as $payment) {

            $payment->scheduled_at = now()->addHours(6);
            $payment->attempts = $payment->attempts + 1;
            $payment->save();

            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $payment->amount * 100,
                'currency' => 'gbp',
                'customer' => $payment->customer_id,
                'payment_method' => $payment->payment_method_id,
                'confirm' => true,
                'off_session' => true
            ]);

            /**
             * Check for confirmed payment
             */
            if ($paymentIntent->status === 'succeeded') {
                $payment->scheduled_at = null;
                $payment->confirmed_at = now();
                $payment->save();
            }
            else {
                $payment->failed_at = now();
            }
        }
    }
}
