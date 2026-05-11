<x-data-table data-origin="task-logs.datatable" order="id_task_log" order-dir="desc"
    columns="{{ json_encode([
        [
            'title' => 'Código',
            'data' => 'id_task_log',
            'className' => 'text-right',
        ],
        [
            'title' => 'Chave',
            'data' => 'signature',
        ],
        [
            'title' => 'Descrição',
            'data' => 'description',
        ],
        [
            'title' => 'Detalhes',
            'data' => 'details',
        ],
        [
            'title' => 'Início',
            'data' => 'start_time',
        ],
        [
            'title' => 'Fim',
            'data' => 'end_time',
        ],
    ]) }}" />
