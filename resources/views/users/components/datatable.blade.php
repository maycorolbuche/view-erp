<x-data-table data-origin="users.datatable" query-string="route={{ $route }}" id-field="{{ $field ?? '' }}"
    order="name"
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
            'title' => 'E-mail',
            'data' => 'email',
        ],
        [
            'title' => 'Filial',
            'data' => 'branch',
        ],
    ]) }}"
    created-row="if (data['root'] == 1) { $('td', row).addClass('warning'); }" />
