@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>
        <x-panel title="Relatório por Clientes" type="primary">

            @include('layouts.partials.messages')

            <x-group>
                <x-input type="date" id="start_date" value="{{ $start_date }}" width="150" label="Data Inicial"
                    required />
                <x-input type="date" id="end_date" value="{{ $end_date }}" width="150" label="Data Final"
                    required />
            </x-group>

            <x-group right>
                <a type="button" class="btn btn-info" id="bt_filter"
                    onclick="open_url('{{ route('reports-users') }}',['start_date','end_date']);">
                    Exibir
                </a>
            </x-group>

            <hr>

            <x-title>Geral</x-title>

            <x-chart height="300px" seriesName="Valor"
                pointFormat="{series.name}: <b>{point.percentage:.1f}%</b> (R$ {point.y:.2f})"
                series="{{ json_encode($data['general_chart']) }}" />

            <div class="table-responsive">
                <table class="table table-hover" id="datatable">
                    <thead>
                        <th class='text-right'>Código</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($data['general'] as $expense)
                            <tr>
                                <td class='text-right'>{{ $expense->id_user }}</td>
                                <td>{{ $expense->user->name }}</td>
                                <td class='text-right'>{{ number_format($expense->amount, 2, ',', '.') }}</td>
                            </tr>
                            @php
                                $total += $expense->amount;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot style="background:#f9f9f9">
                        <tr>
                            <th colspan=2 class='text-right text-info'>Total</th>
                            <th class='text-right'>{{ number_format($total, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <hr>

            <x-title>Despesas por Usuários</x-title>

            <x-chart type="column" height="300px" seriesName="Valor"
                pointFormat="{series.name}: <b>{point.percentage:.1f}%</b> (R$ {point.y:.2f})"
                categories="{{ json_encode($data['users_chart_categories']) }}"
                series="{{ json_encode($data['users_chart']) }}" />

        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable').dataTable({
                order: [
                    [1, 'asc']
                ],
                searching: false,
                lengthChange: false,
                language: {
                    url: '{{ asset('vendor/plugins/datatables/media/js/pt-BR.json') }}',
                },
                pageLength: 5,
            });
        });
    </script>
@endpush
