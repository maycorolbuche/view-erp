@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('payment-methods.components.header', [
                'payment_method' => isset($data) ? $data : null,
            ])

            @include('layouts.partials.messages')

            <x-form action-name="payment-methods" action-id="{{ isset($data) ? $data->id_payment_method : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="bool" name="refundable" width="100" label="Reembolsável?"
                        value="{{ $data->refundable ?? 0 }}" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}" disabled="{{ isset($data) && $data->root }}"
                        permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="payment-methods" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('payment-methods.components.datatable', ['route' => 'payment-methods.show'])
        </x-panel>
    </x-content>
@endsection
