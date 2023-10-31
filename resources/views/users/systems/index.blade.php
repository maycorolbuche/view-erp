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
                <blockquote class="blockquote-warning">
                    <p>Este é um usuário raiz. Não é possível alterar os sistemas.</p>
                </blockquote>
            @endif

            <x-form action-name="users-systems" action="{{ route('users-systems.update', compact('pid')) }}">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <span class="panel-title">
                            Lista de Sistemas
                        </span>
                    </div>
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @foreach ($systems as $system)
                                        <tr>
                                            <td class="text-left {{ $system->root ? 'warning' : '' }}" style="width:100%">
                                                <div class="checkbox-custom {{ $system->root ? 'checkbox-warning' : '' }}">
                                                    <input type="checkbox" id="system_{{ $system->id_system }}"
                                                        name="system[{{ $system->id_system }}]"
                                                        {{ isset($users_systems[$system->id_system]) ? 'checked' : '' }}>
                                                    <label for="system_{{ $system->id_system }}">
                                                        <i class="{{ $system->icon }}"></i>
                                                        &nbsp;{{ $system->name }}
                                                        &nbsp;<span class='badge badge-info'>/{{ $system->slug }}</span>
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
                    <x-button type="cancel" route-name="users-systems" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-systems.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
