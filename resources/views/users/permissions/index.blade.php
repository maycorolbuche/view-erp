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
                    Este é um perfil do sistema. Não é possível alterar as permissões.
                </x-note>
            @endif

            <x-form action-name="users-permissions" action="{{ route('users-permissions.update', compact('pid')) }}">
                @foreach ($routes as $group)
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="panel-title">
                                <i class="{{ $group->icon }}"></i>
                                {{ $group->label }}
                            </span>
                            @if ($group->note != '')
                                <div class="widget-menu pull-right">
                                    <code class="mr10  p3 ph5"><b>Nota:</b> {{ $group->note }}</code>
                                </div>
                            @endif
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
                                            @php
                                                $route_permissions =
                                                    $route->toArray()['permissions'][0]['permissions'] ?? [];
                                            @endphp
                                            <tr>
                                                <td class="text-left" style="width:100%">
                                                    <div
                                                        class="checkbox-custom {{ isset($permissions_profiles[$route->id_route]) ? 'fill' : '' }}">
                                                        <input type="checkbox" id="route_{{ $route->id_route }}"
                                                            data-id="{{ $route->id_route }}"
                                                            name="route[{{ $route->id_route }}]"
                                                            {{ isset($permissions[$route->id_route]) ? 'checked' : '' }}>
                                                        <label for="route_{{ $route->id_route }}">
                                                            <i class="{{ $route->icon }}"></i>
                                                            &nbsp;{{ $route->label }}
                                                        </label>
                                                    </div>
                                                    @if (isset($permissions_profiles[$route->id_route]))
                                                        <div style='padding-left: 35px;'>
                                                            @foreach ($permissions_profiles[$route->id_route] as $perm)
                                                                <span class='badge text-bg-warning small'
                                                                    style='font-size:9px;'>
                                                                    {{ $perm['profile']['name'] }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>

                                                <td class="text-right">
                                                    @php
                                                        $active = false;
                                                    @endphp
                                                    @if (isset($permissions_profiles[$route->id_route]))
                                                        @foreach ($permissions_profiles[$route->id_route] as $perm)
                                                            @if (in_array('store', $perm['permissions']))
                                                                @php
                                                                    $active = true;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <div class="checkbox-custom checkbox-info {{ $active ? 'fill' : '' }}">
                                                        @if (in_array('store', $route_permissions))
                                                            <input type="checkbox" id="store_{{ $route->id_route }}"
                                                                data-id="{{ $route->id_route }}"
                                                                name="store[{{ $route->id_route }}]"
                                                                {{ isset($permissions[$route->id_route]) && in_array('store', $permissions[$route->id_route]->permissions) ? 'checked' : '' }}>
                                                            <label for="store_{{ $route->id_route }}">&nbsp;</label>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    @php
                                                        $active = false;
                                                    @endphp
                                                    @if (isset($permissions_profiles[$route->id_route]))
                                                        @foreach ($permissions_profiles[$route->id_route] as $perm)
                                                            @if (in_array('update', $perm['permissions']))
                                                                @php
                                                                    $active = true;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <div
                                                        class="checkbox-custom checkbox-warning {{ $active ? 'fill' : '' }}">
                                                        @if (in_array('update', $route_permissions))
                                                            <input type="checkbox" id="update_{{ $route->id_route }}"
                                                                data-id="{{ $route->id_route }}"
                                                                name="update[{{ $route->id_route }}]"
                                                                {{ isset($permissions[$route->id_route]) && in_array('update', $permissions[$route->id_route]->permissions) ? 'checked' : '' }}>
                                                            <label for="update_{{ $route->id_route }}">&nbsp;</label>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    @php
                                                        $active = false;
                                                    @endphp
                                                    @if (isset($permissions_profiles[$route->id_route]))
                                                        @foreach ($permissions_profiles[$route->id_route] as $perm)
                                                            @if (in_array('destroy', $perm['permissions']))
                                                                @php
                                                                    $active = true;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <div
                                                        class="checkbox-custom checkbox-danger {{ $active ? 'fill' : '' }}">
                                                        @if (in_array('destroy', $route_permissions))
                                                            <input type="checkbox" id="destroy_{{ $route->id_route }}"
                                                                data-id="{{ $route->id_route }}"
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
                    <x-button type="update" disabled="{{ $user->root }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-permissions" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-permissions.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $("[name^='route']").change(function() {
                    let id = $(this).data("id");
                    let checked = $(this).is(":checked");

                    $(`[name='store[${id}]'`).prop('checked', checked);
                    $(`[name='update[${id}]'`).prop('checked', checked);
                    $(`[name='destroy[${id}]'`).prop('checked', checked);
                });
                $("[name^='store'],[name^='update'],[name^='destroy']").change(function() {
                    if ($(this).is(":checked")) {
                        let id = $(this).data("id");

                        $(`[name='route[${id}]'`).prop('checked', true);
                    }
                });
            });
        </script>
    @endpush
@endsection
