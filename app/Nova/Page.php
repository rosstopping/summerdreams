<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Marshmallow\Tiptap\Tiptap;
use Whitecube\NovaFlexibleContent\Flexible;

class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Page>
     */
    public static $model = \App\Models\Page::class;

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
            Text::make('Title')->sortable(),
            Tiptap::make('Description')->buttons(config('app.tiptap_options'))->sortable(),
            Text::make('URL')->sortable(),
            Images::make('Header')->sortable()
                ->enableExistingMedia()
                ->withResponsiveImages(),
            Select::make('Template')->options([
                'home' => 'Home',
                'register' => 'Register',
                'register-no-button' => 'Register (Without Button)',
                'no-newsletter' => 'Without Newsletter',
                'ppc' => 'PPC Landing Page',
            ])->displayUsingLabels()->help('Used for custom page layouts. Leave blank for default template.'),

            Flexible::make('Content')
                ->fullWidth()
                ->button('Add content')
                ->addLayout('Text', 'text-content', [
                    Text::make('Eyebrow'),
                    Text::make('Title'),
                    Tiptap::make('Content')->buttons(config('app.tiptap_options')),
                ])
                ->addLayout('Text and Image', 'text-and-image', [
                    Text::make('Title'),
                    Tiptap::make('Content')->buttons(config('app.tiptap_options')),
                    Text::make('Button Text'),
                    Text::make('Button Link'),
                    Text::make('Button Two Text'),
                    Text::make('Button Two Link'),
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
                        ]),
                ])
                ->addLayout('Steps', 'steps', [
                    Flexible::make('Steps')
                        ->button('Add step')
                        ->addLayout('Step', 'step', [
                            Text::make('Name'),
                            Text::make('Title'),
                            Textarea::make('Description'),
                        ]),
                ])
                ->addLayout('Schedule', 'schedule', [
                    Flexible::make('Schedule')
                        ->button('Add schedule')
                        ->addLayout('Step', 'step', [
                            Text::make('Time'),
                            Text::make('Title'),
                            Image::make('Image'),
                            Select::make('Size')->options([
                                'single' => 'Single',
                                'double' => 'Double',
                            ]),
                        ]),
                ])
                ->addLayout('Marquee', 'marquee', [
                    Text::make('Text'),
                ])
                ->addLayout('Paralax Image', 'paralax-image', [
                    Image::make('Image'),
                ])
                ->addLayout('List Packages', 'list-packages')
                ->addLayout('List Events', 'list-events')
                ->addLayout('List Secret Packages', 'list-secret-packages')
                ->addLayout('List Secret Events', 'list-secret-events')
                ->addLayout('Reviews', 'reviews')
                ->addLayout('Features Grid', 'features-grid', [
                    Text::make('Button Text'),
                    Text::make('Button Link'),
                    Text::make('Tile 1 Title'),
                    Text::make('Tile 1 Description'),
                    Image::make('Tile 1 Image'),
                    Text::make('Tile 2 Title'),
                    Text::make('Tile 2 Description'),
                    Image::make('Tile 2 Image'),
                    Text::make('Tile 3 Title'),
                    Text::make('Tile 3 Description'),
                    Image::make('Tile 3 Image'),
                    Text::make('Tile 4 Title'),
                    Text::make('Tile 4 Description'),
                    Image::make('Tile 4 Image'),
                ])
                ->addLayout(\App\Nova\Flexible\Layouts\HeroSlider::class)
                ->addLayout(\App\Nova\Flexible\Layouts\HeroIntro::class)
                ->addLayout(\App\Nova\Flexible\Layouts\SlidingImages::class)
                ->addLayout('Spacer', 'spacer')
                ->addLayout('Contact Form', 'contact-form', [
                    Text::make('Name'),
                    Boolean::make('Large Form', 'large')->help('Toggle to make the form wider.'),
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
                                'select' => 'Select',
                            ]),
                            Text::make('Options (for Select type only)', 'options')->help('Comma separated values for select options. E.g., "Option 1,Option 2,Option 3"'),
                            Boolean::make('Required'),
                            Boolean::make('Full Width')->default(false),
                        ]),
                    Text::make('Button Text'),
                ])
                ->addLayout('FAQs', 'faqs'),
            // ->addLayout('Slider', 'slider', [
            //     Images::make('Images'),
            // ]),

            new Panel('SEO', [
                Text::make('Title', 'seo->title'),
                Textarea::make('Description', 'seo->description'),
            ]),

            new Panel('Meta', [
                Textarea::make('Head', 'meta->head')->help('Add tracking pixels or other code to the page head section.'),
            ]),
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
