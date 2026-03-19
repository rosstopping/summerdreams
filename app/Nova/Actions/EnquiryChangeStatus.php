<?php

namespace App\Nova\Actions;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class EnquiryChangeStatus extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Update Status';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->enquiry_status = $fields->status;
            $model->notes = $fields->notes;
            $model->paying_at = $fields->date_paying;
            $model->save();
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
        return [
            Select::make('Status')->options([
                'no-reply' => 'No Reply',
                'in-conversation' => 'In Conversation',
                'paying' => 'Paying',
            ])->displayUsingLabels()->rules('required'),

            DependencyContainer::make([
                DateTime::make('Date Paying')
            ])->dependsOn('status', 'paying'),

            Textarea::make('Notes')
        ];
    }
}
