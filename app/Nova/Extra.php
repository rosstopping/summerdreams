<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Manogi\Tiptap\Tiptap;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;

class Extra extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Extra>
     */
    public static $model = \App\Models\Extra::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name')
                ->rules('required')
                ->sortable(),
            Tiptap::make('Description')->buttons(config('app.tiptap_options')),
            Image::make('Image')
                ->hideFromDetail()
                ->hideFromIndex(),
            Select::make('Pricing', 'amount_type')
                ->rules('required')
                ->options([
                    'per_guest' => 'Per Guest',
                    'per_group_size' => 'Per Group Size',
                    'fixed' => 'Fixed Price',
                ])
                ->displayUsingLabels()
                ->onlyOnForms(),
            Currency::make('Deposit')->onlyOnForms(),
            Currency::make('Amount')->onlyOnForms(),
            SimpleRepeatable::make('Group Prices', 'group_prices', [
                Number::make('Quantity'),
                Currency::make('Deposit'),
                Currency::make('Amount'),
            ])->hideFromDetail(),
            Boolean::make('Date Required')
                ->hideFromIndex()
                ->help('Tick this if you require the customer to select a date')
                ->hideFromDetail(),
            BelongsToMany::make('Bookings'),
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
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
