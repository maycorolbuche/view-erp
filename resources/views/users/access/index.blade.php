@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            @if ($user->root == true)
                <x-note type="warning">
                    Este é um usuário do sistema. Ele não pode ser desativado!
                </x-note>
            @endif

            <x-form action-name="users-access" action="{{ route('users-access.update', compact('pid')) }}">
                <x-group>
                    <x-input type="email" name="email" width="400" label="E-mail" required
                        value="{{ $user->email ?? '' }}" />
                    <x-input type="text" name="username" width="400" label="Nome de Usuário" required
                        value="{{ $user->username ?? '' }}" />
                    <x-input type="text" name="password" width="200" label="Senha"
                        tip="Deixe em branco para não alterar." />
                    <x-input type="bool" name="active" width="100" label="Usuário Ativo"
                        value="{{ $user->active ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-access" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-access.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>

@endsection
