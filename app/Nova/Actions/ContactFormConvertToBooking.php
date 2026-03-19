<?php

namespace App\Nova\Actions;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class ContactFormConvertToBooking extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Convert to Booking';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $contact_forms)
    {
        $package = Package::findOrFail($fields->package_id);

        foreach ($contact_forms as $contact_form) {
            $booking = new Booking();
            $booking->guests = data_get($contact_form->data, 'guests', 1);
            $booking->name = $contact_form->name;
            $booking->email = $contact_form->email;
            $booking->mobile = data_get($contact_form->data, 'mobile', null);
            $booking->arrival_date = data_get($contact_form->data, 'arrival_date', null);
            $booking->save();

            $contact_form->booking_id = $booking->id;
            $contact_form->save();

            $booking->packages()->attach($package);

            if (!$booking->arrival_date) {
                $start_date = $package->events->pluck('start_date')->sort()->first()->subDays(7);

                if ($start_date < today()) $start_date = today();

                $booking->arrival_date = $start_date;
                $booking->save();
            }

            if ($booking->arrival_date) {
                /**
                 * Store the selected dates
                 */
                $dates = $booking
                    ->availableEventDates()
                    ->groupBy('name')
                    ->transform(function($dates, $name) {
                        return (string) $dates->first()['date'];
                    })
                    ->sort();

                $booking->dates = $dates;
                $booking->save();
            }
        }

        if ($contact_forms->count() === 1) return Action::redirect('/admin/resources/bookings/'.$booking->id);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Package', 'package_id')
                ->options(
                    Package::where('available', true)->get()->pluck('name', 'id')->toArray()
                )
                ->rules('required')
        ];
    }
}
