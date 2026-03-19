<?php

namespace App\View\Components;

use App\Models\Review;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Reviews extends Component
{
    public $reviews;
    
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->reviews = Review::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reviews');
    }
}
