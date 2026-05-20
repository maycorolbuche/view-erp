<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class TitleBar extends BaseComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = '',
        public string $description = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.title-bar');
    }
}
