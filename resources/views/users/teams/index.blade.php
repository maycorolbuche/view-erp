@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-teams" action-id="{{ isset($data) ? $data->id_user_team : null }}"
                action-pid="{{ $pid }}">

                <input type="hidden" name="id_user_people_old" value="{{ $data->id_user_people ?? '' }}" />
                <input type="hidden" name="relationship_old" value="{{ $data->relationship ?? '' }}" />

                <x-group>
                    <x-input type="select" name="id_user_people" required width="400" label="Pessoa"
                        list="{{ json_encode($users) }}" list-value="id_user" list-text="name"
                        value="{{ $data->id_user_people ?? '' }}" />
                    <x-input type="radio" name="relationship" required width="400" label="Tipo de Relacionamento"
                        list="{{ json_encode([['type' => 'parent', 'name' => 'Superior'], ['type' => 'child', 'name' => 'Subordinado']]) }}"
                        list-value="type" list-text="name" value="{{ $data->relationship ?? 'parent' }}" />
                </x-group>

                <x-group>
                    @php
                        $idValues = [];
                        if (isset($data) && isset($data->users_authorizations_types)) {
                            foreach ($data->users_authorizations_types as $item) {
                                $idValues[] = $item['id_authorization_type'];
                            }
                        }
                    @endphp

                    <x-input type="checkbox" name="id_authorization_type" width="200" label="Autorizações"
                        list="{{ json_encode($authorizations_types) }}" list-value="id_authorization_type" list-text="name"
                        value="{{ json_encode($idValues ?? '[]') }}" />
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
                        <x-button type="cancel" route="{{ route('users-teams.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="users-teams" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Lista de Dependentes" type="success">
                <x-data-table data-origin="users-teams.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="name"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_user_team',
                            'className' => 'text-right',
                        ],
                        [
                            'title' => 'Nome',
                            'data' => 'name',
                        ],
                        [
                            'title' => 'Tipo de Relacionamento',
                            'data' => 'relationship',
                            'className' => 'text-center',
                        ],
                    ]) }}" />
            </x-panel>
            ,
            [
            'title' => 'Autoriações',
            'data' => 'authorizations',
            'className' => 'text-center',
            ]
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-teams.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
