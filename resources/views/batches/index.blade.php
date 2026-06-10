@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('layouts.partials.messages')

            <x-form action-name="batches" action-id="{{ null }}">

                <x-note>Selecione as despesas para a geração do lote.</x-note>

                <x-table order=1 limit=0>
                    <thead>
                        <th orderable="false" style="padding-left: 12px;">
                            <x-action-checkbox element="expense" callback="sum_expenses()" />
                        </th>
                        <th type="number" class='text-right'>Código</th>
                        <th type="date">Data</th>
                        <th>Tipo de Despesa</th>
                        <th>Clientes</th>
                        <th>Tipo de Pagamento</th>
                        <th type="currency" class='text-right'>Valor</th>
                        <th class='text-center'>Reembolsável?</th>
                        <th orderable="false"></th>
                        <th orderable="false"></th>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr class="{{ !$expense->payment_method->refundable ? 'danger' : '' }}">
                                <td>
                                    <div class="checkbox-custom checkbox-info">
                                        <input type="checkbox" id="expense_{{ $expense->id_expense }}"
                                            name="expense[{{ $expense->id_expense }}]" data-value="{{ $expense->amount }}"
                                            onchange="sum_expenses()">
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
                                        ? "<span class='badge text-bg-info'>Reembolsável</span>"
                                        : "<span class='badge text-bg-danger'>Não Reembolsável</span>" !!}
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
                    <tfoot style="background:#f9f9f9">
                        <tr id="expenses-checked">
                            <th style="padding-left: 12px;">
                                <x-action-checkbox element="expense" callback="sum_expenses()" />
                            </th>
                            <th colspan=5 class='text-right text-info'>Valor selecionado</th>
                            <th class='text-right text-info expenses-checked'>0,00</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr id="expenses-not-checked">
                            <th></th>
                            <th colspan=5 class='text-right text-danger' style="border-bottom:1px solid #CCC">
                                Valor não selecionado
                            </th>
                            <th class='text-right text-danger expenses-not-checked' style="border-bottom:1px solid #CCC">
                                0,00
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr id="expenses-all">
                            <th style="padding-left: 12px;">
                                <x-action-checkbox element="expense" callback="sum_expenses()" />
                            </th>
                            <th colspan=5 class='text-right'>Valor total</th>
                            <th class='text-right expenses-all'>0,00</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th colspan=5 class='text-right'>Saldo de adiantamento</th>
                            <th class='text-right'>{{ number_format($user_cash, 2, ',', '.') }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </x-table>

                <br>

                <x-group right>
                    <x-button type="store" label="Gerar Lote"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="batches" />
                </x-group>

            </x-form>
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            sum_expenses();
        });

        function sum_expenses() {
            $(".expenses-checked").html(sum_checkbox_value('expense', 'checked', true));
            $(".expenses-not-checked").html(sum_checkbox_value('expense', 'not-checked', true));
            $(".expenses-all").html(sum_checkbox_value('expense', 'all', true));

            let checked = $(`input[name^="expense["]:checked`).length;
            let not_checked = $(`input[name^="expense["]:not(:checked)`).length;
            let all = $(`input[name^="expense["]`).length;
            if (checked == all || not_checked == all) {
                $("#expenses-checked").hide();
                $("#expenses-not-checked").hide();
                $("#expenses-all .btn-group").show();
            } else {
                $("#expenses-checked").show();
                $("#expenses-not-checked").show();
                $("#expenses-all .btn-group").hide();
            }
        }
    </script>
@endpush
