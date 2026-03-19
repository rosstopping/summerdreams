<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeCheckoutLinkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Booking $booking, $amount)
    {
        /**
         * Setup stripe payment
         */
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        /**
         * Create the stripe user
         */
        $customer = $stripe->customers->create([
            'name' => data_get($booking, 'name'),
            'email' => data_get($booking, 'email')
        ]);

        /**
         * Build items
         */
        $line_items = [
            [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Balance Payment',
                    ],
                    'unit_amount' => round($amount * 100),
                ],
                'quantity' => 1,
            ]
        ];

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
            'success_url' => route('payment.success', ['reference' => $booking->reference]),
            'cancel_url' => config('app.url'),
        ]);

        return QrCode::size(500)->generate($session->url);
    }
}
