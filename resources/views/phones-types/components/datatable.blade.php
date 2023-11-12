<x-data-table data-origin="phones-types.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="description"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_phone_type',
            'className' => 'text-right',
        ],
        [
            'title' => 'Descrição',
            'data' => 'description',
        ],
    ]) }}" />
