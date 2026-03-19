<?php

namespace App\Nova\Lenses;

use App\Models\Booking;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class OnlineBookings extends Lens
{
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'reference', 'name', 'email', 'mobile'
    ];

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->whereDoesntHave('seller')->orderBy('confirmed_at', 'DESC')
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
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
            Tag::make('Packages')->preload()->showCreateRelationButton(),
            Tag::make('Events')->preload()->showCreateRelationButton(),
            BelongsTo::make('Discount')->nullable(),
            Textarea::make('Notes')->alwaysShow(),
            BelongsTo::make('Referral')->nullable(),
            BelongsTo::make('Seller')->nullable(),
            DateTime::make('Enquired At')->exceptOnForms(),
            DateTime::make('Confirmed At')->sortable()->filterable()->exceptOnForms(),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'online-bookings';
    }
}
