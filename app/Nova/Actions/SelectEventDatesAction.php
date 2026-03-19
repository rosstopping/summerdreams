<?php

namespace App\Nova\Actions;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class SelectEventDatesAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Select Event Dates';

    public function __construct(public $booking)
    {
        //
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $booking = $models->first();

        $dates = $booking
            ->availableEventDates()
            ->groupBy('name')
            ->transform(function($dates, $name) use ($fields) {
                return $fields->{Str::of($name)->lower()->replace(' ', '_')};
            })
            ->sort();

        $booking->dates = $dates;
        $booking->save();
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $events = $this->booking?->events->merge($this->booking?->packages->pluck('events')->flatten());
        $options = [];

        foreach (Event::get() as $event) {
            $select_options = [];
            if ($events->contains('name', $event->name)) {
                $select_options = $event?->dates()->mapWithKeys(function($date) {
                    return [
                        (string) $date => $date->format('jS F Y')
                    ];
                });
            }
            array_push($options,
                Select::make($event->name)
                    ->options($select_options)
            );
        }

        return $options;
    }
}
