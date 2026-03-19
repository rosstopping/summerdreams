<?php

namespace App\View\Components\Content;

use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListSecretPackages extends Content
{
    public $packages;

    /**
     * Create a new component instance.
     */
    public function __construct(public $content)
    {
        $this->packages = Package::where('available', true)->where('secret', true)->orderBy('created_at')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.list-secret-packages');
    }
}
