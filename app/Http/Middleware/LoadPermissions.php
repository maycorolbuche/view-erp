<?php

namespace App\Http\Middleware;

use App\Helpers\AuthorizationHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadPermissions
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $permissions = $user->load('permissions.route.route_group')->permissions->toArray();

        foreach ($user->load('profiles.permissions.route.route_group')->profiles as $profile) {
            $permissions = array_merge($permissions, $profile->permissions->toArray());
        }

        $permissionsList = [];
        $permissionsGroup = [];

        foreach ($permissions as $permission) {
            if (empty($permission['route']) || empty($permission['route']['route_group'])) {
                continue;
            }

            $groupKey = str_pad($permission['route']['route_group']['sequence'], 6, '0', STR_PAD_LEFT)
                . '-' . $permission['route']['route_group']['id_route_group'];
            $routeKey = str_pad($permission['route']['sequence'], 6, '0', STR_PAD_LEFT)
                . '-' . $permission['route']['id_route'];

            $permissionsGroup[$groupKey]['label'] = $permission['route']['route_group']['label'];
            $permissionsGroup[$groupKey]['icon'] = $permission['route']['route_group']['icon'];
            $permissionsGroup[$groupKey]['items'][$routeKey] = $permission;
            ksort($permissionsGroup[$groupKey]['items']);

            $permissionsList[$permission['route']['name']] = array_values(array_unique(array_merge(
                $permissionsList[$permission['route']['name']] ?? [],
                $permission['permissions'] ?? []
            )));
        }

        ksort($permissionsGroup);

        $request->merge([
            '__permissions' => $permissionsGroup,
            '__permissions_list' => $permissionsList,
            '__count_authorization' => AuthorizationHelper::pending_count(),
        ]);

        return $next($request);
    }
}
