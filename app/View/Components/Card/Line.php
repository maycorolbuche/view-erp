<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Components\Card;

class Line extends Card
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $icon = '',
        string $title = '',
        public string $infoValue = '',
        public string $infoIcon = '',
    ) {
        parent::__construct($icon, $title);
        $this->infoIcon = $this->formatIcon($infoIcon);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.line');
    }
}
