<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class ActionCheckbox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $element = '',
        public string $callback = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.action-checkbox');
    }
}
