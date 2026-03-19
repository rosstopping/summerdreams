<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Manogi\Tiptap\Tiptap;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Event>
     */
    public static $model = \App\Models\Event::class;

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
            Text::make('Calendar Book Link', 'calendar_book_link')->help('Link to use for booking this event from the calendar')->hideFromIndex(),
            Tiptap::make('Description')->buttons(config('app.tiptap_options'))->sortable(),
            Currency::make('Amount')->rules('required')->sortable(),
            Select::make('Currency')->options([
                'GBP' => 'GBP',
                'EUR' => 'EUR',
            ])->displayUsingLabels()->rules('required')->sortable(),
            Date::make('Start Date')->rules('required'),
            Date::make('End Date'),
            Select::make('Repeat')->options([
                'daily' => 'Every Day',
                'weekly' => 'Every Week',
                'monthly' => 'Every Month',
                'yearly' => 'Every Year',
            ])->placeholder('None')->displayUsingLabels(),
            Text::make('Exclude Days', 'repeat_exclude_days')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request->input($attribute) ? explode(',', str_replace(' ', '', $request->input($attribute))) : $request->input($attribute);
                })
                ->help('Comma seperated list of days to exclude'),
            Text::make('Exclude Dates', 'exclude_dates')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request->input($attribute) ? explode(',', str_replace(' ', '', $request->input($attribute))) : $request->input($attribute);
                })
                ->help('Comma seperated list of dates to exclude. Format: dd/mm/yyyy'),
            Text::make('Extra Dates', 'extra_dates')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request->input($attribute) ? explode(',', str_replace(' ', '', $request->input($attribute))) : $request->input($attribute);
                })
                ->help('Comma seperated list of dates to add extra. Format: dd/mm/yyyy'),
            Text::make('Sold Out Dates', 'sold_out_dates')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request->input($attribute) ? explode(',', str_replace(' ', '', $request->input($attribute))) : $request->input($attribute);
                })
                ->help('Comma seperated list of sold out dates. Format: dd/mm/yyyy'),
            Select::make('Duration', 'duration')->options([
                'all_day' => 'All Day',
                'daytime' => 'Daytime',
                'nighttime' => 'Nighttime',
            ])
                ->rules('required')
                ->displayUsingLabels()
                ->help('This will determine if multiple events can be booked on the same day.'),
            Boolean::make('Allow Same Day Bookings', 'allow_same_day')->help('Enable to allow event to be booked on arrival date'),
            Boolean::make('Hide From Events', 'hidden')->help('Enable this to hide the event from packages list'),
            Boolean::make('Hide From Calendar', 'hidden_from_calendar')->help('Enable this to hide the event from the calendar'),
            Boolean::make('Bookable', 'bookable')->help('Enable this to allow users to book this event individually'),
            Boolean::make('Seller Bookable', 'seller_bookable')->help('Enable this to allow sellers to book this event'),
            Boolean::make('Secret', 'secret')->help('Enable this to mark event as secret - will show in secret events list'),
            Images::make('Images')
                ->enableExistingMedia()
                ->withResponsiveImages(),
            BelongsToMany::make('Packages'),
            new Panel('SEO', [
                Text::make('Title', 'seo->title'),
                Textarea::make('Description', 'seo->description')
            ]),
            DateTime::make('Created At')->hideWhenCreating(),
            HasOne::make('Upgrade')
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
