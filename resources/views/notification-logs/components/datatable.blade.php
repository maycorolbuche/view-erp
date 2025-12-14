<x-data-table data-origin="notification-logs.datatable" query-string="route={{ $route }}"
    id-field="{{ $field ?? '' }}" order="sent_at" order-dir="desc"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_notification_log',
            'className' => 'text-right',
        ],
        [
            'title' => 'Destinatário',
            'data' => 'recipient',
        ],
        [
            'title' => 'Assunto',
            'data' => 'subject',
        ],
        [
            'title' => 'Data/Hora',
            'data' => 'sent_at',
        ],
        [
            'title' => 'Status',
            'data' => 'status',
        ],
    ]) }}" />
