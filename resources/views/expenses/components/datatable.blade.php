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
            'data' => 'category.name',
        ],
        [
            'title' => 'Clientes',
            'data' => 'clients',
            'orderable' => false,
        ],
        [
            'title' => 'Tipo de Pagamento',
            'data' => 'payment_method.name',
        ],
        [
            'title' => 'Valor',
            'data' => 'amount',
            'className' => 'text-right',
        ],
        [
            'title' => 'Reembolsável?',
            'data' => 'payment_method.refundable',
            'className' => 'text-center',
        ],
    ]) }}"
    created-row="if (data['refundable'] !== 1) { $('td', row).addClass('danger'); }" />
