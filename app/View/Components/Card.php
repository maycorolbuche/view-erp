<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Card extends BaseComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $icon = '',
        public string $title = '',
        public bool $fullHeight = false,
    ) {
        $this->icon = $this->formatIcon($icon);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.card');
    }
}
