@php
    $datatableConfig = [
        'id' => $id,
        'searchable' => $searchable !== 'no',
        'ajax' => [
            'url' => $dataOrigin . '?id-field=' . ($idField ?: '') . '&' . ($queryString ?: ''),
        ],
        'columns' => json_decode(html_entity_decode($columns), true),
        'order' => json_decode(html_entity_decode($order ?: '[]'), true),
    ];
@endphp

<div>
    <div data-table-filter="{{ $id }}">
        {{ $slot }}
    </div>
    <div data-table-id="{{ $id }}" class="table-responsive">
        <table id="{{ $id }}" class="table table-striped table-condensed table-hover display" width="100%"
            data-datatable data-config='@json($datatableConfig)'>
            <thead></thead>
            <tbody></tbody>
        </table>
    </div>
</div>
