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
                        <x-card width="150" type="info" value="{{ $data->expenses_count }}" label="Qtd. Despesas" />
                        <x-card type="warning" value="R$ {{ number_format($data->amount, 2, ',', '.') }}"
                            label="Valor do Lote" />
                        <x-card type="danger" value="R$ {{ number_format($data->non_refundable_amount, 2, ',', '.') }}"
                            label="(-) Vl. não Reembolsável" />
                    </x-group>

                    <x-group>
                        <x-input type="html" width="100" label="Código do Lote">
                            <div class="text-right form-control">{{ $data->id_batch }}</div>
                        </x-input>
                        <x-input type="html" width="100" label="Qtd. Despesas">
                            <div class="text-right form-control">{{ $data->expenses_count }}</div>
                        </x-input>
                        <x-input type="html" width="140" label="Valor do Lote">
                            <div class="text-right form-control">{{ number_format($data->amount, 2, ',', '.') }}</div>
                        </x-input>
                        <x-input type="html" width="160" label="(-) Vl. não Reembolsável">
                            <div class="text-right form-control">
                                {{ number_format($data->non_refundable_amount, 2, ',', '.') }}
                            </div>
                        </x-input>
                        <x-input type="html" width="140" label="(-) Vl. Desconto">
                            <div class="text-right form-control">.....</div>
                        </x-input>
                        <x-input type="html" width="140" label="(=) Vl. Reembolso">
                            <div class="text-right form-control">.....</div>
                        </x-input>
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
