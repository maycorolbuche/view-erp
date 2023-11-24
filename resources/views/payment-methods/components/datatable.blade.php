<x-data-table data-origin="payment-methods.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_payment_method',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Rembolsável?',
            'data' => 'refundable',
            'className' => 'text-center',
        ],
    ]) }}" />
