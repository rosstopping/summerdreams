<?php

namespace App\Nova\Flexible\Layouts;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Text;
use Marshmallow\Tiptap\Tiptap;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HeroSlider extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'hero-slider';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Hero Slider';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title', 'title'),
            Tiptap::make('Description', 'description')->buttons(config('app.tiptap_options')),
            Text::make('Button Text', 'button_text'),
            Text::make('Video', 'video'),
            Images::make('Images', 'images')
                ->enableExistingMedia()
                ->withResponsiveImages(),
        ];
    }
}
