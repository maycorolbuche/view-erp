@php
    $current_route = explode('.', Route::currentRouteName() ?? '')[0];
    $tabs = [
        [
            'title' => 'Cadastro',
            'name' => 'users',
            'resource' => isset($id) ? '.show' : null,
            'params' => isset($id) ? ['id' => $id] : null,
        ],
        [
            'title' => 'Endereço',
            'name' => 'users-address',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Usuário',
            'name' => 'users-access',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Sistemas',
            'name' => 'users-systems',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Perfis',
            'name' => 'users-profiles',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Permissões',
            'name' => 'users-permissions',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
    ];
@endphp
<x-tabs>
    @foreach ($tabs as $tab)
        @if (isset(request('__permissions_list')[$tab['name']]))
            <li class="{{ $current_route == $tab['name'] ? 'active' : '' }}">
                <a href="{{ route($tab['name'] . ($tab['resource'] ?? ''), $tab['params'] ?? null) }}">
                    {{ $tab['title'] }}
                </a>
            </li>
        @endif
    @endforeach
</x-tabs>
