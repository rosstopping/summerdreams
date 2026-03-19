<?php

namespace App\Nova;

use App\Nova\Repeater\PackageInclude;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Repeater;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Package extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Package>
     */
    public static $model = \App\Models\Package::class;

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
        'id',
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
            Text::make('Name')->rules('required')->sortable(),
            Textarea::make('Description'),
            Currency::make('Amount')->sortable(),
            Currency::make('Deposit')->sortable(),
            Select::make('Currency')->options([
                'GBP' => 'GBP',
                'EUR' => 'EUR',
            ])->displayUsingLabels()->rules('required')->sortable(),
            // Currency::make('Discount')->exceptOnForms(),
            Tag::make('Events')->rules('required')->preload()->withPreview()->showCreateRelationButton(),
            Repeater::make('Includes', 'includes')
                ->repeatables([
                    PackageInclude::make(),
                ]),
            Boolean::make('Popular')->help('Enable this to package as "Most Popular" on booking page.'),
            Boolean::make('Featured')->help('Enable this to mark package as featured on booking page.'),
            Boolean::make('Bookable')->help('Enable this option to allow customers to book & pay directly.'),
            Boolean::make('Available')->help('If disabled, package will be removed from the website.'),
            Boolean::make('Secret', 'secret')->help('Enable this to mark package as secret - will show in secret packages list'),
            DateTime::make('Created At')->hideWhenCreating(),
            HasOne::make('Upgrade'),
            HasMany::make('Seasonal Pricings', 'seasonalPricings', SeasonalPricing::class),
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
