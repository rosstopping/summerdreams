<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class BookingStatusFilter extends Filter
{
    public $name = 'Booking Status';

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
        // dd($value);
        return $query
            ->when($value === 'confirmed', fn ($query) => $query->confirmed())
            ->when($value === 'enquiry', fn ($query) => $query->enquiry())
            ->when($value === 'incomplete', fn ($query) => $query->incomplete());
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            'Confirmed' => 'confirmed',
            'Enquiry' => 'enquiry',
            'Incomplete' => 'incomplete',
        ];
    }

    public function default()
    {
        return 'confirmed';
    }
}
