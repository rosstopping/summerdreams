<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Marshmallow\Tiptap\Tiptap;
use Whitecube\NovaFlexibleContent\Flexible;

class Popup extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Popup>
     */
    public static $model = \App\Models\Popup::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Title'),
            Tiptap::make('Content')->buttons(config('app.tiptap_options'))->sortable(),
            Flexible::make('Content', 'flexible_content')
                ->fullWidth()
                ->button('Add content')
                ->addLayout('Text Content', 'text-content', [
                    Text::make('Subtitle'),
                    Text::make('Title'),
                    Text::make('Title End'),
                    Tiptap::make('Description')->buttons(config('app.tiptap_options')),
                    Text::make('Button Text'),
                    Text::make('Button Url'),
                    Select::make('Align')->options([
                        'centered' => 'Centered',
                        'left' => 'Left',
                        'right' => 'Right',
                    ])->displayUsingLabels(),
                ])
                ->addLayout('Contact Form', 'contact-form', [
                    Text::make('Name'),
                    Flexible::make('Fields')
                        ->button('Add field')
                        ->addLayout('Field', 'field', [
                            Text::make('Name'),
                            Select::make('Type')->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'email' => 'Email',
                                'number' => 'Number',
                                'mobile' => 'mobile',
                                'date' => 'Date',
                                'file' => 'File',
                                'boolean' => 'Boolean',
                            ]),
                            Boolean::make('Required'),
                            Boolean::make('Full Width'),
                        ]),
                    Text::make('Button Text'),
                ]),
            Images::make('Image')->sortable()
                ->enableExistingMedia()
                ->withResponsiveImages(),
            Text::make('Button Text'),
            Text::make('Button Url'),
            Text::make('Pages', 'pages')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request->input($attribute) ? explode(',', str_replace(' ', '', $request->input($attribute))) : $request->input($attribute);
                })
                ->help('Comma seperated list of urls. Leave blank to show on every page.'),
            Number::make('Delay', 'data->delay')->help('Number of seconds to delay popup.'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
