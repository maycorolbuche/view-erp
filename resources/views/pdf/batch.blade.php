@extends('layouts.pdf')
@section('title', 'Impressão de Lote')

<footer>
    <table style="border-top:1px solid #AAA;">
        <tr>
            <td style="text-wrap: nowrap;width:200px;">
                <b>Emissão:</b> {{ date('d/m/Y H:i:s') }}
            </td>
            <td style="text-align:center;width:100%;text-wrap: nowrap;">
                <b>Lote...:</b> {{ $data->id_batch }}
            </td>
            <td style="text-align:right;text-wrap: nowrap;width:200px;">
                <b>Folha...:</b> <span class="pagenum"></span>
            </td>
        </tr>
    </table>
</footer>

{{-- @if (!$data->active) --}}
@if ($data->status["type"] <> "reviewed")
    <table style="position: fixed;top: 0;left: 0;width: 100%;height: 100%;z-index: 1000;">
        <tr>
            <td style="text-align: center;vertical-aign: middle;height: 100%;">
                <div
                    style="border:10px solid #000;border-left:0;border-right:0;transform: rotate(315deg);font-size:100px;font-weight:bold;opacity: .5;">
                    &nbsp;&nbsp;&nbsp;&nbsp;{{
                        $data->status["type"] == "closed"
                            ? "PAGO"
                            : 
                            (
                                $data->status["type"] == "analyzing"
                                    ? "REVISÃO"
                                    : mb_strtoupper($data->status["label"])
                            )
                    }}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </td>
        </tr>
    </table>
@endif

<main>
    <table style=" border-bottom: 1px solid #000;">
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                <img src="assets/img/logos/logo.png" style="height: 50px;">
            </td>
            <td style="width:100%; text-align: center;">
                <h1>Resumo de Despesas</h1>
            </td>
            <td style="text-align: center; min-width:100px;">
                <table style="border: 1px solid #000; min-width:100px;">
                    <tr>
                        <td style="background: #CCC; text-align: center;">
                            <b>LOTE</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;font-size: 30px;">
                            {{ $data->id_batch }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>

    <blockquote style="font-size:14px;">
        <b>Nome:</b> {{ $data->user->name }}
        <br><b>E-mail:</b> {{ $data->user->email }}
        <br><b>RG:</b> {{ $data->user->rg }}
        {!! str_repeat('&nbsp;', 15) !!}<b>CPF:</b> {{ $data->user->cpf_or_cnpj }}
    </blockquote>

    <div style="clear: both"></div>

    <h2>Despesas do Lote</h2>

    <table class="table">
        <thead>
            <th class='text-right'>Código</th>
            <th>Data</th>
            <th>Tipo de Despesa</th>
            <th>Clientes</th>
            <th>Tipo de Pagamento</th>
            <th class='text-right'>Valor</th>
            <th class='text-center'>Reembolsável?</th>
            <th>Anotações</th>
        </thead>
        <tbody>
            @foreach ($data->expenses as $expense)
                <tr class="{{ !$expense->payment_method->refundable ? 'danger' : '' }}">
                    <td class='text-right'>{{ $expense->id_expense }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                    <td>{{ $expense->category->name }}</td>
                    <td>
                        @foreach ($expense->clients as $indx => $client)
                            {!! $indx > 0 ? '<br>' : '' !!}
                            {{ $client->name }}
                        @endforeach
                    </td>
                    <td>{{ $expense->payment_method->name }}</td>
                    <td class='text-right'>{{ number_format($expense->amount, 2, ',', '.') }}</td>
                    <td class='text-center'>
                        {{ $expense->payment_method->refundable ? 'Sim' : 'Não' }}
                    </td>
                    <td>
                        {{ $expense->notes }}
                        @foreach ($expense->users as $indx => $user)
                            @if ($user->id_user != $expense->id_user)
                                {!! $indx == 0 && trim($expense->notes) != '' ? '<br>' : '' !!}
                                {!! $indx > 0 ? '<br>' : '' !!}
                                <b>+ {{ $user->name }}</b>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Descontos do Lote</h2>

    <table class="table">
        <thead>
            <th class='text-right'>Código</th>
            <th class='text-right'>Valor da Despesa</th>
            <th class='text-right'>Valor do Desconto</th>
            <th class='text-right'>Cód. Despesa</th>
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
    </table>

    <div style="page-break-inside: avoid;">
        @if ($data->status["type"] == "reviewed" || $data->status["type"] == "closed")
            <h2>Resumo</h2>

            <blockquote style="font-size:14px;">
                <b>Qtd. Despesas:</b> {{ count($data->expenses) }}
            </blockquote>

            <table>
                <tr>
                    <td>
                        <table style="border: 1px solid #000;">
                            <tr>
                                <td style="background: #CCC; text-align: center;">
                                    <b>Valor do Lote</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;font-size: 16px;padding:5px;">
                                    R$ {{ number_format($data->amount, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-size:30px;text-align:center;width:30px;">-</td>
                    <td>
                        <table style="border: 1px solid #000;">
                            <tr>
                                <td style="background: #CCC; text-align: center;">
                                    <b>Vl. não Reembolsável</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;font-size: 16px;padding:5px;">
                                    R$ {{ number_format($data->non_refundable_amount, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-size:30px;text-align:center;width:30px;">-</td>
                    <td>
                        <table style="border: 1px solid #000;">
                            <tr>
                                <td style="background: #CCC; text-align: center;">
                                    <b>Vl. Desconto</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;font-size: 16px;padding:5px;">
                                    R$ {{ number_format($data->discount, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>

                    @if ($data->active)
                        <td style="font-size:30px;text-align:center;width:30px;">-</td>
                        <td>
                            <table style="border: 1px solid #000;">
                                <tr>
                                    <td style="background: #CCC; text-align: center;">
                                        <b>Vl. Adiantamento</b><sup>1</sup>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 16px;padding:5px;">
                                        R$
                                        {{ number_format($data->user->users_cash ? $data->user->users_cash->amount : 0, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-size:30px;text-align:center;width:30px;">=</td>
                        <td>
                            <table style="border: 1px solid #000;">
                                <tr>
                                    <td style="background: #CCC; text-align: center;">
                                        <b>Vl. Reembolso</b><sup>2</sup>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 16px;padding:5px;">
                                        R$
                                        {{ number_format(
                                            max([0, $data->refund_amount - ($data->user->users_cash ? $data->user->users_cash->amount : 0)]),
                                            2,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @else
                        <td style="font-size:30px;text-align:center;width:30px;">-</td>
                        <td>
                            <table style="border: 1px solid #000;">
                                <tr>
                                    <td style="background: #CCC; text-align: center;">
                                        <b>Vl. Adiantamento</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 16px;padding:5px;">
                                        R$
                                        {{ number_format($data->user_cash, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        @if ($data->extra_amount != 0)
                            <td style="font-size:30px;text-align:center;width:30px;">
                                {{ $data->extra_amount < 0 ? '-' : '+' }}
                            </td>
                            <td>
                                <table style="border: 1px solid #000;">
                                    <tr>
                                        <td style="background: #CCC; text-align: center;">
                                            <b>{{ $data->extra_amount < 0 ? 'Desconto' : 'Acréscimo' }}
                                                Extra</b><sup>1</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;font-size: 16px;padding:5px;">
                                            R$ {{ number_format(abs($data->extra_amount), 2, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endif
                        <td style="font-size:30px;text-align:center;width:30px;">=</td>
                        <td>
                            <table style="border: 1px solid #000;">
                                <tr>
                                    <td style="background: #CCC; text-align: center;">
                                        <b>Vl. Reembolso</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 16px;padding:5px;">
                                        R$ {{ number_format($data->amount_paid, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endif

                </tr>
            </table>

            @if ($data->active)
                <b>Obs.:</b>
                <br><sup>1</sup> Valor de adiantamento referente a {{ date('d/m/Y H:i:s') }}.
                Este valor pode variar até o momento do pagamento.
                <br><sup>2</sup> O valor do reembolso pode variar, dependendo do seu saldo de adiantamento
                (R$ {{ number_format($data->user->users_cash ? $data->user->users_cash->amount : 0, 2, ',', '.') }})
                no momento do pagamento.
            @elseif ($data->extra_amount != 0)
                <b>Obs.:</b>
                <br><sup>1</sup>{{ $data->reason_extra_amount }}
            @endif

        @endif

        <br>
        <br>Eu, <b>{{ $data->user->name }}</b>, declaro serem verdadeiras todas as informações acima.
        <br>Data: {{ date('d/m/Y') }} / Hora: {{ date('H:i:s') }}
        <table style="float:right;width:300px;">
            <tr>
                <td>
                    Assinatura:
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <div style="border-bottom:1px solid #000;height:50px;"></div>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <b>{{ $data->user->name }}</b>
                </td>
            </tr>
        </table>
    </div>

</main>
