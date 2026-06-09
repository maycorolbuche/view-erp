<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Components\BaseComponent;

class Item extends BaseComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $icon = null,
        public ?string $title = null,
        public ?string $subtitle = null,
        public ?string $href = null,
        public ?int $count = 0,
        public ?string $type = null,
    ) {
        $this->icon = $this->formatIcon($icon);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.item');
    }
}
