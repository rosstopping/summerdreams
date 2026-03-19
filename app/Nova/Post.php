<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Manogi\Tiptap\Tiptap;
use Whitecube\NovaFlexibleContent\Flexible;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Post>
     */
    public static $model = \App\Models\Post::class;

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Title')->sortable(),
            Text::make('Slug'),
            Textarea::make('Excerpt')->sortable(),
            Images::make('Featured Image')
                ->enableExistingMedia()
                ->withResponsiveImages(),

            Flexible::make('Content', 'flexible_content')
                ->fullWidth()
                ->button('Add content')
                ->addLayout('Text', 'text-content', [
                    Text::make('Eyebrow'),
                    Text::make('Title'),
                    Tiptap::make('Content')->buttons(config('app.tiptap_options'))
                ])
                ->addLayout('Text and Image', 'text-and-image', [
                    Text::make('Title'),
                    Tiptap::make('Content')->buttons(config('app.tiptap_options')),
                    Text::make('Button Text'),
                    Text::make('Button Link'),
                    Image::make('Image'),
                ])
                ->addLayout('Text and Image (Reversed)', 'text-and-image-reversed', [
                    Text::make('Title'),
                    Tiptap::make('Content')->buttons(config('app.tiptap_options')),
                    Text::make('Button Text'),
                    Text::make('Button Link'),
                    Image::make('Image'),
                ])
                ->addLayout('Cards', 'cards', [
                    Flexible::make('Cards')
                        ->button('Add card')
                        ->addLayout('Card', 'card', [
                            Text::make('Title'),
                            Tiptap::make('Content')->buttons(config('app.tiptap_options')),
                            Text::make('Button Text'),
                            Text::make('Button Link'),
                            Image::make('Image'),
                        ])
                ])
                ->addLayout('Spacer', 'spacer')
                ->addLayout('Paralax Image', 'paralax-image', [
                    Image::make('Image'),
                ]),
            
            Tiptap::make('Content')->buttons(config('app.tiptap_options')),

            new Panel('SEO', [
                Text::make('Title', 'seo->title'),
                Textarea::make('Description', 'seo->description')
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
