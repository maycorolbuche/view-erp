@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('branches.components.header', ['branch' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="branches" action-id="{{ isset($data) ? $data->id_branch : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input name="short_name" width="100" label="Nome Abreviado" required
                        value="{{ $data->short_name ?? '' }}" />
                </x-group>

                <x-group title="Endereço">
                    <x-input type="zipcode" name="zip_code" width="150" label="CEP" address="address"
                        district="district" state="state" city="city" value="{{ $data->zip_code ?? '' }}" />
                    <x-input type="text" name="address" width="400" label="Endereço"
                        value="{{ $data->address ?? '' }}" />
                    <x-input type="text" name="number" width="150" label="Nº"
                        value="{{ $data->number ?? '' }}" />
                    <x-input type="text" name="complement" width="400" label="Complemento"
                        value="{{ $data->complement ?? '' }}" />
                    <x-input type="text" name="district" width="300" label="Bairro"
                        value="{{ $data->district ?? '' }}" />
                    <x-input type="text" name="city" width="300" label="Cidade" value="{{ $data->city ?? '' }}" />
                    <x-input type="text" name="state" width="180" label="Estado" value="{{ $data->state ?? '' }}" />
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
                    <x-button type="cancel" route-name="branches" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('branches.components.datatable', ['route' => 'branches.show'])
        </x-panel>
    </x-content>
@endsection
