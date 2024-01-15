<div class="table-responsive">
    <table id="{{ $id }}" class="table table-striped table-condensed table-hover display" cellspacing="0"
        width="100%">
        <thead>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#{{ $id }}').DataTable({
                serverSide: true,
                processing: true,
                ajax: '{{ $dataOrigin }}?id-field={{ $idField ?: '' }}&{!! $queryString ?: '' !!}',
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
            });
        });
    </script>
@endpush
