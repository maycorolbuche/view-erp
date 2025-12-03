<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Form extends Component
{
    public $action, $actionName, $actionId, $actionPid, $method;
    public bool $files;

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
        string $files = 'false',
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

                $update_route = $actionName . '.update';
                $delete_route = $actionName . '.delete';

                if (Route::has($update_route)) {
                    $this->action = route($update_route, $params);
                } elseif (Route::has($delete_route)) {
                    $this->action = route($delete_route, $params);
                } else {
                    $this->action = '';
                }
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
        $this->files = $files && $files != "false";
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
