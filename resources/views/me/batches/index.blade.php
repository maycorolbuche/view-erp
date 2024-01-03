@extends('layouts.app')
@section('title', 'Consulta de Lotes')
@section('breadcrumb', json_encode([['label' => 'Consulta de Lotes', 'icon' => 'fas fa-database']]))

@section('content')
    <x-content>

        @if (isset($data))

            @php
                $edit = false;
                if (isset($data) && $data->active) {
                    $edit = true;
                }
            @endphp

            <x-panel title="Detalhes do Lote" type="info">

                @include('layouts.partials.messages')

                <x-form action-name="me-batches" action-id="{{ isset($data) ? $data->id_batch : null }}">

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

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th class='text-right'>Código</th>
                                <th>Data</th>
                                <th>Tipo de Despesa</th>
                                <th>Clientes</th>
                                <th>Tipo de Pagamento</th>
                                <th class='text-right'>Valor</th>
                                <th class='text-center'>Reembolsável?</th>
                                <th></th>
                                <th></th>
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
                                                    <span class='label label-warning' data-toggle="tooltip"
                                                        data-placement="left"
                                                        title="{{ number_format($user->pivot->percentage, 2, ',', '.') }}% | R$ {{ number_format($user->pivot->amount, 2, ',', '.') }}">
                                                        {{ $user->short_name }}
                                                    </span>&nbsp;
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-right">
                                            @if (trim($expense->notes) != '')
                                                <button type="button" class="btn btn-info btn-sm fs12"
                                                    data-container="body" data-toggle="popover" data-placement="left"
                                                    data-content="{{ $expense->notes }}">
                                                    <i class="glyphicons glyphicons-notes"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <br>

                    <x-title>Descontos do Lote</x-title>
<!--
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th class='text-right'>Código</th>
                                <th>Data</th>
                                <th>Tipo de Despesa</th>
                                <th>Clientes</th>
                                <th>Tipo de Pagamento</th>
                                <th class='text-right'>Valor</th>
                                <th class='text-center'>Reembolsável?</th>
                                <th></th>
                                <th></th>
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
                                                    <span class='label label-warning' data-toggle="tooltip"
                                                        data-placement="left"
                                                        title="{{ number_format($user->pivot->percentage, 2, ',', '.') }}% | R$ {{ number_format($user->pivot->amount, 2, ',', '.') }}">
                                                        {{ $user->short_name }}
                                                    </span>&nbsp;
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-right">
                                            @if (trim($expense->notes) != '')
                                                <button type="button" class="btn btn-info btn-sm fs12"
                                                    data-container="body" data-toggle="popover" data-placement="left"
                                                    data-content="{{ $expense->notes }}">
                                                    <i class="glyphicons glyphicons-notes"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
-->
                    <x-group right>
                        @if ($edit)
                            <x-button type="delete" label="Desfazer Lote" confirm="Deseja realmente desfazer este lote?" />
                        @endif
                        <x-button type="cancel" route-name="me-batches" />
                    </x-group>

                </x-form>
            </x-panel>
        @endif

        <x-panel title="Dados" type="warning">
            @include('me.batches.components.datatable', ['route' => 'me-batches.show'])
        </x-panel>
    </x-content>
@endsection
