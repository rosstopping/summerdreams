<?php

namespace App\Http\Controllers;

use App\Jobs\MailchimpJob;
use App\Mail\BookingEnquiryCustomerMail;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Package;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Mail\BookingEnquiryMail;
use App\Models\Discount;
use App\Models\Upgrade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use MailchimpMarketing\ApiClient;
use GoogleTagManager;

class BookController extends Controller
{
    public function __invoke()
    {
        $page = Page::whereSlug(request()->path())->first();

        seo()->title(data_get($page, 'seo.title', 'Book | Summer Dreams | '.setting('year')));
        seo()->description(data_get($page, 'seo.description'));

        return view('book.index');
    }

    public function bookPackage(Package $package)
    {

        seo()->title('Your Booking | Summer Dreams | '.setting('year'));

        $page = Page::whereSlug(request()->path())->first();

        seo()->title(data_get($page, 'seo.title', 'Book | Summer Dreams | '.setting('year')));
        seo()->description(data_get($page, 'seo.description'));

        $start_date = $package->events->pluck('start_date')->sort()->first()->subDays(7);

        if ($start_date < today()) $start_date = today();

        return view('book.package', compact('package', 'start_date'));
    }

    public function bookEvent(Event $event)
    {
        /**
         * Abort if the event isn't bookable
         */
        abort_if(!$event->bookable, 404);

        seo()->title('Your Booking | Summer Dreams | '.setting('year'));

        $page = Page::whereSlug(request()->path())->first();

        seo()->title(data_get($page, 'seo.title', 'Book | Summer Dreams | '.setting('year')));
        seo()->description(data_get($page, 'seo.description'));

        $start_date = $event->start_date;

        if ($start_date < today()) $start_date = today();

        return view('book.event', compact('event', 'start_date'));
    }

    public function submit($eventOrPackage, Request $request)
    {

        seo()->title('Your Booking | Summer Dreams | '.setting('year'));

        $request->validate([
            'type' => ['required', Rule::in(['event', 'package'])],
            'guests' => 'required|integer|min:1',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'arrival_date' => 'required',
        ]);

        $booking = $request->has('reference') ? Booking::whereReference($request->get('reference'))->first() : new Booking;

        if (!$booking) $booking = new Booking;

        $booking->site = config('app.name');
        $booking->guests = $request->guests;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->mobile = $request->mobile;
        $booking->arrival_date = $request->arrival_date;

        $booking->save();
        $booking->refresh();

        /**
         * Remove any events or packages
         */
        $booking->events()->detach();
        $booking->packages()->detach();

        if ($request->type === 'event') $booking->events()->attach(Event::findOrFail($eventOrPackage));
        if ($request->type === 'package') $booking->packages()->attach(Package::findOrFail($eventOrPackage));

        /**
         * Check for upgrade
         */
        if ($request->filled('upgrade')) {
            $upgrade = Upgrade::findOrFail($request->get('upgrade'));
            $booking->upgrade_id = $upgrade->id;
            $booking->save();
        }

        /**
         * Check for referral
         */
        if ($referral = $request->session()->get('referral')) {
            $booking->referral_id = $referral->id;
            $booking->save();
        }
        
        /**
         * Check for discount
         */
        if ($request->filled('discount')) {
            /**
             * Check discount exists
             */
            $discount = Discount::where('code', $request->discount)->first();
            if (!$discount) return back()->withErrors('Discount code does not exist.');

            /**
             * Check discount can be used on this event
             */
            if ($request->type === 'event') {
                if (!$discount->events()->where('id', $eventOrPackage)->first()) return back()->withErrors('Discount code cannot be used on this event.');
            }

            /**
             * Check discount can be used on this package
             */
            if ($request->type === 'package') {
                if (!$discount->packages()->where('id', $eventOrPackage)->first()) return back()->withErrors('Discount code cannot be used on this package.');
            }

            /**
             * Apply the discount
             */
            $booking->discount_id = $discount->id;
            $booking->save();
        }

        /**
         * Add email to mailchimp
         */
        if (config('app.env') === 'production' && $booking->email) {
            MailchimpJob::dispatch($booking->email);
        }

        /**
         * Booking Name
         */
        $name = $booking->packages->pluck('name')->implode(', ') . $booking->events->pluck('name')->implode(', ');
        if ($booking->upgrade) $name .= ' + '.$booking->upgrade->title;

        $request->session()->put('booking', $booking);

        $dates = $booking->availableEventDates()->groupBy('name');

        dd($dates);

        $select_options = $booking->selectDateOptions();

        $page = Page::whereSlug(request()->path())->first();

        seo()->title(data_get($page, 'seo.title'));
        seo()->description(data_get($page, 'seo.description'));

        return view('book.checkout', compact('booking', 'dates', 'select_options', 'name'));
    }

    public function checkout(Request $request)
    {
        /**
         * Get the booking
         */
        $booking = $request->session()->get('booking');

        /**
         * Store the selected dates
         */
        $dates = $booking
            ->availableEventDates()
            ->groupBy('name')
            ->transform(function($dates, $name) use ($request) {
                if ($dates->count() > 1) return $request->{Str::of($name)->slug()};
                if ($dates->count() === 1) return (string) $dates->first()['date'];
            })
            ->sort();

        $booking->dates = $dates;
        $booking->save();

        $booking->enquired_at = now();
        $booking->save();

        // fire off enquire mail
        Mail::queue(new BookingEnquiryMail($booking));

        /**
         * If package isn't bookable, redirect to success
         */
        if ($booking->packages()->first() && !$booking->packages()->first()->bookable) {
            // fire off mail to book
            Mail::queue(new BookingEnquiryCustomerMail($booking));
            
            // Store booking data for tracking
            $request->session()->put('booking_enquiry_submission', [
                'email' => $booking->email,
                'phone' => $booking->mobile
            ]);
            
            return redirect()->to('book/success/enquiry');
        };

        /**
         * Redirect to checkout
         */
        return redirect()->route('checkout', $booking->getRawOriginal('reference'));
    }

    public function success(Request $request)
    {

        $page = Page::whereSlug(request()->path())->first();

        seo()->title(data_get($page, 'seo.title'));
        seo()->description(data_get($page, 'seo.description'));

        if ($request->has('reference')) {
            $booking = Booking::where('reference', Str::of($request->reference)->after('SD'))->first();

            if ($booking) {
                $products = collect();

                $name = $booking->packages->pluck('name')->implode(', ') . $booking->events->pluck('name')->implode(', ');
                
                if ($booking->upgrade) $name .= ' + '.$booking->upgrade->title;

                $products->push([
                    'item_name' => $name,
                    'item_list_name' => $name,
                    'price' => $booking->amount,
                    'quantity' => 1,
                ]);
                
                GoogleTagManager::set('event', 'purchase');
                GoogleTagManager::set('ecommerce.transaction_id', $booking->reference);
                GoogleTagManager::set('ecommerce.affiliation', config('app.name'));
                GoogleTagManager::set('ecommerce.value', $booking->amount_with_fee);
                GoogleTagManager::set('ecommerce.currency', 'GBP');
                // GoogleTagManager::set('ecommerce.promotion_id', $active_booking->discounts->first()?->code);
                // GoogleTagManager::set('ecommerce.promotion_name', $active_booking->discounts->first()?->description);
                GoogleTagManager::set('ecommerce.items', $products);
            }
        }
        
        return view('book.success', compact('request'));
    }

    public function paymentSuccess(Request $request)
    {

        $page = Page::whereSlug(request()->path())->first();

        seo()->title(data_get($page, 'seo.title'));
        seo()->description(data_get($page, 'seo.description'));
        
        return view('book.payment-success', compact('request'));
    }

    public function cancel()
    {
        return redirect('book');
    }
}
