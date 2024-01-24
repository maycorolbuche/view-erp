@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-dependents" action-id="{{ isset($data) ? $data->id_user_dependent : null }}"
                action-pid="{{ $pid }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="select" name="id_relationship_degree" width="200" label="Grau de Relacionamento"
                        list="{{ json_encode($relationships_degrees) }}" list-value="id_relationship_degree"
                        list-text="name" value="{{ $data->id_relationship_degree ?? '' }}" />
                    <x-input type="date" name="birth_date" width="200" label="Dt. Nascimento"
                        value="{{ $data->birth_date ?? '' }}" />
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
                        <x-button type="cancel" route="{{ route('users-dependents.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="users-dependents" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Lista de Dependentes" type="success">
                <x-data-table data-origin="users-dependents.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="name"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_user_dependent',
                            'className' => 'text-right',
                        ],
                        [
                            'title' => 'Nome',
                            'data' => 'name',
                        ],
                        [
                            'title' => 'Grau de Relacionamento',
                            'data' => 'relationship_degree.name',
                        ],
                        [
                            'title' => 'Dt. Nascimento',
                            'data' => 'birth_date',
                            'className' => 'text-center',
                        ],
                    ]) }}" />

            </x-panel>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-dependents.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
