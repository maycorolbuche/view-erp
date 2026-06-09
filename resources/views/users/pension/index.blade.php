@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-pension" action-id="{{ isset($data) ? $data->id_user_pension : null }}"
                action-pid="{{ $pid }}">
                <x-group>
                    <x-input type="date" name="date" width="150" label="Data" value="{{ $data->date ?? '' }}"
                        required />
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
                        <x-button type="cancel" route="{{ route('users-pension.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="users-pension" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Datas de Pagamentos">
                <x-data-table data-origin="users-pension.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="date" order_dir="desc"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_user_pension',
                            'className' => 'text-right',
                        ],
                        [
                            'title' => 'Data',
                            'data' => 'date',
                            'className' => 'text-center',
                        ],
                    ]) }}" />

            </x-panel>

        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-pension.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
