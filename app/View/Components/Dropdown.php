<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Dropdown extends BaseComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public ?string $icon = null,
        public ?string $avatar = null,
        public ?string $title = null,
        public ?string $subtitle = null,
        public ?string $headerTitle = null,
        public ?int $count = 0,
    ) {
        $this->id ??= $name ??= "__dropdown__" . uniqid();
        $this->name ??= $this->id;

        $this->icon = $this->formatIcon($icon);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown');
    }
}
