<x-data-table data-origin="systems.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="name"
    columns="{{ json_encode([
        [
            'data' => 'actions',
            'width' => '20px',
            'orderable' => false,
        ],
        [
            'title' => 'Código',
            'data' => 'id_system',
            'className' => 'text-right',
        ],
        [
            'title' => 'Nome',
            'data' => 'name',
        ],
        [
            'title' => 'Ícone',
            'data' => 'icon',
            'className' => 'text-center',
        ],
        [
            'title' => 'Nome URL',
            'data' => 'slug',
        ],
    ]) }}"
    created-row="if (data['root'] == 1) { $('td', row).addClass('warning'); }" />
