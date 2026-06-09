<?php

namespace App\View\Components;

use Illuminate\Support\Str;

class Input extends BaseComponent
{
    public $value;
    public string $name, $id, $field, $type, $class, $rows;
    public bool $required, $disabled, $readonly, $hidden, $multiple;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $value = '',
        public int $width = 400,
        public $min = '',
        public $max = '',
        public string $label = '',
        string $type = '',
        public string $pre_type = '',
        string $required = 'false',
        string $disabled = 'false',
        string $readonly = 'false',
        string $hidden = 'false',
        string $multiple = 'false',
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
        public string $accept = '',
        public string $onchange = '',
        public ?string $mask = null,
        public ?string $address = null,
        public ?string $district = null,
        public ?string $city = null,
        public ?string $state = null,
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

        $id = str_replace('[', '_', $id);
        $id = str_replace(']', '_', $id);

        $type = $type ?: 'text';
        $this->pre_type = $type;
        if ($type == 'slug') {
            $type = 'text';
            $class .= ' slug ';
        } elseif ($type == 'cpf') {
            $type = 'text';
            $mask = 'cpf';
        } elseif ($type == 'cnpj') {
            $type = 'text';
            $mask = 'cnpj';
        } elseif ($type == 'cpfcnpj') {
            $type = 'text';
            $mask = 'cpfcnpj';
        } elseif ($type == 'rg') {
            $type = 'text';
            $class .= ' rg ';
        } elseif ($type == 'number') {
            $type = 'text';
            $mask = 'number';
        } elseif ($type == 'pis') {
            $type = 'text';
            $mask = 'pis';
        } elseif ($type == 'zipcode') {
            $type = 'text';
            $mask = "zipcode";
        } elseif ($type == 'date') {
            if ($value <> "") {
                $value = date("Y-m-d", strtotime($value));
            }
        } elseif ($type == 'phone') {
            $type = 'text';
            $mask .= 'phone';
        } elseif ($type == 'money') {
            $type = 'text';
            $mask = 'money';
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
        $this->multiple = $multiple && $multiple != "false";
        $this->mask = $mask;

        $this->$address = $address;
        $this->$district = $district;
        $this->$city = $city;
        $this->$state = $state;
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
