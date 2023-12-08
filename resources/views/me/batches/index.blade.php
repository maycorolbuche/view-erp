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


                    <x-group right>
                        @if ($edit)
                            <x-button type="delete" label="Desfazer Lote" />
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
