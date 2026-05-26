@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content title="Pessoas">

        <x-panel title="Formulário">

            @include('users.components.header', ['user' => isset($data) ? $data : null])

            @include('users.components.tabs', ['id' => isset($data) ? $data->id_user : null])

            @include('layouts.partials.messages')

            <x-form action-name="users" action-id="{{ isset($data) ? $data->id_user : null }}">
                <x-group title="Dados Pessoais" icon="person">
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="email" name="email" width="400" label="E-mail" required
                        value="{{ $data->email ?? '' }}" />
                    <x-input type="cpf_cnpj" name="cpf_or_cnpj" width="200" label="CPF/CNPJ"
                        value="{{ $data->cpf_or_cnpj ?? '' }}" />
                    <x-input type="rg" name="id_card" width="200" label="RG"
                        value="{{ $data->id_card ?? '' }}" />
                    <x-input type="pis" name="pis" width="200" label="PIS/PASEB"
                        value="{{ $data->pis ?? '' }}" />
                    <x-input type="date" name="birth_date" width="200" label="Dt. Nascimento"
                        value="{{ $data->birth_date ?? '' }}" />
                    <x-input type="select" name="id_civil_status" width="200" label="Estado Civil"
                        list="{{ json_encode($civil_statuses) }}" list-value="id_civil_status" list-text="description"
                        value="{{ $data->id_civil_status ?? '' }}" />
                </x-group>

                <x-group title="Dados Empresariais" icon="building">
                    <x-input type="select" name="id_employment_type" width="200" label="Tipo de Recurso" required
                        list="{{ json_encode($employment_types) }}" list-value="id_employment_type" list-text="description"
                        value="{{ $data->id_employment_type ?? '' }}" />
                    <x-input type="select" name="id_branch" width="200" label="Filial" required
                        list="{{ json_encode($branches) }}" list-value="id_branch" list-text="name"
                        value="{{ $data->id_branch ?? '' }}" />
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
                    <x-button type="cancel" route-name="users" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', ['route' => 'users.show'])
        </x-panel>
    </x-content>
@endsection
