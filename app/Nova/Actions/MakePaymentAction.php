<?php

namespace App\Nova\Actions;

use App\Actions\MakePayment;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;

class MakePaymentAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Make Payment';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $bookings)
    {
        $booking = $bookings->first();

        if ($fields->method === 'cash') {
            $booking->payments()->create([
                'confirmed_at' => now(),
                'currency' => $fields->currency,
                'method' => 'cash',
                'amount' => $fields->amount
            ]);

            return ActionResponse::message('Payment confirmed');
        }

        if ($fields->method === 'stripe') {
            $booking->payments()->create([
                'confirmed_at' => now(),
                'currency' => 'gbp',
                'method' => 'card',
                'amount' => $fields->amount
            ]);

            return ActionResponse::message('Payment added, please process manually in Stripe Dashboard');
        }

        if ($fields->method === 'card') {

            return ActionResponse::redirect(route('qrcode-checkout', [$booking, $fields->amount]));
        }
        
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        if ($request->resourceId) {
            $booking = Booking::find($request->resourceId);
        }
        else {
            if (is_array($request->resources)) $booking = Booking::find($request->resources[0]);
            if (!is_array($request->resources)) $booking = Booking::find($request->resources);
        }

        return [
            Select::make('Payment')
                ->default('Full Balance')
                ->options([
                    'Full Balance' => 'Full Balance',
                    'Number of guests' => 'Number of guests',
                    'Custom Amount' => 'Custom Amount',
                ]),
            Number::make('Guests', 'guests')
                ->hide()
                ->default($booking->guests)
                ->min(1)
                ->max($booking->guests)
                ->step(1)
                ->dependsOn(
                    ['payment'],
                    function (Number $field, NovaRequest $request, FormData $formData) use ($booking) {
                        if ($formData->payment === 'Number of guests') $field->show()->rules('required');
                    }
                ),
            Number::make('Amount', 'amount')
                ->default($booking?->balanceWithoutFormatting)
                ->placeholder('00.00')
                ->step(0.01)
                ->rules(['required'])
                ->dependsOn(
                    ['payment', 'guests'],
                    function (Number $field, NovaRequest $request, FormData $formData) use ($booking) {
                        if ($formData->payment === 'Full Balance') $field->default($booking->balanceWithoutFormatting);
                        if ($formData->payment === 'Number of guests') $field->default(number_format(($booking->balanceWithoutFormatting / $booking->guests) * $formData->guests, 2));
                    }
                ),
            Select::make('Method')->default('card')->options([
                'cash' => 'Cash',
                'card' => 'Card',
                'stripe' => 'Stripe (Manual)',
            ])->displayUsingLabels(),
            Select::make('Currency')->default('gbp')->options([
                    'gbp' => 'GBP',
                    'eur' => 'EUR',
                ])
                ->displayUsingLabels()
                ->hide()
                ->dependsOn(
                    ['method'],
                    function (Select $field, NovaRequest $request, FormData $formData) use ($booking) {
                        if ($formData->method === 'cash') $field->show();
                    }
                ),
        ];
    }
}
