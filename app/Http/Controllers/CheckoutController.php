<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Booking $booking, Request $request)
    {        
        /**
         * Prevent re-running checkout if payment method is already set
         */
        if ($booking->scheduled_payments()->whereNotNull('payment_method_id')->exists()) {
            abort(403, 'This checkout session has already been completed.');
        }

        /**
         * Setup stripe payment
         */
        $stripe = new \Stripe\StripeClient($booking->merchant->stripe_secret);

        /**
         * Create the stripe user
         */
        $customer = $stripe->customers->create([
            'name' => data_get($booking, 'name'),
            'email' => data_get($booking, 'email')
        ]);

        /**
         * Check if checkout link is for £1 deposit
         */
        if ($booking->deposit_checkout) {
            /**
             * Create the checkout session
             */
            $session = $stripe->checkout->sessions->create([
                'customer' => data_get($customer, 'id'),
                'payment_method_types' => ['card'],
                // 'allow_promotion_codes' => true,
                'mode' => 'setup',
                'success_url' => route('book.success', $booking->reference),
                'cancel_url' => route('checkout', $booking->getRawOriginal('reference')),
            ]);

            /**
             * Create the scheduled payments
             */
            $booking->createPaymentSchedule();

            /**
             * Add the stripe customer id to all scheduled payments
             */
            $booking->refresh();
            $booking->scheduled_payments->each(function($payment) use ($customer) {
                $payment->customer_id = data_get($customer, 'id');
                $payment->save();
            });
    
            return redirect($session->url);

        }

        /**
         * Build items
         */
        $name = $booking->packages->pluck('name')->implode(', ') . $booking->events->pluck('name')->implode(', ');
        if ($booking->upgrade) $name .= ' + '.$booking->upgrade->title;

        /**
         * Calculate amount
         */
        $amount = $booking->deposit ? round($booking->deposit * 100) : round($booking->amount * 100);

        /**
         * Check currency
         */
        if ($booking->packages->first()?->currency || $booking->events->first()?->currency) {
            $currency = $booking->packages->first()?->currency->value ?? $booking->events->first()?->currency->value;
        } else {
            $currency = 'GBP';
        }

        $line_items = [
            [
                'price_data' => [
                    'currency' => strtolower($currency),
                    'product_data' => [
                        'name' => $name,
                    ],
                    'unit_amount' => $amount / $booking->guests,
                ],
                'quantity' => $booking->guests,
            ]
        ];

        /**
         * Check for booking fee
         */
        if (setting('booking_fee') && $currency === 'GBP') {
            array_push($line_items, [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Booking Fee',
                    ],
                    'unit_amount' => round(setting('booking_fee') * 100),
                ],
                'quantity' => $booking->guests,
            ]);
        }

        /**
         * Create the checkout session
         */
        $session = $stripe->checkout->sessions->create([
            'payment_intent_data' => [
                'metadata' => [
                    'booking_reference' => $booking->reference,
                    'customer_email' => $booking->email,
                ],
            ],
            'line_items' => $line_items,
            'mode' => 'payment',
            'customer' => data_get($customer, 'id'),
            'payment_method_types' => ['card'],
            'success_url' => route('book.success', ['reference' => $booking->reference]),
            'cancel_url' => route('book'),
        ]);

        /**
         * Refresh session id
         */
        $request->session()->regenerate();

        /**
         * Store the session ID so we can confirm the booking later
         */
        $booking->session_id = $session->id;
        $booking->save();

        /**
         * Redirect to checkout
         */
        return redirect($session->url);
    }
}
