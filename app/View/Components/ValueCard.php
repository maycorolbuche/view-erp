<?php

namespace App\View\Components;

class ValueCard extends Card
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $icon = '',
        string $title = '',
        public string $info = '',
        public string $infoValue = '',
        public string $infoIcon = '',
    ) {
        parent::__construct($icon, $title);
        $this->infoIcon = $this->formatIcon($infoIcon);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cards.value-card');
    }
}
