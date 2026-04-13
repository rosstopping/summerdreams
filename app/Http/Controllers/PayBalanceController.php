<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PayBalanceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $booking = session('booking');

        $booking = Booking::findOrFail($booking->id);

        if ($booking->balancing_payment_amount_without_formatting == 0) {
            return redirect()->route('account')->with('error', 'There was an error with the balance payment. Please contact us.');
        }

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
         * Calculate amount
         */ 
        $amount = $booking->balancing_payment_amount_without_formatting;

        $amount = round($amount * 100);

        $line_items = [
            [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Balance Payment',
                    ],
                    'unit_amount' => $amount,
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
            'success_url' => route('balance-success', ['reference' => $booking->reference]),
            'cancel_url' => route('account'),
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

    public function success(Request $request)
    {
        $booking = null;
        $stripeTransactionId = null;
        
        if ($request->has('reference')) {
            $booking = Booking::where('reference', \Illuminate\Support\Str::of($request->reference)->after('SD'))->first();
            
            if ($booking && $booking->session_id) {
                try {
                    $stripe = new \Stripe\StripeClient(config('services.stripe.secret_sd'));
                    $session = $stripe->checkout->sessions->retrieve($booking->session_id, []);
                    $stripeTransactionId = $session->payment_intent;
                } catch (\Exception $e) {
                    // If unable to retrieve session, continue without transaction ID
                }
            }
        }
        
        return view('account.balance-success', compact('request', 'booking', 'stripeTransactionId'));
    }
}
