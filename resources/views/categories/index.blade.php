@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('categories.components.header', ['category' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="categories" action-id="{{ isset($data) ? $data->id_category : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input name="short_name" width="100" label="Nome Abreviado" value="{{ $data->short_name ?? '' }}" />
                    <x-input type="select" name="id_category_type" width="250" label="Tipo" required
                        list="{{ json_encode($categories_types) }}" list-value="id_category_type" list-text="name"
                        value="{{ $data->id_category_type ?? '' }}" />
                </x-group>

                <x-group>
                    <x-input type="multiple" name="users" width="250" label="Usuários" list="{{ json_encode($users) }}"
                        list-value="id_user" list-text="name" value="{{ json_encode($data->users ?? []) }}"
                        tip="Se estiver preenchido, esta categoria ficará associada apenas aos usuários selecionados" />
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
                    <x-button type="cancel" route-name="categories" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('categories.components.datatable', ['route' => 'categories.show'])
        </x-panel>
    </x-content>
@endsection
