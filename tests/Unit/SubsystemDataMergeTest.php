<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class SubsystemDataMergeTest extends TestCase
{
    public function test_profiles_with_same_normalized_name_are_merged(): void
    {
        $migration = $this->migration();
        [$profiles, $map] = $this->invoke($migration, 'mergeProfiles', [[
            $this->profile(10, 'Financeiro', false),
            $this->profile(20, ' financeiro ', true),
        ]]);

        $this->assertCount(1, $profiles);
        $this->assertSame(10, $profiles[0]['id_profile']);
        $this->assertTrue($profiles[0]['root']);
        $this->assertSame([10 => 10, 20 => 10], $map);
    }

    public function test_permissions_are_combined_by_user_route(): void
    {
        $migration = $this->migration();
        $permissions = $this->invoke($migration, 'mergePermissions', [[
            $this->permission(5, 7, null, ['store']),
            $this->permission(5, 7, null, ['update', 'store']),
        ], []]);

        $this->assertCount(1, $permissions);
        $this->assertSame(['store', 'update'], json_decode($permissions[0]['permissions'], true));
    }

    public function test_permissions_of_merged_profiles_are_combined(): void
    {
        $migration = $this->migration();
        $permissions = $this->invoke($migration, 'mergePermissions', [[
            $this->permission(5, null, 10, ['index']),
            $this->permission(5, null, 20, ['update']),
        ], [10 => 10, 20 => 10]]);

        $this->assertCount(1, $permissions);
        $this->assertSame(10, $permissions[0]['id_profile']);
        $this->assertSame(['index', 'update'], json_decode($permissions[0]['permissions'], true));
    }

    public function test_obsolete_system_permissions_are_discarded(): void
    {
        $migration = $this->migration();
        $permissions = $this->invoke($migration, 'mergePermissions', [[
            $this->permission(1, 7, null, ['index']),
            $this->permission(2, 7, null, ['update']),
            $this->permission(18, 7, null, ['update']),
        ], []]);

        $this->assertSame([], $permissions);
    }

    public function test_duplicate_user_profile_links_are_removed_after_profile_merge(): void
    {
        $migration = $this->migration();
        $links = $this->invoke($migration, 'mergeUserProfiles', [[
            $this->userProfile(7, 10),
            $this->userProfile(7, 20),
        ], [10 => 10, 20 => 10]]);

        $this->assertCount(1, $links);
        $this->assertSame(7, $links[0]['id_user']);
        $this->assertSame(10, $links[0]['id_profile']);
    }

    private function migration(): object
    {
        return require __DIR__ . '/../../database/migrations/2026_09_09_180000_remove_systems_structure.php';
    }

    private function invoke(object $migration, string $method, array $arguments): mixed
    {
        $reflection = new ReflectionMethod($migration, $method);
        $reflection->setAccessible(true);

        return $reflection->invokeArgs($migration, $arguments);
    }

    private function profile(int $id, string $name, bool $root): object
    {
        return (object) [
            'id_profile' => $id,
            'name' => $name,
            'root' => $root,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => null,
            'updated_at' => null,
        ];
    }

    private function permission(int $route, ?int $user, ?int $profile, array $permissions): object
    {
        return (object) [
            'id_route' => $route,
            'id_user' => $user,
            'id_profile' => $profile,
            'permissions' => json_encode($permissions),
            'created_by' => null,
            'updated_by' => null,
            'created_at' => null,
            'updated_at' => null,
        ];
    }

    private function userProfile(int $user, int $profile): object
    {
        return (object) [
            'id_user' => $user,
            'id_profile' => $profile,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => null,
            'updated_at' => null,
        ];
    }
}
