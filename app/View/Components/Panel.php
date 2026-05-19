<?php

namespace App\View\Components;

class Panel extends BaseComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title = '',
        public string $badge = '',
        public string $type = '',
        public string $height = '',
        public string $bodyHeight = '',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.panel');
    }
}
