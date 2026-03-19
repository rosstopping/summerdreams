<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Setting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Setting';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // ID::make()->sortable(),

            Text::make('Name')->sortable(),

            Select::make('Field')->options([
                'text' => 'Text',
                'textarea' => 'Textarea',
                // 'wysiwyg' => 'WYSIWYG',
                // 'image' => 'Image',
                // 'file' => 'File',
            ])->displayUsingLabels()->sortable()->rules(['required']),

            Text::make('Key')->rules(['required'])->sortable(),

            Text::make('Value')->onlyOnDetail(),

            Text::make('Value')
                ->hideFromDetail()
                ->hide()
                ->dependsOn('field', function ($field, NovaRequest $request, $formData) {
                    return $formData->field === 'text' ? $field->show() : $field->hide();
                }),

            Textarea::make('Value')
                ->hideFromDetail()
                ->hide()
                ->dependsOn('field', function ($field, NovaRequest $request, $formData) {
                    return $formData->field === 'textarea' ? $field->show() : $field->hide();
                }),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
