<?php

namespace App\Jobs;

use App\Mail\AdditionalPaymentMail;
use App\Models\Booking;
use App\Mail\BookingConfirmationMail;
use App\Mail\ExtraBookedMail;
use App\Mail\FinalPaymentMail;
use App\Mail\SellerBookingConfirmationMail;
use App\Models\Extra;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Str;

class StripeCheckoutSessionCompleted implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        /**
         * Check if this was used to setup future payments
         */
        if (data_get($this->webhookCall->payload, 'data.object.mode') === 'setup') {
        
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            /**
             * Retreive the checkout session
             */
            $session = $stripe->checkout->sessions->retrieve(
                data_get($this->webhookCall->payload, 'data.object.id'),
                []
            );
    
            /**
             * Retrieve the setup Intent
             */
            $setupIntent = $stripe->setupIntents->retrieve($session->setup_intent, []);
    
            /**
             * Store the payment method on the payments
             * Only get scheduled payments without a payment method already
             */
            Payment::query()
                ->whereNotNull('scheduled_at')
                ->whereNull('payment_method_id')
                ->where('customer_id', data_get($this->webhookCall->payload, 'data.object.customer'))
                ->update([
                    'payment_method_id' => $setupIntent->payment_method
                ]);
    
            /**
             * Get the booking from a payment
             */
            $booking = Booking::whereHas('scheduled_payments', fn ($payment) => $payment->where('customer_id', data_get($this->webhookCall->payload, 'data.object.customer')))->first();
    
            /**
             * Confirm the booking
             */
            if (!$booking->confirmed_at) {
                $booking->confirmed_at = now();
                $booking->save();

                MailchimpAddBookingTagJob::dispatch($booking->email);

                if ($booking->seller) {
                    Mail::queue(new SellerBookingConfirmationMail($booking));
                }
                else {
                    Mail::queue(new BookingConfirmationMail($booking));
                }
            }
        }

        else {

            /**
             * Get the booking reference
             */
            $reference = Str::of(data_get($this->webhookCall->payload, 'data.object.success_url'))->after('?reference=SD');
            
            /**
             * Check for a booking with this reference
             */
            $booking = Booking::where('reference', $reference)->first();

            if ($booking) {
                $booking->confirmed_at = $booking->confirmed_at ?: now();
                $booking->save();
    
                /**
                 * Add the payment to the booking
                 */
                $booking->payments()->create([
                    'confirmed_at' => now(),
                    'amount' => data_get($this->webhookCall->payload, 'data.object.amount_total') / 100
                ]);
                
                MailchimpAddBookingTagJob::dispatch($booking->email);

                /**
                 * Check if this first payment
                 */
                if ($booking->payments->count() === 1) Mail::queue(new BookingConfirmationMail($booking));
                
                /**
                 * Check if there is more than 1 payment but there's still a balance
                 */
                if ($booking->payments->count() > 1 && $booking->balance > 0) Mail::queue(new AdditionalPaymentMail($booking, data_get($this->webhookCall->payload, 'data.object.amount_total') / 100));
                
                /**
                 * Check if there is more than 1 payment and there's no balance
                 */
                if ($booking->payments->count() > 1 && $booking->balance <= 0) Mail::queue(new FinalPaymentMail($booking, data_get($this->webhookCall->payload, 'data.object.amount_total') / 100));
                
            }

            /**
             * Check for a payment with this reference
             */
            $reference = Str::of(data_get($this->webhookCall->payload, 'data.object.success_url'))->after('?reference=');
            $payment = Payment::where('reference', $reference)->first();

            if ($payment) {
                /**
                 * Confirm the payment
                 */
                $payment->confirmed_at = now();
                $payment->save();

                if ($payment->extra_data) {
                    /**
                     * Attach the extra to the booking
                     */
                    $payment->booking->extras()->attach(data_get($payment->extra_data, 'id'), [
                        'quantity' => data_get($payment->extra_data, 'quantity'),
                        'date' => data_get($payment->extra_data, 'date'),
                    ]);

                    /**
                     * Get the extra
                     */
                    $extra = Extra::find(data_get($payment->extra_data, 'id'));

                    /**
                     * Send confirmation mail
                     */
                    Mail::queue(new ExtraBookedMail($booking, $extra));
                }
            }
        }
    }
}
