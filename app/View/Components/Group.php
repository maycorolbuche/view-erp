<?php

namespace App\View\Components;

class Group extends BaseComponent
{
    public bool $right;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $right = 'false',
        public string $title = '',
        public string $type = '',
    ) {
        $this->right = $right && $right != "false";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.group');
    }
}
