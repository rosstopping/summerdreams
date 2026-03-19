<?php

namespace App\Nova\Repeater;

use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Repeater\Repeatable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Manogi\Tiptap\Tiptap;

class TextAndImage extends Repeatable
{
    /**
     * Get the fields displayed by the repeatable.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
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
