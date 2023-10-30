@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', ['user' => isset($data) ? $data : null])

            @include('users.components.tabs', ['id' => isset($data) ? $data->id_user : null])

            @include('layouts.partials.messages')

            @if (isset($data) && $data->root == true)
                <blockquote class="blockquote-warning">
                    <p>Este usuário não pode ser apagado, pois é um usuário do sistema.</p>
                </blockquote>
            @endif

            <x-form action-name="users" action-id="{{ isset($data) ? $data->id_user : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="email" name="email" width="400" label="E-mail" required
                        value="{{ $data->email ?? '' }}" />
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

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', ['route' => 'users.show'])
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        $("[name=name]").blur(function() {
            if ($("[name=slug]").val() == "") {
                $("[name=slug]").val($("[name=name]").val()).blur()
            }
        });
    </script>
@endpush
