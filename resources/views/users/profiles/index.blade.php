@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            @if (!$has_access)
                <x-note type="danger">
                    Este usuário não tem acesso ao sistema {{ request('__system')['name'] }}. Autorize o acesso a este
                    sistema primeiro!
                </x-note>
            @else
                @if ($user->root == true)
                    <x-note type="warning">
                        Este é um usuário raiz. Não é possível alterar os perfis.
                    </x-note>
                @endif

                <x-form action-name="users-profiles" action="{{ route('users-profiles.update', compact('pid')) }}">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="panel-title">
                                Lista de Perfis
                            </span>
                            <span class="panel-title" style="float: right;">
                                <i class='{{ request('__system')['icon'] }}'></i>
                                {{ request('__system')['name'] }}
                            </span>
                        </div>
                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        @foreach ($profiles as $profile)
                                            <tr>
                                                <td class="text-left {{ $profile->root ? 'warning' : '' }}"
                                                    style="width:100%">
                                                    <div
                                                        class="checkbox-custom {{ $profile->root ? 'checkbox-warning' : '' }}">
                                                        <input type="checkbox" id="profile_{{ $profile->id_profile }}"
                                                            name="profile[{{ $profile->id_profile }}]"
                                                            {{ isset($users_profiles[$profile->id_profile]) ? 'checked' : '' }}>
                                                        <label for="profile_{{ $profile->id_profile }}">
                                                            {{ $profile->name }}
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <x-group right>
                        <x-button type="update" disabled="{{ $user->root }}"
                            permission="{{ in_array('update', request('__permissions_page')) }}" />
                        <x-button type="cancel" route-name="users-profiles" />
                    </x-group>
                </x-form>

            @endif

        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-profiles.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
