@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('layouts.partials.messages')

            @php
                $action_checkbox = '
                    <div class="btn-group">
                        <a style="color: #666; cursor: pointer; text-decoration: none;" data-toggle="dropdown" aria-expanded="true">
                            <i class="far fa-square"></i>
                            <span class="caret ml5"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="javascript:" onclick="check(\'expense\', \'all\');sum_expenses();">
                                    <i class="far fa-check-square"></i> Marcar Todos
                                </a>
                            </li>
                            <li>
                                <a href="javascript:" onclick="check(\'expense\', \'none\');sum_expenses();">
                                    <i class="far fa-square"></i> Desmarcar Todos
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:" onclick="check(\'expense\', \'reverse\');sum_expenses();">
                                    <i class="far fa-minus-square"></i> Inverter Seleção
                                </a>
                            </li>
                        </ul>
                    </div>';
            @endphp

            <x-form action-name="batches" action-id="{{ null }}">

                <x-note>Selecione as despesas para a geração do lote.</x-note>

                <div class="panel-body pn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th style="padding-left: 12px;">
                                    {!! $action_checkbox !!}
                                </th>
                                <th class='text-right'>Código</th>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Clientes</th>
                                <th>Forma Pgto.</th>
                                <th class='text-right'>Valor</th>
                                <th class='text-center'>Reembolsável?</th>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr class="{{ !$expense->payment_method->refundable ? 'danger' : '' }}">
                                        <td>
                                            <div class="checkbox-custom checkbox-info">
                                                <input type="checkbox" id="expense_{{ $expense->id_expense }}"
                                                    name="expense[{{ $expense->id_expense }}]"
                                                    data-value="{{ $expense->amount }}" onchange="sum_expenses()">
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
                                                <span class='badge badge-info'>{{ $client->short_name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $expense->payment_method->name }}</td>
                                        <td class='text-right'>{{ number_format($expense->amount, 2, ',', '.') }}</td>
                                        <td class='text-center'>
                                            {!! $expense->payment_method->refundable
                                                ? "<span class='badge badge-info'>Reembolsável</span>"
                                                : "<span class='badge badge-danger'>Não Reembolsável</span>" !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background:#f9f9f9">
                                <tr id="expenses-checked">
                                    <th style="padding-left: 12px;">
                                        {!! $action_checkbox !!}
                                    </th>
                                    <th colspan=5 class='text-right text-info'>Valor selecionado</th>
                                    <th class='text-right text-info expenses-checked'>0,00</th>
                                    <th></th>
                                </tr>
                                <tr id="expenses-not-checked">
                                    <th></th>
                                    <th colspan=5 class='text-right text-danger'>Valor não selecionado</th>
                                    <th class='text-right text-danger expenses-not-checked'>0,00</th>
                                    <th></th>
                                </tr>
                                <tr id="expenses-all">
                                    <th style="padding-left: 12px;">
                                        {!! $action_checkbox !!}
                                    </th>
                                    <th colspan=5 class='text-right'>Valor total</th>
                                    <th class='text-right expenses-all'>0,00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

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
        $(document).ready(function() {
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
