<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $action, $actionName, $actionId, $actionPid, $method;

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
        string $actionPid = '',
    ) {
        if ($action) {
            $this->action = $action ?: url()->full();
        } elseif ($actionName) {
            if ($actionId) {
                $method = 'put';
                $params = ['id' => $actionId];
                if ($actionPid) {
                    $params['pid'] = $actionPid;
                }
                $this->action = route($actionName . '.update', $params);
            } else {
                $params = [];
                if ($actionPid) {
                    $params['pid'] = $actionPid;
                }
                $this->action = route($actionName . '.store', $params);
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
