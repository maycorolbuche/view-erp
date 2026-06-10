@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))
            <x-panel title="Formulário">

                <x-title>
                    {{ $data->name ?? '' }}
                </x-title>

                @include('layouts.partials.messages')

                <x-form action-name="cash-advances" action-id="{{ isset($data) ? $data->id_user : null }}">
                    <x-group>
                        <x-input type="money" name="amount" width="150" label="Valor" required />
                        <x-input name="description" width="350" label="Motivo" required />
                        <x-input type="html" width="100" label="Saldo de Adiantamento">
                            <h2 style="margin: 0;margin-top: 7px;padding: 0;float: right;">
                                R$ {{ number_format($user_cash ?? 0, 2, ',', '.') }}
                            </h2>
                        </x-input>
                    </x-group>

                    <input type="hidden" name="transaction" id="transaction" value="">

                    <x-group right>
                        <x-button name="bt_add_payment" type="update" layout="success" hidden="{{ !isset($data) }}"
                            confirm="Adicionar este valor ao saldo atual?" label="Pagar"
                            permission="{{ in_array('update', request('__permissions_page')) }}" />
                        <x-button name="bt_remove_payment" type="update" layout="danger" hidden="{{ !isset($data) }}"
                            confirm="Remover este valor do saldo atual?" label="Estornar"
                            permission="{{ in_array('update', request('__permissions_page')) }}" />
                        <x-button type="cancel" route-name="cash-advances" />
                    </x-group>

                </x-form>

                <br>

                <x-panel title="Histórico">
                    <x-data-table data-origin="cash-advances.datatable"
                        query-string="type=user-history&id_user={{ $data->id_user }}" order="date" order_dir="desc"
                        columns="{{ json_encode([
                            [
                                'title' => 'Data/Hora',
                                'data' => 'date',
                                'className' => 'text-center',
                            ],
                            [
                                'title' => 'Descrição',
                                'data' => 'description',
                                'orderable' => false,
                            ],
                            [
                                'title' => 'Saldo Anterior',
                                'data' => 'previous_balance',
                                'className' => 'text-right',
                            ],
                            [
                                'title' => 'Valor',
                                'data' => 'amount',
                                'className' => 'text-right',
                            ],
                            [
                                'title' => 'Saldo Posterior',
                                'data' => 'current_balance',
                                'className' => 'text-right',
                            ],
                        ]) }}" />

                </x-panel>
            </x-panel>
        @else
            @include('layouts.partials.messages')
        @endif

        <x-panel title="Dados">
            @include('cash-advances.components.datatable', ['route' => 'cash-advances.show'])
        </x-panel>
    </x-content>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $("#bt_add_payment").click(function() {
                $("#transaction").val("add");
                return true;
            });
            $("#bt_remove_payment").click(function() {
                $("#transaction").val("remove");
                return true;
            });
        });
    </script>
@endpush
