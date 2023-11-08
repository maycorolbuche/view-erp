@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-vacations" action-id="{{ isset($data) ? $data->id_user_vacation : null }}"
                action-pid="{{ $pid }}">

                <div
                    style="display: flex;flex-direction: row;flex-wrap: wrap;align-items: stretch;justify-content: space-around;">
                    <x-group title="Período Aquisitivo" type="warning">
                        <x-input type="date" name="start_date_acquisition_period" width="150" label="Dt. Início"
                            value="{{ $data->start_date_acquisition_period ?? '' }}" />
                        <x-input type="date" name="end_date_acquisition_period" width="150" label="Dt. Término"
                            value="{{ $data->end_date_acquisition_period ?? '' }}" />
                    </x-group>

                    <x-group title="Período Solicitado" type="success">
                        <x-input type="date" name="start_date_requested_period" width="150" label="Dt. Início"
                            value="{{ $data->start_date_requested_period ?? '' }}" />
                        <x-input type="date" name="end_date_requested_period" width="150" label="Dt. Término"
                            value="{{ $data->end_date_requested_period ?? '' }}" />
                    </x-group>

                    <x-group title="Período de Aprovação" type="warning">
                        <x-input type="date" name="start_date_approval_period" width="150" label="Dt. Início"
                            value="{{ $data->start_date_approval_period ?? '' }}" />
                        <x-input type="date" name="end_date_approval_period" width="150" label="Dt. Término"
                            value="{{ $data->end_date_approval_period ?? '' }}" />
                    </x-group>

                    <x-group title="Período Aprovado" type="success">
                        <x-input type="date" name="start_date_approved_period" width="150" label="Dt. Início"
                            value="{{ $data->start_date_approved_period ?? '' }}" />
                        <x-input type="date" name="end_date_approved_period" width="150" label="Dt. Término"
                            value="{{ $data->end_date_approved_period ?? '' }}" />
                    </x-group>

                    <x-group title="Período de Gozo">
                        <x-input type="date" name="start_date" width="150" label="Dt. Início"
                            value="{{ $data->start_date ?? '' }}" />
                        <x-input type="date" name="end_date" width="150" label="Dt. Término"
                            value="{{ $data->end_date ?? '' }}" />
                    </x-group>
                </div>

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
                        <x-button type="cancel" route="{{ route('users-vacations.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="users-vacations" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Histórico de Férias" type="success">
                <x-data-table data-origin="users-vacations.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="period" order_dir="desc"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_user_vacation',
                            'className' => 'text-right',
                        ],
                        [
                            'title' => 'Período Gozo',
                            'data' => 'period',
                            'className' => 'text-center',
                        ],
                        [
                            'title' => 'Período Aquisitivo',
                            'data' => 'acquisition_period',
                            'className' => 'text-center',
                        ],
                        [
                            'title' => 'Período Solicitado',
                            'data' => 'requested_period',
                            'className' => 'text-center',
                        ],
                        [
                            'title' => 'Período de Aprovação',
                            'data' => 'approval_period',
                            'className' => 'text-center',
                        ],
                        [
                            'title' => 'Período Aprovado',
                            'data' => 'approved_period',
                            'className' => 'text-center',
                        ],
                    ]) }}" />

            </x-panel>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-vacations.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
