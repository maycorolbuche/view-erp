<x-data-table data-origin="roles.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_role',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
    ]) }}" />
