<x-data-table data-origin="categories.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_category',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Nome Abreviado',
            'data' => 'short_name',
        ],
        [
            'title' => 'Tipo',
            'data' => 'category_type',
        ],
    ]) }}" />
