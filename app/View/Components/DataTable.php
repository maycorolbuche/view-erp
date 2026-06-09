<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class DataTable extends BaseComponent
{
    public string $id, $dataOrigin, $order;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $columns,
        public string $createdRow = '',
        public string $queryString = '',
        public string $idField = '',
        public string $searchable = '',
        string $order = '',
        string $orderDir = '',
        string $id = '',
        string $dataOrigin = '',
        string $pid = '',
    ) {
        if ($dataOrigin) {
            if ($pid <> "") {
                $this->dataOrigin = route($dataOrigin, compact('pid'));
            } else {
                $this->dataOrigin = route($dataOrigin);
            }
        }

        $this->id = $id ?: uniqid("table__");

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
     */
    public function render(): View|Closure|string
    {
        return view('components.data-table');
    }
}
