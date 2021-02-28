<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
        $this->createPermissions();

        $this->assignAccessPermissions();
        $this->assignPermissionsToTheAdminRole();
        $this->assignPermissionsToTheWriterRole();
    }

    protected function createRoles()
    {
        foreach (config('permissions.roles') as $attributes) {
            Role::create($attributes);
        }
    }

    protected function createPermissions()
    {
        $description = 'Permission to access the administration panel.';

        Permission::create([
            'slug'        => config('permissions.access_key'),
            'title'       => 'Administration access',
            'description' => $description,
        ]);

        foreach (config('permissions.permissions') as $resource => $values) {
            foreach ($values as $attributes) {
                Permission::create($attributes);
            }
        }
    }

    protected function assignAccessPermissions()
    {
        // Assign admin panel access to all roles except
        // the user role and super admin role.
        Role::whereNotIn('slug', ['user', 'global'])
            ->get()
            ->map->assignPermissions(config('permissions.access_key'))
        ;
    }

    protected function assignPermissionsToTheAdminRole()
    {
        Role::whereSlug('admin')
            ->first()
            ->permissions()
            ->sync(
                Permission::pluck('id')
            )
        ;
    }

    protected function assignPermissionsToTheWriterRole()
    {
        $permissions = $this->filterPermissions([
            "tags",
            "posts",
            "categories",
        ], true, [
            'post-manager',
            'category-manager',
            'tag-manager',
        ]);

        Role::whereSlug('author')
            ->first()
            ->permissions()
            ->sync(
                $permissions->pluck('id')
            )
        ;
    }

    protected function filterPermissions(array $resources, $withAccess = false, $except = null)
    {
        $values = collect(config('permissions.permissions'))
            ->only($resources)
            ->values()
            ->collapse()
            ->pluck('title')
            ->map(function($title) use ($except) {
                $title = Str::slug($title);

                if (!is_null($except) && is_array($except)) {
                    if (in_array($title, $except)) {
                        return;
                    }
                }

                return $title;
            })
            ->filter()
            ->toArray()
        ;

        if ($withAccess) {
            $values[] = config('permissions.access_key');
        }

        return Permission::whereIn('slug', $values)->get();
    }
}
