<x-data-table data-origin="me-batches.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="id_batch" order-dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_batch',
            'className' => 'text-right',
        ],
        [
            'title' => 'Data/Hora',
            'data' => 'created_at',
            'className' => 'text-center',
        ],
        [
            'title' => 'Qtd. Despesas',
            'data' => 'expenses_count',
            'className' => 'text-right',
        ],
        [
            'title' => 'Vl. Reembolsável',
            'data' => 'refundable_amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Vl. Não Reembolsável',
            'data' => 'non_refundable_amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Vl. Total',
            'data' => 'amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Status',
            'data' => 'active',
            'className' => 'text-center',
        ],
    ]) }}" />
