@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-phones" action-id="{{ isset($data) ? $data->id_user_phone : null }}"
                action-pid="{{ $pid }}">
                <x-group>
                    <x-input type="phone" name="phone" width="250" label="Telefone" required
                        value="{{ $data->phone ?? '' }}" />
                    <x-input type="select" name="id_carrier" width="150" label="Operadora"
                        list="{{ json_encode($carriers) }}" list-value="id_carrier" list-text="name"
                        value="{{ $data->id_carrier ?? '' }}" />
                    <x-input type="select" name="id_phone_type" width="150" label="Tipo de Telefone"
                        list="{{ json_encode($phones_types) }}" list-value="id_phone_type" list-text="description"
                        value="{{ $data->id_phone_type ?? '' }}" />
                    <x-input name="contact_name" width="200" label="Contato" value="{{ $data->contact_name ?? '' }}" />
                    <x-input type="bool" name="is_business" width="150" label="Telefone comercial?"
                        value="{{ $data->is_business ?? '' }}" />
                    <x-input type="bool" name="has_whatsapp" width="120" label="Tem Whatsapp?"
                        value="{{ $data->has_whatsapp ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                    @if (isset($data))
                        <x-button type="cancel" route="{{ route('users-phones.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="users-phones" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Lista de Telefones" type="success">
                <x-data-table data-origin="users-phones.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="phone"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_user_phone',
                        ],
                        [
                            'title' => 'Número',
                            'data' => 'phone',
                        ],
                        [
                            'title' => 'Operadora',
                            'data' => 'carrier',
                        ],
                        [
                            'title' => 'Tipo',
                            'data' => 'phone_type',
                        ],
                        [
                            'title' => 'Contato',
                            'data' => 'contact_name',
                        ],
                    ]) }}" />

            </x-panel>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-phones.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
