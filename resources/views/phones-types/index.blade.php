@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('phones-types.components.header', ['phone_type' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="phones-types" action-id="{{ isset($data) ? $data->id_phone_type : null }}">
                <x-group>
                    <x-input name="description" width="400" label="Descrição" required
                        value="{{ $data->description ?? '' }}" />
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
                    <x-button type="cancel" route-name="phones-types" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('phones-types.components.datatable', ['route' => 'phones-types.show'])
        </x-panel>
    </x-content>
@endsection
