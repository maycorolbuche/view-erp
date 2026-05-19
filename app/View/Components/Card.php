<?php

namespace App\View\Components;

class Card extends BaseComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $icon = '',
        public string $title = '',
    ) {
        $this->icon = $this->formatIcon($icon);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cards.card');
    }
}
