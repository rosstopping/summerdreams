<?php

namespace App\Nova\Filters;

use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class EventDateFilter extends DateFilter
{
    public $name = 'Event Date';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        /**
         * Get filters
         */
        $filters = collect(json_decode(base64_decode($request->filters)));

        /**
         * Check for EventFilter
         */
        $filterEvents = $filters
            ->filter(fn ($filter) => data_get($filter, 'App\Nova\Filters\EventFilter'))
            ->first();

        $event = data_get($filterEvents, 'App\Nova\Filters\EventFilter');

        $value = Carbon::parse($value);

        if ($event) return $query->where('dates->'.$event, $value);

        return $query->where('dates', 'LIKE', '%'.$value.'%');
    }
}
