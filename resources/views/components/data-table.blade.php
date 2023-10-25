<div class="table-responsive">
    <table id="{{ $id }}" class="table table-striped table-condensed table-hover display" cellspacing="0"
        width="100%">
        <thead>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#{{ $id }}').DataTable({
            serverSide: true,
            processing: true,
            ajax: '{{ $dataOrigin }}',
            columns: {!! html_entity_decode($columns) !!},
            //pagingType: 'full_numbers',
            // ordering: true,
            order: {!! html_entity_decode($order) ?: '[]' !!},
            language: {
                url: '{{ asset('vendor/plugins/datatables/media/js/pt-BR.json') }}',
            },
            //
        });
    });
</script>
