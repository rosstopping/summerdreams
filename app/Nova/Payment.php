<?php

namespace App\Nova;

use App\Nova\Actions\MarkAsHandedInAction;
use App\Nova\Filters\PaymentsSellerFilter;
use App\Nova\Lenses\FailedPayments;
use App\Nova\Lenses\ScheduledPayments;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Payment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Payment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/bookings/'.$resource->booking_id;
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/bookings/'.$resource->booking_id;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('Booking'),
            Text::make('Seller', fn () => data_get($this, 'booking.seller.name')),
            Boolean::make('Handed In', 'checked'),
            Text::make('Status', fn () => '<div class="inline-flex items-center whitespace-nowrap min-h-6 px-2 rounded-full uppercase text-xs font-bold bg-sky-100 text-sky-600">Draft</div>')->asHtml()->canSee(fn () => !$this->scheduled_at && !$this->confirmed_at),
            Text::make('Status', fn () => '<div class="inline-flex items-center whitespace-nowrap min-h-6 px-2 rounded-full uppercase text-xs font-bold bg-sky-100 text-sky-600">Scheduled</div>')->asHtml()->canSee(fn () => $this->scheduled_at && !$this->confirmed_at),
            Text::make('Status', fn () => '<div class="inline-flex items-center whitespace-nowrap min-h-6 px-2 rounded-full uppercase text-xs font-bold bg-green-100 text-green-600">Confirmed</div>')->asHtml()->canSee(fn () => $this->confirmed_at),
            Text::make('Name', fn() => data_get($this, 'booking.name')),
            Text::make('Mobile', fn() => data_get($this, 'booking.mobile')),
            Text::make('Email', fn() => data_get($this, 'booking.email')),
            Select::make('Cash/Card', 'method')->options([
                'cash' => 'Cash',
                'card' => 'Card',
            ])->displayUsingLabels()->filterable(),
            // Text::make('Method')->filterable()->displayUsing(fn ($value) => ucfirst($value)),
            Currency::make('Amount')->rules([
                'required',
                'numeric',
                'gt:0'
            ])->currency($this->currency)->sortable(),
            DateTime::make('Scheduled At')
                // ->default(now())
                // ->rules(['required'])
                ->sortable()
                ->help('Leave blank if you do not wish to schedule the payment'),
            DateTime::make('Failed At')->exceptOnForms(),
            DateTime::make('Confirmed At')->sortable()->filterable()->help('Only enter a date/time here if the payment has already been taken via Stripe')
        ];
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
            PaymentsSellerFilter::make()
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
            new FailedPayments,
            new ScheduledPayments,
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
            MarkAsHandedInAction::make()
                ->canRun(fn ($request) => $request->user()->master)
                ->canSee(fn ($request) => $request->user()->master),
        ];
    }
}
