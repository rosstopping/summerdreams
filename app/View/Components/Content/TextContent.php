<?php

namespace App\View\Components\Content;

use Closure;
use Illuminate\Contracts\View\View;

class TextContent extends Content
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.text-content');
    }
}
