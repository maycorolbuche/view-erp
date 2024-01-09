@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-notifications" action="{{ route('users-notifications.update', compact('pid')) }}">
                <x-group>
                    <x-input type="multiple" name="id_notification" width="250" label="Notificações"
                        list="{{ json_encode($notifications) }}" list-value="id_notification" list-text="name"
                        value="{{ json_encode($user->id_notification ?? []) }}" />
                </x-group>

                <div>
                    <b>Nota:</b> Recomenda-se atribuir as notificações a usuários administradores do sistema.
                </div>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-notifications" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-notifications.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
