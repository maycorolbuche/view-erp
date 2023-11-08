<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class Input extends Component
{
    public $value;
    public string $name, $id, $field, $type, $class, $rows;
    public bool $required, $disabled, $readonly, $hidden;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $value = '',
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
        string $rows = '',
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
        } elseif ($type == 'zip_code') {
            $type = 'text';
            $class .= ' zip_code numeric ';
        } elseif ($type == 'date') {
            if ($value <> "") {
                $value = date("Y-m-d", strtotime($value));
            }
        } elseif ($type == 'phone') {
            $type = 'text';
            $class .= ' phone ';
        }

        $this->id = $id;
        $this->name = $name;
        $this->field = $field ?: $name;
        $this->type = $type;
        $this->class = $class;
        $this->value = $value;
        $this->rows = $rows ?: 5;

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
