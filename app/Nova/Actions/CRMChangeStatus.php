<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class CRMChangeStatus extends Action
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
            $crm = $model->crm;
            if (!$crm) {
                $crm = [];
            }
            $crm['status'] = $fields->status;
            $crm['notes'] = $fields->notes;
            $model->crm = $crm;
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
                'new' => 'New',
                'no-reply' => 'No Reply',
                'in-conversation' => 'In Conversation',
                'paying' => 'Paying',
            ])->displayUsingLabels()->rules('required'),

            Textarea::make('Notes', 'crm.notes')
        ];
    }
}
