@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">


            @include('layouts.partials.messages')

            <x-form action-name="configs" action="{{ route('configs.update') }}">
                <x-title>Autorizações</x-title>
                <x-group>
                    <x-input type="numeric" name="authorizationsActiveDays_to_close" width="100"
                        label="Qtd. dias para encerrar autorização"
                        value="{{ $configs['authorizations.active.days_to_close'] ?? '' }}"
                        tip="Quantos dias após o vencimento de uma autorização, a mesma deve ser encerrada?" />
                </x-group>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="configs" />
                </x-group>
            </x-form>

        </x-panel>
    </x-content>

@endsection
