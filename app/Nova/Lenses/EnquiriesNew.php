<?php

namespace App\Nova\Lenses;

use App\Models\Booking;
use App\Models\Event;
use App\Nova\Actions\EnquiryChangeStatus;
use App\Nova\Actions\SendBookingMailAction;
use App\Nova\Actions\SendBookingTextAction;
use Carbon\Carbon;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class EnquiriesNew extends Lens
{
    public $name = 'New Enquiries';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'email', 'mobile'
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
            $query->enquiry()->whereNull('enquiry_status')->orderBy('enquired_at', 'DESC')
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
            Badge::make('Status', 'enquiry_status')->map([
                '' => 'info',
                'new' => 'info',
                'no-reply' => 'danger',
                'in-conversation' => 'warning',
                'paying' => 'success',
            ]),
            Text::make('Site')->readonly(),
            Number::make('Guests')->rules('required'),
            Text::make('Name'),
            Text::make('Email'),
            Text::make('Mobile'),
            Date::make('Arrival Date')->rules('required')->filterable(),
            Text::make('Reference')->exceptOnForms(),Text::make('Amount', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->amountWithFee)->exceptOnForms(),
            Text::make('Deposit', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->deposit)->exceptOnForms(),
            Text::make('Paid', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->total_paid)->exceptOnForms(),
            Text::make('Balance', fn () => ($this->currency === 'gbp' ? '£' : '€'). $this->balance)->exceptOnForms(),
            Boolean::make('£1 Deposit', 'deposit_checkout')->help('Enable this to allow for £1 deposits (per guest). Full deposit will be taken 2 weeks after initial £1.'),
            Tag::make('Packages')->preload()->showCreateRelationButton(),
            Tag::make('Events')->preload()->showCreateRelationButton(),
            BelongsTo::make('Discount')->nullable(),
            Textarea::make('Notes')->alwaysShow(),
            BelongsTo::make('Referral')->nullable(),
            BelongsTo::make('Seller')->nullable(),
            DateTime::make('Enquired At')->exceptOnForms(),
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
        return [
            EnquiryChangeStatus::make(),
            SendBookingMailAction::make()->canSee(fn ($request) => $request->user()->master),
            SendBookingTextAction::make()->canSee(fn ($request) => $request->user()->master),
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

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'enquiries-new';
    }
}
