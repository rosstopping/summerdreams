<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HeroIntro extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'hero-intro';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Hero Intro';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Boolean::make('Show Logo', 'show_logo')
                ->help('Toggle to display the logo at the top of the hero section')
                ->default(false),
            Image::make('Background Image', 'background_image')
                ->help('The main background image for the hero section'),
            Text::make('Title Line 1', 'title_line_1')
                ->help('First line of the title (e.g., "THIS IS")')
                ->default('THIS IS'),
            Text::make('Title Line 2', 'title_line_2')
                ->help('Second line of the title (e.g., "ZANTE")')
                ->default('ZANTE'),
            Text::make('Events Section Title', 'events_title')
                ->help('Title for the events carousel section')
                ->default('The Events'),
            Flexible::make('Event Slides', 'event_slides')
                ->button('Add Event Slide')
                ->addLayout('Event Slide', 'event_slide', [
                    Text::make('Event Name', 'event_name'),
                    Image::make('Event Image', 'event_image'),
                    Text::make('Event URL', 'event_url')
                        ->help('URL to navigate to when the slide is clicked (optional)'),
                ]),
        ];
    }
}
