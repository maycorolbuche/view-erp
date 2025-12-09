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
