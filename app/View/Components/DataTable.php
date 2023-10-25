<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class DataTable extends Component
{
    public $id, $dataOrigin, $order;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $columns,
        string $order = '',
        string $orderDir = '',
        string $id = '',
        string $dataOrigin = '',
    ) {
        if ($dataOrigin) {
            $this->dataOrigin = route($dataOrigin);
        }

        $this->id = $id ?: Str::random(8);

        $_columns = json_decode(html_entity_decode($columns));
        if ($order <> "") {
            $_order = json_decode(html_entity_decode($order));
            if (!$_order) {
                $_order = [[$order, $orderDir ?: "asc"]];
            }
            foreach ($_order as &$item) {
                $posicao = array_search($item[0], array_column($_columns, 'data'));
                if ($posicao !== false) {
                    $item[0] = $posicao;
                } else {
                    $item[0] = 0;
                }
            }
            $order = json_encode($_order);
        }

        $this->order = $order;
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
