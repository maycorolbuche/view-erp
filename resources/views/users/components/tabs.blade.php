@php
    $phones_count = $user->phones_count ?? ($data->phones_count ?? 0);
    $dependents_count = $user->dependents_count ?? ($data->dependents_count ?? 0);
    $parents_count = $user->parents_count ?? ($data->parents_count ?? 0);
    $childs_count = $user->childs_count ?? ($data->childs_count ?? 0);
    $active = $user->active ?? ($data->active ?? 0);

    $current_route = explode('.', Route::currentRouteName() ?? '')[0];
    $tabs = [
        [
            'title' => 'Cadastro',
            'name' => 'users',
            'resource' => isset($id) ? '.show' : null,
            'params' => isset($id) ? ['id' => $id] : null,
        ],
        [
            'title' => 'Telefones' . ($phones_count > 0 ? " <span class='badge badge-hero badge-info'>$phones_count</span>" : ''),
            'name' => 'users-phones',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Endereço',
            'name' => 'users-address',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Equipe' . ($parents_count > 0 ? " <span class='badge badge-hero badge-danger'>$parents_count</span>" : '') . ($childs_count > 0 ? " <span class='badge badge-hero badge-warning'>$childs_count</span>" : ''),
            'name' => 'users-teams',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Dependentes' . ($dependents_count > 0 ? " <span class='badge badge-hero badge-info'>$dependents_count</span>" : ''),
            'name' => 'users-dependents',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Admissão/Sociedade',
            'name' => 'users-admission',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Cargos/Funções',
            'name' => 'users-roles',
            'resource' => isset($id) ? '.index' : null,
            'params' => isset($id) ? ['pid' => $id] : null,
        ],
        [
            'title' => 'Usuário' . " <span class='badge badge-hero' style='padding: 0;background: initial;'><i class='fa fa-circle text-" . ($active ? 'info' : 'muted') . " fs12 pr5'></i></span>",
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
                    {!! $tab['title'] !!}
                </a>
            </li>
        @endif
    @endforeach
</x-tabs>
