<div id="{{ $id }}" style="width: 100%; height: {{ $height }}; margin: 0 auto"></div>

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
                },
                column: {
                    stacking: 'normal'
                }
            },
            colors: highColors,
            legend: {
                @if ($type == 'pie')
                    x: 90,
                    floating: true,
                    verticalAlign: "middle",
                    layout: "vertical",
                    itemMarginTop: 10
                @endif
            },

            @if ($type == 'column')
                xAxis: {
                    categories: {!! html_entity_decode($categories) !!},
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: '{{ $seriesName }}'
                    }
                },
            @endif

            @if ($type == 'column')
                series: {!! html_entity_decode($series) !!},
            @else
                series: [{
                    type: '{{ $type }}',
                    name: '{{ $seriesName }}',
                    data: {!! html_entity_decode($series) !!}
                }],
            @endif
        });
    </script>
@endpush
