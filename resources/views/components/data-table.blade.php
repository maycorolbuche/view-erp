<table id="{{ $id }}" class="table table-striped table-hover display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>id_system</th>
            <th>slug</th>
            <th>name</th>
            <th>icon</th>
            <th>root</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#{{ $id }}').DataTable({
            serverSide: true,
            processing: true,
            ajax: '{{ $dataOrigin }}',
            columns: [{
                    data: 'id_system'
                },
                {
                    data: 'slug'
                },
                {
                    data: 'name'
                },
                {
                    data: 'icon'
                },
                {
                    data: 'action'
                },
            ]
        });
    });
</script>
