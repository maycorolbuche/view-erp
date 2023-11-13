<x-data-table data-origin="holidays.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="date" order-dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_holiday',
            'className' => 'text-right',
        ],
        [
            'title' => 'Data',
            'data' => 'date',
            'className' => 'text-center',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Recorrente?',
            'data' => 'repeat',
            'className' => 'text-center',
        ],
        [
            'title' => 'Filiais',
            'data' => 'branches',
            'orderable' => false,
        ],
    ]) }}" />
