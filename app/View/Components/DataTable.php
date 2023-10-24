<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class DataTable extends Component
{
    public $id, $dataOrigin;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $id = '',
        string $dataOrigin = '',
    ) {
        if ($dataOrigin) {
            $this->dataOrigin = route($dataOrigin, ['system' => request('__system')['slug']]);
        }

        $this->id = $id ?: Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table');
    }
}
