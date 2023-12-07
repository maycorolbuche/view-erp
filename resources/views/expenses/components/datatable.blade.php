<x-data-table data-origin="expenses.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="date" order-dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_expense',
            'className' => 'text-right',
        ],
        [
            'title' => 'Data',
            'data' => 'date',
            'className' => 'text-center',
        ],
        [
            'title' => 'Tipo de Despesa',
            'data' => 'category',
        ],
        [
            'title' => 'Tipo de Pagamento',
            'data' => 'payment_method',
        ],
        [
            'title' => 'Valor',
            'data' => 'amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Anotações',
            'data' => 'notes',
        ],
        [
            'title' => 'Reembolsável?',
            'data' => 'refundable',
            'className' => 'text-center',
        ],
    ]) }}"
    created-row="if (data['refundable'].indexOf('danger') !== -1) { $('td', row).addClass('danger'); }"  />
