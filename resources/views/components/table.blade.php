<div class="table-responsive">
    <table id="{{ $id }}" class="table table-striped table-condensed table-hover" cellspacing="0" width="100%">
        {{ $slot }}
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let defs_num = [];
            let defs_orderable = [];
            $('#{{ $id }} thead th').each(function(index) {
                if ($(this).attr('type') == 'number') {
                    defs_num.push(index);
                }
                if ($(this).attr('orderable') == 'false') {
                    defs_orderable.push(index);
                }
            });


            $('#{{ $id }}').DataTable({
                order: [
                    [{{ $order }}, '{{ $orderDir }}']
                ],
                searching: false,
                lengthChange: false,
                language: {
                    url: '{{ asset('vendor/plugins/datatables/media/js/pt-BR.json') }}',
                },
                pageLength: {{ $limit }},
                paging: {{ $limit == 0 ? 'false' : 'true' }},
                columnDefs: [{
                        type: 'num',
                        targets: defs_num,
                    },
                    {
                        orderable: false,
                        targets: defs_orderable,
                    }
                ]
            });
        });
    </script>
@endpush
