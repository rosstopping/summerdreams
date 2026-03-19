<?php

namespace App\Nova\Actions;

use App\Models\Booking;
use App\Models\Event;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportBookingData extends Export implements WithMapping
{
    public function name()
    {
        return 'Export Booking Data';
    }

    /**
     * @param  Booking  $booking
     */
    public function map($model): array
    {
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
    }
}
