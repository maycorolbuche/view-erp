<x-data-table data-origin="clients.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_client',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
    ]) }}" />
