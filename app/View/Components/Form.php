<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $action, $actionName, $actionId, $method;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = 'post',
        string $action = '',
        string $actionName = '',
        string $actionId = '',
    ) {
        if ($actionName) {
            if ($actionId) {
                $method = 'put';
                $this->action = route($actionName . '.update', ['id' => $actionId]);
            } else {
                $this->action = route($actionName . '.store');
            }
        } else {
            $this->action = $action ?: url()->full();
        }

        $this->method = $method;
        $this->actionId = $actionId;
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
