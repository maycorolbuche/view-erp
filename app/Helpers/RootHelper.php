<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Permission;
use App\Models\Profile;
use App\Models\Route;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserProfile;

class RootHelper
{
    public static function run(): void
    {
        $routes = Route::select(['id_route', 'permissions'])->get();
        $routeIds = $routes->pluck('id_route');

        Permission::whereNotIn('id_route', $routeIds)->delete();

        foreach ($routes as $route) {
            Permission::updateOrCreate(
                ['id_route' => $route->id_route, 'id_user' => null, 'id_profile' => null],
                ['permissions' => $route->permissions]
            );
        }

        foreach (User::select(['id_user', 'root'])->get() as $user) {
            self::synchronizePermissions('id_user', $user->id_user, (bool) $user->root, $routes);
        }

        if (!Profile::where('root', true)->exists()) {
            Profile::create(['name' => 'Acesso Total', 'root' => true]);
        }

        foreach (Profile::select(['id_profile', 'root'])->get() as $profile) {
            self::synchronizePermissions('id_profile', $profile->id_profile, (bool) $profile->root, $routes);
        }

        self::synchronizeNotifications();
    }

    private static function synchronizePermissions(string $ownerColumn, int $ownerId, bool $root, $routes): void
    {
        $otherOwnerColumn = $ownerColumn === 'id_user' ? 'id_profile' : 'id_user';

        foreach ($routes as $route) {
            $attributes = [
                'id_route' => $route->id_route,
                $ownerColumn => $ownerId,
                $otherOwnerColumn => null,
            ];

            $permission = Permission::where($attributes)->first();

            if ($root) {
                Permission::updateOrCreate($attributes, ['permissions' => $route->permissions]);
            } elseif ($permission) {
                $permission->update([
                    'permissions' => array_values(array_intersect(
                        $permission->permissions ?? [],
                        $route->permissions ?? []
                    )),
                ]);
            }
        }
    }

    private static function synchronizeNotifications(): void
    {
        UserNotification::where('required', true)->update(['required' => false]);

        foreach (Notification::whereNotNull('id_route')->get() as $notification) {
            $userIds = Permission::where('id_route', $notification->id_route)
                ->whereNotNull('id_user')
                ->pluck('id_user');

            $profileIds = Permission::where('id_route', $notification->id_route)
                ->whereNotNull('id_profile')
                ->pluck('id_profile');

            $userIds = $userIds->merge(
                UserProfile::whereIn('id_profile', $profileIds)->pluck('id_user')
            )->unique();

            foreach ($userIds as $userId) {
                UserNotification::updateOrCreate(
                    ['id_user' => $userId, 'id_notification' => $notification->id_notification],
                    ['required' => true]
                );
            }
        }
    }
}
