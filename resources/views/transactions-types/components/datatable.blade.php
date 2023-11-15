<x-data-table data-origin="transactions-types.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_transaction_type',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name_short_name',
        ],
    ]) }}" />
