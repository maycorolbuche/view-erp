@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('systems.components.header', compact('system'))

            @include('systems.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            @if ($system->root == true)
                <blockquote class="blockquote-warning">
                    <p>Este é o sistema principal. Não é possível alterar as permissões dele.</p>
                </blockquote>
            @endif

            <x-form action-name="systems-permissions" action="{{ route('systems-permissions.update', compact('pid')) }}">
                @foreach ($routes as $group)
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="panel-title">
                                <i class="{{ $group->icon }}"></i>
                                {{ $group->label }}
                            </span>
                        </div>
                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Módulo</th>
                                        <th>Cadastrar</th>
                                        <th>Alterar</th>
                                        <th>Excluir</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($group->routes as $route)
                                            <tr>
                                                <td class="text-left" style="width:100%">
                                                    <div class="checkbox-custom">
                                                        <input type="checkbox" id="route_{{ $route->id_route }}"
                                                            name="route[{{ $route->id_route }}]"
                                                            {{ isset($permissions[$route->id_route]) ? 'checked' : '' }}>
                                                        <label for="route_{{ $route->id_route }}">
                                                            <i class="{{ $route->icon }}"></i>
                                                            &nbsp;{{ $route->label }}
                                                        </label>
                                                    </div>
                                                </td>

                                                <td class="text-right">
                                                    <div class="checkbox-custom checkbox-info fill">
                                                        @if (in_array('store', $route->permissions))
                                                            <input type="checkbox" id="store_{{ $route->id_route }}"
                                                                name="store[{{ $route->id_route }}]"
                                                                {{ isset($permissions[$route->id_route]) && in_array('store', $permissions[$route->id_route]->permissions) ? 'checked' : '' }}>
                                                            <label for="store_{{ $route->id_route }}">&nbsp;</label>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="checkbox-custom checkbox-warning fill">
                                                        @if (in_array('update', $route->permissions))
                                                            <input type="checkbox" id="update_{{ $route->id_route }}"
                                                                name="update[{{ $route->id_route }}]"
                                                                {{ isset($permissions[$route->id_route]) && in_array('update', $permissions[$route->id_route]->permissions) ? 'checked' : '' }}>
                                                            <label for="update_{{ $route->id_route }}">&nbsp;</label>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="checkbox-custom checkbox-danger fill">
                                                        @if (in_array('destroy', $route->permissions))
                                                            <input type="checkbox" id="destroy_{{ $route->id_route }}"
                                                                name="destroy[{{ $route->id_route }}]"
                                                                {{ isset($permissions[$route->id_route]) && in_array('destroy', $permissions[$route->id_route]->permissions) ? 'checked' : '' }}>
                                                            <label for="destroy_{{ $route->id_route }}">&nbsp;</label>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

                <x-group right>
                    <x-button type="update" disabled="{{ $system->root }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="systems-permissions" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('systems.components.datatable', [
                'route' => 'systems-permissions.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
