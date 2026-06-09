@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('roles.components.header', ['role' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="roles" action-id="{{ isset($data) ? $data->id_role : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
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
                    <x-button type="cancel" route-name="roles" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('roles.components.datatable', ['route' => 'roles.show'])
        </x-panel>
    </x-content>
@endsection
