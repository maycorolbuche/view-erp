<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class Input extends Component
{
    public string $name, $id, $field, $type, $class;
    public bool $required, $disabled, $readonly, $hidden;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $value = '',
        public int $width = 400,
        public string $label = '',
        string $type = '',
        string $required = 'false',
        string $disabled = 'false',
        string $readonly = 'false',
        string $hidden = 'false',
        public string $placeholder = '',
        string $name = '',
        string $id = '',
        string $field = '',
        string $class = '',
        public string $tip = '',
        public string $list = '[]',
        public string $listValue = '',
        public string $listText = '',
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

        $type = $type ?: 'text';
        if ($type == 'slug') {
            $type = 'text';
            $class .= ' slug ';
        } elseif ($type == 'cpf_cnpj') {
            $type = 'text';
            $class .= ' cpf_cnpj numeric ';
        } elseif ($type == 'numeric') {
            $type = 'text';
            $class .= ' numeric ';
        } elseif ($type == 'pis') {
            $type = 'text';
            $class .= ' pis numeric ';
        }

        $this->id = $id;
        $this->name = $name;
        $this->field = $field ?: $name;
        $this->type = $type;
        $this->class = $class;

        $this->required = $required && $required != "false";
        $this->disabled = $disabled && $disabled != "false";
        $this->readonly = $readonly && $readonly != "false";
        $this->hidden = $hidden && $hidden != "false";
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
            return view('components.input');
        }
    }
}
