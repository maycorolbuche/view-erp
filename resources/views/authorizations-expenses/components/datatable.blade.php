<x-data-table data-origin="authorizations-expenses.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="name"
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
            'title' => 'Descrição',
            'data' => 'description',
        ],
    ]) }}" />
