@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('profiles.components.header', ['profile' => isset($data) ? $data : null])

            @include('profiles.components.tabs', ['id' => isset($data) ? $data->id_profile : null])

            @include('layouts.partials.messages')

            @if (isset($data) && $data->root == true)
                <x-note type="warning">
                    Este perfil não pode ser apagado, pois é um perfil do sistema.
                </x-note>
            @endif

            <x-form action-name="profiles" action-id="{{ isset($data) ? $data->id_profile : null }}">
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
                    <x-button type="cancel" route-name="profiles" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('profiles.components.datatable', ['route' => 'profiles.show'])
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
