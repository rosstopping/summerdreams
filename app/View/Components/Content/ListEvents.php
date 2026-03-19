<?php

namespace App\View\Components\Content;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListEvents extends Content
{
    public $events;

    /**
     * Create a new component instance.
     */
    public function __construct(public $content)
    {
        $this->events = Event::where('bookable', true)->where('hidden', false)->orderBy('created_at')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.list-events');
    }
}
