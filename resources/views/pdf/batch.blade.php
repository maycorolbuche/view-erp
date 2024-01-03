@extends('layouts.pdf')
@section('title', 'Impressão de Lote')

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

<blockquote style="font-size:16px;">
    <b>Nome:</b> {{ $data->user->name }}
    <br><b>E-mail:</b> {{ $data->user->email }}
    <br><b>RG:</b> {{ $data->user->rg }}
    {!! str_repeat('&nbsp;', 15) !!}<b>CPF:</b> {{ $data->user->cpf_or_cnpj }}
</blockquote>

OLA DE NOVO
