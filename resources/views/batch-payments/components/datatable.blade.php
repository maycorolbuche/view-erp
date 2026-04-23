<x-data-table data-origin="batch-payments.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="id_batch" order-dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Lote',
            'data' => 'id_batch',
            'className' => 'text-right',
        ],
        [
            'title' => 'Data Lote',
            'data' => 'created_at',
            'className' => 'text-center',
        ],
        [
            'title' => 'Data Conferência',
            'data' => 'revised_at',
            'className' => 'text-center',
        ],
        [
            'title' => 'Data p/ Pgto.',
            'data' => 'estimated_payment_date',
            'className' => 'text-center',
        ],
        [
            'title' => 'Nome',
            'data' => 'user.name',
        ],
        [
            'title' => 'Vl. Reemb.',
            'data' => 'refundable_amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Vl. Não Reemb.',
            'data' => 'non_refundable_amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Vl. Total',
            'data' => 'amount',
            'className' => 'text-right',
        ],
    ]) }}" />
