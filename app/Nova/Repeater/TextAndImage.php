<?php

namespace App\Nova\Repeater;

use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Repeater\Repeatable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Marshmallow\Tiptap\Tiptap;

class TextAndImage extends Repeatable
{
    /**
     * Get the fields displayed by the repeatable.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Title'),
            Tiptap::make('Content')->buttons(config('app.tiptap_options')),
            Image::make('Image'),
        ];
    }
}
