<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class Input extends Component
{
    public string $name, $id;
    public bool $required, $disabled, $readonly, $hidden;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $type = 'text',
        public $value = '',
        public int $width = 400,
        public string $label = '',
        string $required = 'false',
        string $disabled = 'false',
        string $readonly = 'false',
        string $hidden = 'false',
        public string $placeholder = '',
        string $name = '',
        string $id = '',
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

        $this->id = $id;
        $this->name = $name;

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
