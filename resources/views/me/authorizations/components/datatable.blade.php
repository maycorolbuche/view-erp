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
            'data' => 'user.name',
        ],
        [
            'title' => 'Tipo',
            'data' => 'authorization_type.name',
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
