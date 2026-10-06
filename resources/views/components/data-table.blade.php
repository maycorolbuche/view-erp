<div>
    <div data-table-filter="{{ $id }}">{{ $slot }}</div>

    <div data-table-id="{{ $id }}" class="table-responsive">
        <table id="{{ $id }}" class="table table-striped table-condensed table-hover display" cellspacing="0"
            width="100%">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="text-right" style="margin-top: 10px; margin-bottom: 10px;">
        <button type="button" class="btn btn-sm btn-success" data-table-export="{{ $id }}">
            Exportar CSV
        </button>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentRequest_{{ $id }} = null;

            const table_{{ $id }} = $('#{{ $id }}')
                .on('preXhr.dt', function(e, settings, data) {
                    // Se já existe uma requisição em andamento, cancela
                    if (currentRequest_{{ $id }} &&
                        currentRequest_{{ $id }}.readyState !== 4) {
                        currentRequest_{{ $id }}.abort();
                    }
                }).DataTable({
                    serverSide: true,
                    processing: true,
                    @if ($searchable == 'no')
                        dom: 'lrtip',
                    @endif
                    ajax: {
                        url: '{{ $dataOrigin }}?id-field={{ $idField ?: '' }}&{!! $queryString ?: '' !!}',
                        data: function(d) {
                            $("[data-table-filter='{{ $id }}']")
                                .find(
                                    'input:not(.--filter-ignore):not([type=hidden]), select:not(.--filter-ignore)'
                                )
                                .each(function() {
                                    d[$(this).attr('name')] = $(this).val();
                                });
                        },
                        beforeSend: function(jqXHR) {
                            // Guarda a requisição atual
                            currentRequest_{{ $id }} = jqXHR;
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Ignora erro de abort
                            if (textStatus === 'abort') return;

                            console.error('Erro DataTable:', errorThrown);

                            new PNotify({
                                text: 'Ocorreu um erro ao carregar dados da grid.',
                                type: 'danger',
                                delay: 1400
                            });
                        }
                    },
                    columns: {!! html_entity_decode($columns) !!},
                    //pagingType: 'full_numbers',
                    // ordering: true,
                    order: {!! html_entity_decode($order) ?: '[]' !!},
                    language: {
                        url: '{{ asset('vendor/plugins/datatables/media/js/pt-BR.json') }}',
                    },
                    createdRow: function(row, data, index) {
                        {!! html_entity_decode($createdRow) !!}
                    },
                    drawCallback: function(settings) {
                        init_modals()
                    }
                });

            $("[data-table-filter='{{ $id }}']")
                .find('input:not(.--filter-ignore):not([type=hidden]), select:not(.--filter-ignore)')
                .change(function() {
                    table_{{ $id }}.draw();
                });

            $("[data-table-export='{{ $id }}']").click(function() {
                const rows = table_{{ $id }}.rows({
                    page: 'current'
                }).data().toArray();

                if (!rows.length) {
                    return;
                }

                const columns = {!! html_entity_decode($columns) !!}.filter(function(column) {
                    return column.data !== 'actions_search' && column.data !== 'actions' && column
                        .data !== 'checkbox';
                });

                const csv = [];

                // Cabeçalho
                csv.push(
                    columns.map(function(column) {
                        let title = column.title || column.data || '';

                        // Remove HTML do título
                        title = $('<div>').html(title).text();

                        return '"' + String(title).replace(/"/g, '""') + '"';
                    }).join(';')
                );

                // Dados
                rows.forEach(function(row) {
                    csv.push(
                        columns.map(function(column) {
                            let value = '';

                            if (column.data !== undefined && column.data !== null) {
                                value = row[column.data] ?? '';
                            }

                            // Remove HTML
                            value = $('<div>').html(value).text();

                            // Limpa espaços extras
                            value = String(value).trim();

                            // Escapa aspas para CSV
                            value = value.replace(/"/g, '""');

                            return '"' + value + '"';
                        }).join(';')
                    );
                });

                const blob = new Blob(
                    ['\uFEFF' + csv.join('\r\n')], {
                        type: 'text/csv;charset=utf-8;'
                    }
                );

                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');

                link.href = url;
                link.download = 'export.csv';

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                URL.revokeObjectURL(url);
            });
        });
    </script>
@endpush
