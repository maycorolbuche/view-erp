<?php

namespace App\View\Components;

use Illuminate\Support\Str;

class Table extends BaseComponent
{
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $orderDir = 'asc',
        public int $order = 0,
        public int $limit = 50,
        string $id = '',
    ) {
        $this->id = $id ?: Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table');
    }
}
