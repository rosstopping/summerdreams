<?php

namespace App\Nova;

use App\Nova\Repeater\PackageInclude;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Repeater;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Upgrade extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Upgrade>
     */
    public static $model = \App\Models\Upgrade::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title() {
        return $this->title . ' ('.data_get($this, 'package.name').data_get($this, 'event.name').')';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];
    
    /**
    * Return the location to redirect the user after creation.
    *
    * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
    * @param  \Laravel\Nova\Resource  $resource
    * @return \Laravel\Nova\URL|string
    */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.$request->viaResource.'/'.$request->viaResourceId;
    }
    
    /**
    * Return the location to redirect the user after update.
    *
    * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
    * @param  \Laravel\Nova\Resource  $resource
    * @return \Laravel\Nova\URL|string
    */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        if ($resource->package_id) return '/resources/packages/'.$resource->package_id;
        if ($resource->event_id) return '/resources/events/'.$resource->event_id;
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
            Text::make('Title')->rules('required')->sortable(),
            Currency::make('Amount')->rules('required')->sortable()->help('This amount will be added on top of the event or package amount.'),
            Currency::make('Deposit')->sortable()->help('This will override the event or package deposit.'),
            Repeater::make('Includes', 'includes')
                ->repeatables([
                    PackageInclude::make(),
                ]),
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
