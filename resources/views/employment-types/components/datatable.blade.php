<x-data-table data-origin="employment-types.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="description"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_employment_type',
            'className' => 'text-right',
        ],
        [
            'title' => 'Descrição',
            'data' => 'description',
        ],
    ]) }}" />
