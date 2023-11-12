<x-data-table data-origin="relationships-degrees.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_relationship_degree',
            'className' => 'text-right',
        ],
        [
            'title' => 'Descrição',
            'data' => 'name',
        ],
    ]) }}" />
