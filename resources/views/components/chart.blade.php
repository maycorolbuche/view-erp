<div id="{{ $id }}" style="width: 100%; height: 200px; margin: 0 auto"></div>

@push('scripts')
    <script>
        var highColors = [
            bgWarning, bgPrimary, bgInfo, bgAlert,
            bgDanger, bgSuccess, bgSystem, bgDark
        ];
        $('#{{ $id }}').highcharts({
            credits: false,
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: '{{ $type }}',
            },
            title: {
                text: null
            },
            tooltip: {
                pointFormat: '{!! $pointFormat !!}'
            },
            plotOptions: {
                pie: {
                    center: ['30%', '50%'],
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            colors: highColors,
            legend: {
                x: 90,
                floating: true,
                verticalAlign: "middle",
                layout: "vertical",
                itemMarginTop: 10
            },
            series: [{
                type: '{{ $type }}',
                name: '{{ $seriesName }}',
                data: {!! html_entity_decode($series) !!}
            }]
        });
    </script>
@endpush
