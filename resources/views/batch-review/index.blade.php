@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))
            @if ($data->revised_status == 'pending')
                <x-panel title="Detalhes do Lote para Revisão" type="info">

                    <x-title>
                        Lote {{ $data->id_batch ?? '' }} | {{ $data->user->name }}
                    </x-title>

                    @include('layouts.partials.messages')

                    <x-form action-name="batch-review" action-id="{{ isset($data) ? $data->id_batch : null }}">

                        <x-group>
                            <x-card type="info" value="R$ {{ number_format($data->amount, 2, ',', '.') }}"
                                label="Valor do Lote" />
                        </x-group>
                        <x-group>
                            <x-card type="danger" value="R$ {{ number_format($data->non_refundable_amount, 2, ',', '.') }}"
                                label="(-) Vl. não Reembolsável" />
                            <x-card type="danger" value="R$ {{ number_format($data->discount, 2, ',', '.') }}"
                                label="(-) Vl. Desconto" />
                            <x-card type="danger" value="R$ {{ number_format($user_cash ?? 0, 2, ',', '.') }}"
                                label="(-) Saldo de Adiantamento" />
                        </x-group>
                        <x-group>
                            <x-card type="success"
                                value="R$ {{ number_format(max(0, $data->refund_amount - $user_cash ?? 0), 2, ',', '.') }}"
                                label="(=) Valor a Pagar" />
                        </x-group>

                        <x-group right>
                            <x-button type="update" hidden="{{ !isset($data) }}" label="Iniciar Revisão"
                                permission="{{ in_array('update', request('__permissions_page')) }}" />
                            <x-button type="cancel" route-name="batch-review" />
                        </x-group>

                    </x-form>
                </x-panel>
            @else
                <x-panel title="Revisão das Despesas do Lote" type="info">

                    <x-title>
                        Lote {{ $data->id_batch ?? '' }} | {{ $data->user->name }}
                    </x-title>

                    @include('layouts.partials.messages')

                    <x-form action-name="batch-review"
                        action="{{ route('batch-review.update', ['id' => $data->id_batch]) }}">
                        <x-table order=1 limit=0>
                            <thead>
                                <th type="number" class='text-right'>Código</th>
                                <th type="date">Data</th>
                                <th>Tipo de Despesa</th>
                                <th>Clientes</th>
                                <th>Tipo de Pagamento</th>
                                <th type="currency" class='text-right'>Valor</th>
                                <th type="currency" class='text-center'>Reembolsável?</th>
                                <th orderable="false"></th>
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
                                                    <span class='label label-warning' data-toggle="tooltip"
                                                        data-placement="left"
                                                        title="{{ number_format($user->pivot->percentage, 2, ',', '.') }}% | R$ {{ number_format($user->pivot->amount, 2, ',', '.') }}">
                                                        {{ $user->name }}
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
                                        <td class="text-right">
                                            @if (trim($expense->id_file) != '')
                                                ;;{{ $expense->id_file }};;
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
                        </x-table>

                        <x-group right>
                            <x-button type="update" layout="danger" value="fail" label="Reprovar Lote"
                                permission="{{ in_array('update', request('__permissions_page')) }}"
                                confirm="Deseja realmente reprovar este lote?" />
                            <x-button type="cancel" route-name="batch-review" />
                        </x-group>
                    </x-form>

                </x-panel>
            @endif
        @else
            @include('layouts.partials.messages')
        @endif

        <x-panel title="Lotes para revisão" type="warning">
            @include('batch-review.components.datatable', ['route' => 'batch-review.show'])
        </x-panel>
    </x-content>
@endsection
