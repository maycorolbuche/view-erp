<x-data-table data-origin="branches.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_branch',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
    ]) }}" />
