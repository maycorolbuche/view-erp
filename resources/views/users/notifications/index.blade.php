@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-notifications" action="{{ route('users-notifications.update', compact('pid')) }}">
                <x-group>
                    <x-input type="checkbox" name="id_notification" width="250" label="Notificações"
                        list="{{ json_encode($notifications) }}" list-value="id_notification" list-text="name"
                        value="{{ json_encode(array_keys($user->id_notification) ?? []) }}" />
                </x-group>

                <div>
                    <b>Nota:</b> Recomenda-se atribuir as notificações a usuários administradores do sistema.
                </div>
                <x-note type="danger">
                    Algumas notificações são herdadas das permissões, e não podem ser removidas! Para remover, necessário
                    remover o acesso as telas correspondentes.
                </x-note>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-notifications" />
                </x-group>
            </x-form>

        </x-panel>

        @push('scripts')
            <script>
                const requiredNotifications = @json(array_filter($user->id_notification, function ($item) {
                        return $item['required'] == 1;
                    }));

                Object.keys(requiredNotifications).map(item => {
                    $(`[name='id_notification[${item}]']`).parent().addClass('checkbox-danger fill');
                    $(`[name='id_notification[${item}]']`).attr("disabled", true);
                });

                console.log('Notificações obrigatórias:', Object.keys(requiredNotifications));
            </script>
        @endpush


        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-notifications.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
