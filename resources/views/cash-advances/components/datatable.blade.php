<x-data-table data-origin="cash-advances.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="user_cash.amount" order_dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_user',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Saldo de Adiantamento',
            'data' => 'user_cash.amount',
            'className' => 'text-right',
        ],
    ]) }}" />
