<x-data-table data-origin="authorizations-types.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_authorization_type',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Qtd. Aprovações',
            'data' => 'approval',
            'className' => 'text-center',
        ],
    ]) }}" />
