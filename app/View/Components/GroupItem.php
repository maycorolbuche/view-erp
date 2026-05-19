<?php

namespace App\View\Components;

class GroupItem extends BaseComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public int $width = 400,
        public string $padding = '0',
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.group-item');
    }
}
