<?php

namespace App\Nova\Flexible\Layouts;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Text;
use Manogi\Tiptap\Tiptap;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class SlidingImages extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'sliding-images';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Sliding Images';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make('Images', 'images')
                ->enableExistingMedia()
                ->withResponsiveImages()
        ];
    }

}
