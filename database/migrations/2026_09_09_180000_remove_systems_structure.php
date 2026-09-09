<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $profiles = DB::table('profiles')->orderBy('id_profile')->get();
        $permissions = DB::table('permissions')->orderBy('id_permission')->get();
        $userProfiles = DB::table('users_profiles')->orderBy('id_user_profile')->get();

        [$mergedProfiles, $profileMap] = $this->mergeProfiles($profiles);
        $mergedPermissions = $this->mergePermissions($permissions, $profileMap);
        $mergedUserProfiles = $this->mergeUserProfiles($userProfiles, $profileMap);

        Schema::disableForeignKeyConstraints();

        Schema::drop('permissions');
        Schema::drop('users_profiles');
        Schema::drop('users_systems');
        Schema::drop('profiles');
        Schema::drop('systems');

        DB::table('routes')->whereIn('id_route', [1, 2, 18])->delete();
        DB::table('routes_groups')->where('id_route_group', 1)->delete();

        $this->createProfilesTable();
        $this->createUserProfilesTable();
        $this->createPermissionsTable();

        if ($mergedProfiles !== []) {
            DB::table('profiles')->insert($mergedProfiles);
        }

        if ($mergedUserProfiles !== []) {
            DB::table('users_profiles')->insert($mergedUserProfiles);
        }

        if ($mergedPermissions !== []) {
            DB::table('permissions')->insert($mergedPermissions);
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        throw new RuntimeException('A remoção de subsistemas consolida dados e não pode ser revertida automaticamente.');
    }

    private function mergeProfiles($profiles): array
    {
        $merged = [];
        $profileMap = [];

        foreach ($profiles as $profile) {
            $key = mb_strtolower(trim($profile->name));

            if (!isset($merged[$key])) {
                $merged[$key] = [
                    'id_profile' => $profile->id_profile,
                    'name' => $profile->name,
                    'root' => (bool) $profile->root,
                    'created_by' => $profile->created_by,
                    'updated_by' => $profile->updated_by,
                    'created_at' => $profile->created_at,
                    'updated_at' => $profile->updated_at,
                ];
            } else {
                $merged[$key]['root'] = $merged[$key]['root'] || (bool) $profile->root;
            }

            $profileMap[$profile->id_profile] = $merged[$key]['id_profile'];
        }

        return [array_values($merged), $profileMap];
    }

    private function mergePermissions($permissions, array $profileMap): array
    {
        $merged = [];

        foreach ($permissions as $permission) {
            if (in_array((int) $permission->id_route, [1, 2, 18], true)) {
                continue;
            }

            if ($permission->id_user !== null) {
                $ownerType = 'user';
                $ownerId = $permission->id_user;
            } elseif ($permission->id_profile !== null) {
                $ownerType = 'profile';
                $ownerId = $profileMap[$permission->id_profile] ?? $permission->id_profile;
            } else {
                $ownerType = 'default';
                $ownerId = 0;
            }

            $key = $permission->id_route . ':' . $ownerType . ':' . $ownerId;
            $values = json_decode($permission->permissions, true);
            $values = is_array($values) ? $values : [];

            if (!isset($merged[$key])) {
                $merged[$key] = [
                    'id_route' => $permission->id_route,
                    'id_user' => $ownerType === 'user' ? $ownerId : null,
                    'id_profile' => $ownerType === 'profile' ? $ownerId : null,
                    'permissions' => [],
                    'created_by' => $permission->created_by,
                    'updated_by' => $permission->updated_by,
                    'created_at' => $permission->created_at,
                    'updated_at' => $permission->updated_at,
                ];
            }

            $merged[$key]['permissions'] = array_values(array_unique(array_merge(
                $merged[$key]['permissions'],
                $values
            )));
        }

        foreach ($merged as &$permission) {
            $permission['permissions'] = json_encode($permission['permissions']);
        }

        return array_values($merged);
    }

    private function mergeUserProfiles($userProfiles, array $profileMap): array
    {
        $merged = [];

        foreach ($userProfiles as $userProfile) {
            $profileId = $profileMap[$userProfile->id_profile] ?? $userProfile->id_profile;
            $key = $userProfile->id_user . ':' . $profileId;

            if (!isset($merged[$key])) {
                $merged[$key] = [
                    'id_user' => $userProfile->id_user,
                    'id_profile' => $profileId,
                    'created_by' => $userProfile->created_by,
                    'updated_by' => $userProfile->updated_by,
                    'created_at' => $userProfile->created_at,
                    'updated_at' => $userProfile->updated_at,
                ];
            }
        }

        return array_values($merged);
    }

    private function createProfilesTable(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id_profile');
            $table->string('name');
            $table->boolean('root')->default(false);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id_user')->on('users');
            $table->foreign('updated_by')->references('id_user')->on('users');
        });
    }

    private function createUserProfilesTable(): void
    {
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->increments('id_user_profile');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_profile');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_profile')->references('id_profile')->on('profiles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('created_by')->references('id_user')->on('users');
            $table->foreign('updated_by')->references('id_user')->on('users');
            $table->unique(['id_user', 'id_profile']);
        });
    }

    private function createPermissionsTable(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id_permission');
            $table->unsignedInteger('id_route');
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_profile')->nullable();
            $table->text('permissions');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_route')->references('id_route')->on('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_profile')->references('id_profile')->on('profiles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('created_by')->references('id_user')->on('users');
            $table->foreign('updated_by')->references('id_user')->on('users');
            $table->unique(['id_route', 'id_user']);
            $table->unique(['id_route', 'id_profile']);
        });
    }
};
