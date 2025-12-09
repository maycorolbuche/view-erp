@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))

            @php
                $status_label = $data->active
                    ? "<code class='mr10 bg-success dark p3 ph5'>Ativo</code>"
                    : "<code class='mr10 bg-danger dark p3 ph5'>Fechado</code>";
            @endphp


            <x-panel title="Detalhes do Lote &nbsp; {!! $status_label !!}"
                type="{{ $data->active ? 'success' : 'danger' }}">

                @include('layouts.partials.messages')

                <x-group>
                    <x-card width="150" type="alert" value="{{ $data->id_batch }}" label="Código do Lote" />
                    <x-card width="150" type="warning" value="{{ $data->expenses_count }}" label="Qtd. Despesas" />
                </x-group>
                <x-group>
                    <x-card type="info" value="R$ {{ number_format($data->amount, 2, ',', '.') }}"
                        label="Valor do Lote" />
                    <x-card type="danger" value="R$ {{ number_format($data->non_refundable_amount, 2, ',', '.') }}"
                        label="(-) Vl. não Reembolsável" />
                    <x-card type="danger" value="R$ {{ number_format($data->discount, 2, ',', '.') }}"
                        label="(-) Vl. Desconto" />
                    <x-card type="success" value="R$ {{ number_format($data->refund_amount, 2, ',', '.') }}"
                        label="(=) Valor do Reembolso" />
                </x-group>
                @if (!$data->active)
                    <x-panel title="Dados do Pagamento" type="warning">
                        <x-group>
                            <x-card type="danger" value="R$ {{ number_format($data->user_cash, 2, ',', '.') }}"
                                label="(-) Adiantamento Utilizado" />
                            <x-card type="success" value="R$ {{ number_format($data->amount_paid, 2, ',', '.') }}"
                                label="(=) Valor Pago" />
                            <x-card type="info" value="{{ \Carbon\Carbon::parse($data->payment_date)->format('d/m/Y') }}"
                                label="Dt. Pagamento" />
                        </x-group>
                    </x-panel>
                @endif

                <x-title>Resumo das Despesas</x-title>

                <x-group>
                    <x-group-item width="250" padding="3px">
                        <x-panel title="Por Categoria" height="100%" body-height="calc(100% - 40px)">
                            <x-chart seriesName="Valor"
                                pointFormat="{series.name}: <b>{point.percentage:.1f}%</b> (R$ {point.y:.2f})"
                                series="{{ json_encode($chart_categories) }}" />
                        </x-panel>
                    </x-group-item>
                    <x-group-item width="250" padding="3px">
                        <x-panel title="Por Cliente" height="100%" body-height="calc(100% - 40px)">
                            <x-chart seriesName="Valor"
                                pointFormat="{series.name}: <b>{point.percentage:.1f}%</b> (R$ {point.y:.2f})"
                                series="{{ json_encode($chart_clients) }}" />
                        </x-panel>
                    </x-group-item>
                </x-group>

                <br>

                <x-title>Despesas do Lote</x-title>

                <x-table order=1 limit=0>
                    <thead>
                        <th type='number' class='text-right'>Código</th>
                        <th type='date'>Data</th>
                        <th>Tipo de Despesa</th>
                        <th>Clientes</th>
                        <th>Tipo de Pagamento</th>
                        <th type='currency' class='text-right'>Valor</th>
                        <th type='currency' class='text-center'>Reembolsável?</th>
                        <th orderable="false"></th>
                        <th orderable="false"></th>
                    </thead>
                    <tbody>
                        @foreach ($data->expenses as $expense)
                            <tr class="{{ !$expense->payment_method->refundable ? 'danger' : '' }}">
                                <td class='text-right'>{{ $expense->id_expense }}</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                                <td>{{ $expense->category->name }}</td>
                                <td>
                                    @foreach ($expense->clients as $client)
                                        <span class='label label-info' data-toggle="tooltip" data-placement="right"
                                            title="{{ number_format($client->pivot->percentage, 2, ',', '.') }}% | R$ {{ number_format($client->pivot->amount, 2, ',', '.') }}">
                                            {{ $client->short_name }}
                                        </span>&nbsp;
                                    @endforeach
                                </td>
                                <td>{{ $expense->payment_method->name }}</td>
                                <td class='text-right'>{{ number_format($expense->amount, 2, ',', '.') }}</td>
                                <td class='text-center'>
                                    {!! $expense->payment_method->refundable
                                        ? "<span class='badge badge-info'>Reembolsável</span>"
                                        : "<span class='badge badge-danger'>Não Reembolsável</span>" !!}
                                </td>
                                <td class="text-right">
                                    @foreach ($expense->users as $user)
                                        @if ($user->id_user != $expense->id_user)
                                            <span class='label label-warning' data-toggle="tooltip" data-placement="left"
                                                title="{{ number_format($user->pivot->percentage, 2, ',', '.') }}% | R$ {{ number_format($user->pivot->amount, 2, ',', '.') }}">
                                                {{ $user->name }}
                                            </span>&nbsp;
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-right">
                                    @if (trim($expense->notes) != '')
                                        <button type="button" class="btn btn-info btn-sm fs12" data-container="body"
                                            data-toggle="popover" data-placement="left"
                                            data-content="{{ $expense->notes }}">
                                            <i class="glyphicons glyphicons-notes"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>


                <br>

                <x-title>Descontos do Lote</x-title>
                <x-table order=1 limit=0>
                    <thead>
                        <th type='number' class='text-right'>Código</th>
                        <th type='currency' class='text-right'>Valor da Despesa</th>
                        <th type='currency' class='text-right'>Valor do Desconto</th>
                        <th type='number' class='text-right'>Cód. Despesa</th>
                        <th>Motivo</th>
                    </thead>
                    <tbody>
                        @foreach ($data->discounts as $discount)
                            @if ($discount->pivot->amount > 0)
                                <tr>
                                    <td class='text-right'>{{ $discount->pivot->id_batch_discount }}</td>
                                    <td class='text-right'>
                                        {{ number_format($discount->pivot->expense_amount, 2, ',', '.') }}
                                    </td>
                                    <td class='text-right'>
                                        {{ number_format($discount->pivot->amount, 2, ',', '.') }}
                                    </td>
                                    <td class='text-right'>{{ $discount->pivot->id_expense }}</td>
                                    <td>{{ $discount->name }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </x-table>


                <br>

                <x-group right>
                    <div style="padding: 0 5px 0 5px;">
                        <a class="btn btn-primary"
                            href="{{ route('pdf.batch', ['id' => Crypt::encrypt($data->id_batch)]) }}" target="_blank">
                            Imprimir
                        </a>
                    </div>
                    <x-button type="cancel" route-name="queries-batches" />
                </x-group>

            </x-panel>
        @endif

        <x-panel title="Dados" type="warning">
            <x-data-table data-origin="queries-batches.datatable" query-string="route=queries-batches.show"
                id-field="{{ $field ?? '' }}" order="id_batch" order-dir="desc"
                columns="{{ json_encode([
                    [
                        'data' => 'actions_search',
                        'width' => '20px',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Código',
                        'data' => 'id_batch',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Data/Hora',
                        'data' => 'created_at',
                        'className' => 'text-center',
                    ],
                    [
                        'title' => 'Nome',
                        'data' => 'user.name',
                    ],
                    [
                        'title' => 'Qtd. Despesas',
                        'data' => 'expenses_count',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Vl. Reembolsável',
                        'data' => 'refundable_amount',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Vl. Não Reembolsável',
                        'data' => 'non_refundable_amount',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Vl. Total',
                        'data' => 'amount',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Status',
                        'data' => 'status',
                        'className' => 'text-center',
                    ],
                ]) }}" />
        </x-panel>
    </x-content>
@endsection
