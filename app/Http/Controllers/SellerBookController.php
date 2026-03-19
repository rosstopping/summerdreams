<?php

namespace App\Http\Controllers;

use App\Jobs\MailchimpJob;
use App\Mail\BookingConfirmationMail;
use App\Mail\SellerBookingConfirmationMail;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SellerBookController extends Controller
{
    public function __invoke(Seller $seller, $event, $date, $payment_method, $currency)
    {

        seo()->title('Your Booking | VVIP Events Zante | '.setting('year'));

        $event = Event::findOrFail($event);
        
        return view('seller.book', compact('seller', 'event', 'date', 'payment_method', 'currency'));
    }

    public function book(Seller $seller, $event, $date, $payment_method, $currency, Request $request)
    {
        $event = Event::findOrFail($event);

        seo()->title('Your Booking | VVIP Events Zante | '.setting('year'));

        $request->validate([
            'guests' => 'required|integer|min:1',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required'
        ]);

        $booking = new Booking;

        $booking->site = config('app.name');
        $booking->guests = $request->guests;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->mobile = $request->mobile;
        $booking->arrival_date = $date;
        $booking->seller_id = $seller->id;

        $booking->dates = [
            $event->name => $date . ' 00:00:00'
        ];

        $booking->save();
        $booking->refresh();

        $booking->events()->attach($event);

        /**
         * Add email to mailchimp
         */
        if (config('app.env') === 'production' && $booking->email) {
            MailchimpJob::dispatch($booking->email);
        }

        /**
         * If cash was selected, confirm and redirect to success
         */
        if ($payment_method === 'cash') {

            $booking->confirmed_at = now();
            $booking->save();

            $booking->payments()->create([
                'confirmed_at' => now(),
                'currency' => $currency,
                'method' => 'cash',
                'amount' => $booking->deposit ? $booking->deposit : $booking->amount,
                'checked' => false
            ]);

            Mail::queue(new SellerBookingConfirmationMail($booking));
            
            return redirect()->route('book.success', ['reference' => $booking->reference]);
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
         * Build items
         */
        $name = $booking->events->pluck('name')->implode(', ');

        /**
         * Calculate amount
         */
        $amount = $booking->deposit ? round($booking->deposit * 100) : round($booking->amount * 100);

        $line_items = [
            [
                'price_data' => [
                    'currency' => 'gbp',
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
        if (setting('booking_fee')) {
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
            'cancel_url' => route('seller.book', [$seller, $event, $date, $payment_method, $currency]),
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
