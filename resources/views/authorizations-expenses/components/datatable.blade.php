<x-data-table data-origin="authorizations-expenses.datatable" query-string="route={{ $route }}"
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
            'title' => 'Data Inicial',
            'data' => 'start_date',
            'className' => 'text-center',
        ],
        [
            'title' => 'Data Final',
            'data' => 'end_date',
            'className' => 'text-center',
        ],
        [
            'title' => 'Descrição',
            'data' => 'description',
        ],
        [
            'title' => 'Clientes',
            'data' => 'clients',
            'orderable' => false,
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
