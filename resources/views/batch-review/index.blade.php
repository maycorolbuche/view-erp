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
                                <th orderable="false">Conferido?</th>
                                <th type="number" class='text-right'>Código</th>
                                <th type="date">Data</th>
                                <th>Tipo de Despesa</th>
                                <th>Clientes</th>
                                <th>Tipo de Pagamento</th>
                                <th type="currency" class='text-right'>Valor</th>
                                <th class='text-center'>Reembolsável?</th>
                                <th orderable="false"></th>
                                <th orderable="false"></th>
                                <th orderable="false"></th>
                            </thead>
                            <tbody>
                                @foreach ($data->expenses as $expense)
                                    <tr class="{{ !$expense->payment_method->refundable ? 'danger' : '' }}">
                                        <td class='text-center'>
                                            <div id="container_expense_{{ $expense->id_expense }}"
                                                class="checkbox-custom checkbox-info">
                                                <input type="checkbox" id="expense_{{ $expense->id_expense }}"
                                                    data-value="{{ $expense->amount }}"
                                                    onchange="check({{ $expense->id_expense }})"
                                                    {{ $expense->revised ? 'checked' : '' }}>
                                                <label for="expense_{{ $expense->id_expense }}">
                                                    &nbsp;
                                                </label>
                                            </div>
                                        </td>
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
                                                <a href="{{ $expense->file->url }}" target="_blank">
                                                    <i class="fa fa-file"></i>
                                                    {{ $expense->file->original_name }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-table>

                        <div style="margin-top: 20px;"></div>

                        <x-group>
                            <x-input type="date" name="estimated_payment_date" width="150"
                                label="Data Prevista para Pagamento" value="{{ $estimated_payment_date }}" />
                        </x-group>

                        <x-group right>
                            <x-button type="update" layout="danger" value="fail" label="Reprovar Lote"
                                permission="{{ in_array('update', request('__permissions_page')) }}"
                                confirm="Deseja realmente reprovar este lote?" novalidate />
                            <x-button type="update" value="approve" label="Aprovar Lote"
                                permission="{{ in_array('update', request('__permissions_page')) }}"
                                confirm="Deseja aprovar este lote?" />
                            <x-button type="cancel" route-name="batch-review" />
                        </x-group>
                    </x-form>

                </x-panel>



                @push('scripts')
                    <script>
                        function clearContainer(container) {
                            container.removeClass("checkbox-info");
                            container.removeClass("checkbox-danger");
                            container.removeClass("checkbox-warning");
                        }

                        function check(id) {
                            let container = $(`#container_expense_${id}`);

                            clearContainer(container);
                            container.addClass("checkbox-warning");

                            const data = {
                                id_expense: id,
                                revised: $(`#expense_${id}`).prop("checked"),
                                _token: '{{ csrf_token() }}',
                                _method: 'PUT',
                                _action: "revised"
                            };

                            const options = {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify(data)
                            };

                            const url = "{{ route('batch-review.update', ['id' => $data->id_batch]) }}";

                            fetch(url, options)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    clearContainer(container);
                                    container.addClass("checkbox-info");
                                    console.log('Sucesso:', data);
                                })
                                .catch(error => {
                                    clearContainer(container);
                                    container.addClass("checkbox-danger");
                                    console.log('erro:', error);
                                });
                        }
                    </script>
                @endpush

            @endif
        @else
            @include('layouts.partials.messages')
        @endif

        <x-panel title="Lotes para revisão" type="warning">
            @include('batch-review.components.datatable', ['route' => 'batch-review.show'])
        </x-panel>
    </x-content>
@endsection
