<?php

namespace App\View\Components\Content;

use App\Models\Faq;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Faqs extends Content
{
    public $faqs;

    /**
     * Create a new component instance.
     */
    public function __construct(public $content)
    {
        $this->faqs = Faq::get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.faqs');
    }
}
