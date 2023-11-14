@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('authorizations-types.components.header', [
                'authorization_type' => isset($data) ? $data : null,
            ])

            @include('layouts.partials.messages')

            <x-form action-name="authorizations-types" action-id="{{ isset($data) ? $data->id_authorization_type : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" value="{{ $data->name ?? '' }}" readonly />
                    <x-input type="radio" name="approval" width="400" label="Qtd. de Aprovações"
                        list="{{ json_encode([['key' => 'one', 'value' => 'Um Responsável'], ['key' => 'all', 'value' => 'Todos os Responsáveis']]) }}"
                        list-value="key" list-text="value" value="{{ $data->approval ?? 'one' }}" />
                </x-group>

                <x-group right>
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="authorizations-types" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('authorizations-types.components.datatable', ['route' => 'authorizations-types.show'])
        </x-panel>
    </x-content>
@endsection
