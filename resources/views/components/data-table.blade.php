<div>
    <div data-table-filter="{{ $id }}">{{ $slot }}</div>

    <div class="table-responsive">
        <table id="{{ $id }}" class="table table-striped table-condensed table-hover display" cellspacing="0"
            width="100%">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            const table_{{ $id }} = $('#{{ $id }}').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ $dataOrigin }}?id-field={{ $idField ?: '' }}&{!! $queryString ?: '' !!}',
                    data: function(d) {
                        $("[data-table-filter='{{ $id }}']")
                            .find('input, select')
                            .each(function() {
                                d[$(this).attr('name')] = $(this).val();
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

            $("[data-table-filter='{{ $id }}']").find("input, select").change(function() {
                table_{{ $id }}.draw();
            });
        });
    </script>
@endpush
