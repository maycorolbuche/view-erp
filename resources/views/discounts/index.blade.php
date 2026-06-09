@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('discounts.components.header', ['discount' => isset($data) ? $data : null])

            @include('discounts.components.tabs', ['id' => isset($data) ? $data->id_discount : null])

            @include('layouts.partials.messages')

            <x-form action-name="discounts" action-id="{{ isset($data) ? $data->id_discount : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                </x-group>
                <x-group>
                    <x-input type="multiple" name="id_category" width="250" label="Tipos de Despesa" required
                        list="{{ json_encode($categories) }}" list-value="id_category" list-text="name"
                        value="{{ json_encode($data->id_category ?? []) }}" />
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
                    <x-button type="cancel" route-name="discounts" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('discounts.components.datatable', ['route' => 'discounts.show'])
        </x-panel>
    </x-content>
@endsection
