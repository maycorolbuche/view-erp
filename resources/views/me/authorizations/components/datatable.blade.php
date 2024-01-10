<x-data-table data-origin="me-authorizations.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="id_authorization" order-dir="desc"
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
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Tipo',
            'data' => 'type',
        ],
        [
            'title' => 'Período',
            'data' => 'period',
            'className' => 'text-center',
        ],
        [
            'title' => 'Descrição',
            'data' => 'description',
        ],
        [
            'title' => 'Clientes',
            'data' => 'clients',
        ],
        [
            'title' => 'Autorizações',
            'data' => 'statuses',
        ],
        [
            'title' => 'Status',
            'data' => 'status',
        ],
    ]) }}" />
