@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-roles" action-id="{{ isset($data) ? $data->id_user_role : null }}"
                action-pid="{{ $pid }}">
                <x-group>
                    <x-input type="select" name="id_role" width="200" label="Cargo" list="{{ json_encode($roles) }}"
                        list-value="id_role" list-text="name" value="{{ $data->id_role ?? '' }}" required />
                    <x-input type="date" name="start_date" width="200" label="Dt. Início"
                        value="{{ $data->start_date ?? '' }}" />
                    <x-input type="date" name="end_date" width="200" label="Dt. Término"
                        value="{{ $data->end_date ?? '' }}" />
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
                        <x-button type="cancel" route="{{ route('users-roles.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="users-roles" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Lista de Cargos">
                <x-data-table data-origin="users-roles.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="start_date" order_dir="desc"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_user_role',
                            'className' => 'text-right',
                        ],
                        [
                            'title' => 'Cargo',
                            'data' => 'role.name',
                        ],
                        [
                            'title' => 'Dt. Início',
                            'data' => 'start_date',
                            'className' => 'text-center',
                        ],
                        [
                            'title' => 'Dt. Término',
                            'data' => 'end_date',
                            'className' => 'text-center',
                        ],
                    ]) }}" />

            </x-panel>

        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-roles.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
