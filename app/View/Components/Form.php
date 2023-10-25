<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $action, $actionName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $method = 'post',
        string $action = '',
        string $actionName = '',
    ) {
        if ($actionName) {
            $this->action = route($actionName);
        } else {
            $this->action = $action ?: url()->full();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form');
    }
}
