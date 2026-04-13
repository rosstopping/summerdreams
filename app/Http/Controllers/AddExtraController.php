<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;

class AddExtraController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Extra $extra, Request $request)
    {
        $booking = session('booking');

        /**
         * Get the amount
         */
        $amount = $extra->getDeposit($request->quantity);

        /**
         * Store the session ID so we can confirm the booking later
         */
        $payment = $booking->payments()->create([
            'amount' => $amount,
            'extra_data' => [
                'id' => $extra->id,
                'quantity' => $request->quantity,
                'date' => $request->date,
            ]
        ]);

        $payment->reference = $payment->generateReference();
        $payment->save();

        /**
         * Setup stripe payment
         */
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_sd'));

        /**
         * Create the stripe user
         */
        $customer = $stripe->customers->create([
            'name' => data_get($booking, 'name'),
            'email' => data_get($booking, 'email')
        ]);

        $line_items = [
            [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => $extra->name,
                    ],
                    'unit_amount' => $amount * 100,
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
           'success_url' => route('book.success', ['reference' => $payment->reference]),
           'cancel_url' => route('book'),
       ]);

       /**
        * Redirect to checkout
        */
       return redirect($session->url);
    }
}
