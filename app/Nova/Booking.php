<?php

namespace App\Nova;

use App\Models\Event;
use App\Nova\Actions\BookingStatus;
use App\Nova\Actions\ExportBookingData;
use App\Nova\Actions\MakePaymentAction;
use App\Nova\Actions\SelectEventDatesAction;
use App\Nova\Actions\SendBookingConfirmationMailAction;
use App\Nova\Actions\SendBookingMailAction;
use App\Nova\Actions\SendBookingTextAction;
use App\Nova\Actions\SendCardSetupLinkAction;
use App\Nova\Filters\BookingStatusFilter;
use App\Nova\Filters\EventDateFilter;
use App\Nova\Filters\EventFilter;
use App\Nova\Lenses\EnquiriesAll;
use App\Nova\Lenses\EnquiriesInConversation;
use App\Nova\Lenses\EnquiriesNew;
use App\Nova\Lenses\EnquiriesNoReply;
use App\Nova\Lenses\EnquiriesPaying;
use App\Nova\Lenses\OnlineBookings;
use App\Nova\Lenses\ReferralBookings;
use App\Nova\Lenses\SellerBookings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\URL;

class Booking extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Booking>
     */
    public static $model = \App\Models\Booking::class;

    public static $perPageViaRelationship = 50;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'reference';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'reference', 'name', 'email', 'mobile'
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->orderBy('confirmed_at', 'DESC')
            ->when($request->user()->referral, fn ($query) => $query->where('referral_id', $request->user()->referral_id));
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $bookUrl = null;
        $checkoutUrl = null;

        if ($this->packages->count() > 0) $bookUrl = route('book.package', $this->packages->first());
        if ($this->events->count() > 0) $bookUrl = route('book.event', $this->events->first());

        if ($bookUrl) $bookUrl .= '?reference='.$this->getRawOriginal('reference');

        if ($this->dates && ($this->packages->count() > 0 || $this->events->count() > 0)) $checkoutUrl = route('checkout', $this->getRawOriginal('reference'));

        $fields = [
            // Hidden::make('confirmed_at')->withMeta(['value' => now()->toDateTimeString()])->showOnCreating(),
            Heading::make('<span style="color:red;">Please select preferred dates</span>')->canSee(fn () => !$this->dates)->asHtml()->onlyOnDetail(),
            Text::make('Site')->readonly(),
            Number::make('Guests')->rules('required'),
            Text::make('Name'),
            Text::make('Email'),
            Text::make('Mobile'),
            Date::make('Arrival Date')->rules('required')->filterable(),
            Text::make('Reference')->exceptOnForms(),
            Text::make('Amount', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->amountWithFee)->exceptOnForms(),
            Text::make('Deposit', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->deposit)->exceptOnForms(),
            Text::make('Paid', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->total_paid)->exceptOnForms(),
            Text::make('Balance', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->balance)->exceptOnForms(),
            Boolean::make('£1 Deposit', 'deposit_checkout')->help('Enable this to allow for £1 deposits (per guest). Full deposit will be taken 2 weeks after initial £1.'),
            Tag::make('Packages')->preload()->showCreateRelationButton(),
            Tag::make('Events')->preload()->showCreateRelationButton(),
            BelongsTo::make('Upgrade')->nullable()
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $booking = Booking::where('id', $request->resourceId)->first();
                    if ($booking) {
                        $package = $booking->packages()->first()?->id;
                        $event = $booking->events()->first()?->id;
                        if ($package) $query->where('package_id', $package);
                        if ($event) $query->where('event_id', $event);
                    }
                }),
            BelongsTo::make('Discount')->nullable(),
            Textarea::make('Notes')->alwaysShow(),
            BelongsTo::make('Referral')->nullable(),
            BelongsTo::make('Seller')->nullable(),
            Heading::make('Checkout Link: <a href="'.$checkoutUrl.'" target="_blank">'.$checkoutUrl.'</a>')->asHtml()->onlyOnDetail()->canSee(fn() => $checkoutUrl),
            DateTime::make('Enquired At')->exceptOnForms(),
            DateTime::make('Confirmed At')->sortable()->filterable()->exceptOnForms(),
            URL::make('Stripe Customer', function () {
                $customerId = $this->payments()->first()?->customer_id;
                return $customerId ? 'https://dashboard.stripe.com/customers/'.$customerId : null;
            })->exceptOnForms()->canSee(fn () => $this->payments()->whereNotNull('customer_id')->exists()),

            HasMany::make('Payments'),
            BelongsToMany::make('Extras', 'extras', Extra::class)->fields(function () {
                return [
                    Number::make('Quantity'),
                    Date::make('Date'),
                    Text::make('Deposit', fn ($bookingExtra) => '£' . $bookingExtra?->extra?->getDeposit($bookingExtra?->quantity))->exceptOnForms(),
                    Text::make('Amount', fn ($bookingExtra) => '£' . $bookingExtra?->extra?->getAmount($bookingExtra?->quantity))->exceptOnForms(),
                ];
            }),
            // Heading::make('Checkout Link: <a href="'.$bookUrl.'" target="_blank">'.$bookUrl.'</a>')->asHtml()->onlyOnDetail()->canSee(fn() => $bookUrl),
            // Heading::make('Checkout Link (VIP): <a href="'.$bookUrl.'&upgrade='.$this->packages->first()?->upgrade?->id.'" target="_blank">'.$bookUrl.'&upgrade='.$this->packages->first()?->upgrade?->id.'</a>')->asHtml()->onlyOnDetail()->canSee(fn() => $bookUrl && $this->packages->first()?->upgrade),
            // Heading::make('Checkout Link (VIP): <a href="'.$bookUrl.'&upgrade='.$this->events->first()?->upgrade?->id.'" target="_blank">'.$bookUrl.'&upgrade='.$this->events->first()?->upgrade?->id.'</a>')->asHtml()->onlyOnDetail()->canSee(fn() => $bookUrl && $this->events->first()?->upgrade),
        ];

        /**
         * Get event dates
         */
        $dates = data_get($this, 'dates', []);
        $dates = collect($dates)->sort();

        $events = [];

        foreach ($dates as $event => $date) {
            array_push($events, Text::make($event, fn() => Carbon::parse($date)->format('l jS F Y'))->onlyOnDetail());
        }

        if ($events) array_push($fields, new Panel('Event Dates', [...$events, KeyValue::make('Dates')->onlyOnForms()]));

        return $fields;
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            EventFilter::make(),
            EventDateFilter::make(),
            BookingStatusFilter::make(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [
            EnquiriesAll::make(),
            EnquiriesNew::make(),
            EnquiriesNoReply::make(),
            EnquiriesInConversation::make(),
            EnquiriesPaying::make(),
            OnlineBookings::make(),
            SellerBookings::make(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            BookingStatus::make()->canSee(fn ($request) => $request->user()->master),
            MakePaymentAction::make()
                ->confirmText('')
                ->confirmButtonText('Make Payment')
                ->cancelButtonText('Cancel')
                ->onlyOnDetail()
                ->canSee(fn ($request) => $request->user()->master),
            SendBookingConfirmationMailAction::make()->canSee(fn ($request) => $request->user()->master),
            (new SelectEventDatesAction($this))
                ->canSee(fn ($request) => $request->user()->master)
                ->onlyOnDetail()
                ->sole()
                ->showInline()
                ->confirmText('Please select your preferred event dates.')
                ->confirmButtonText('Confirm')
                ->cancelButtonText("Cancel"),
            SendBookingMailAction::make()->canSee(fn ($request) => $request->user()->master),
            SendBookingTextAction::make()->canSee(fn ($request) => $request->user()->master),
            // SendCardSetupLinkAction::make()->canSee(fn ($request) => $request->user()->master),
            // ExportBookingData::make()->withHeadings(),
            ExportAsCsv::make()
                ->canSee(fn ($request) => $request->user()->master)
                ->withFormat(function ($model) {
                
                    $fields = [
                        'Reference' => $model->reference,
                        'Group Size' => $model->guests,
                        'Name' => $model->name,
                        'Email' => $model->email,
                        'Mobile' => $model->mobile,
                        'Package' => $model->packages->pluck('name')->implode(', '),
                        'Event' => $model->events->pluck('name')->implode(', '),
                        'Upgrade' => $model->upgrade?->title,
                        'Amount Owed' => $model->balance,
                        'Arrival Date' => $model->arrival_date->format('l jS F Y'),
                        'Referral' => $model->referral?->name,
                        'Notes' => $model->notes,
                    ];

                    /**
                     * Add all events (for headers)
                     */
                    foreach (Event::all() as $event) {
                        $fields[$event->name] = '';
                    }

                    /**
                     * Get event dates
                     */
                    foreach (collect(data_get($model, 'dates', []))->sort() as $event => $date) {
                        $fields[$event] = Carbon::parse($date)->format('l jS F Y');
                    }

                    return $fields;
                })
                ->onlyOnIndex(),
        ];
    }
}
