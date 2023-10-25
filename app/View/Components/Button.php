<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class Button extends Component
{
    public $name, $id, $route, $routeName, $type, $value, $label, $layout, $confirm, $confirmTitle;
    public bool $disabled, $hidden, $novalidate;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $type = '',
        string $value = '',
        string $label = '',
        string $disabled = 'false',
        string $hidden = 'false',
        string $novalidate = 'false',
        string $name = '',
        string $id = '',
        string $route = '',
        string $routeName = '',
        string $layout = '',
        string $confirm = '',
        string $confirmTitle = '',
    ) {
        if ($name == '') {
            $name = $id;
        } elseif ($id == '') {
            $id = $name;
        }

        if ($name == '') {
            $id = Str::random(8);
            $name = $id;
        }

        if ($routeName) {
            $this->route = route($routeName);
        } else {
            $this->route = $route;
        }

        $type = $type ?: 'button';
        switch ($type) {
            case 'store':
                $label = $label ?: 'Cadastrar';
                $value = $value ?: 'store';
                $layout = $layout ?: 'info';
                $type = "submit";
                break;
            case 'store-new':
                $label = $label ?: 'Cadastrar como Novo';
                $value = $value ?: 'store';
                $layout = $layout ?: 'info';
                $type = "submit";
                break;
            case 'update':
                $label = $label ?: 'Salvar';
                $value = $value ?: 'update';
                $layout = $layout ?: 'success';
                $type = "submit";
                break;
            case 'destroy':
            case 'delete':
                $label = $label ?: 'Excluir';
                $value = $value ?: 'destroy';
                $layout = $layout ?: 'danger';
                $type = "submit";
                $novalidate = 1;
                $confirm = "Deseja realmente excluir este registro?";
                break;
            case 'cancel':
                $label = $label ?: 'Cancelar';
                $layout = $layout ?: 'warning';
                $type = "button";
                $novalidate = 1;
                break;
        }

        $this->id = $id;
        $this->name = $name;

        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->layout = $layout ?: 'primary';
        $this->confirm = $confirm;
        $this->confirmTitle = $confirmTitle;

        $this->disabled = $disabled && $disabled != "false";
        $this->hidden = $hidden && $hidden != "false";
        $this->novalidate = $novalidate && $novalidate != "false";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->hidden) {
            return '';
        } else {
            return view('components.button');
        }
    }
}
