<x-data-table data-origin="authorizations-cash-advances.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="start_date" order-dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_authorization',
            'className' => 'text-right',
        ],
        [
            'title' => 'Data',
            'data' => 'start_date',
            'className' => 'text-center',
        ],
        [
            'title' => 'Valor',
            'data' => 'amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Descrição',
            'data' => 'description',
        ],
        [
            'title' => 'Autorizações',
            'data' => 'statuses',
            'orderable' => false,
        ],
        [
            'title' => 'Status',
            'data' => 'approved',
        ],
    ]) }}" />
