<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RoleSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('permissions.roles') as $value) {
            Role::create($value);
        }

        $permissions[] = Permission::create([
            'slug' => config('permissions.access_key'),
            'title' => 'Administration access',
            'description' => 'Users with a role that has this permission can access the administration.',
        ]);

        Role::whereSlug('translator')
            ->first()
            ->permissions()
            ->saveMany($permissions)
        ;

        foreach (config('permissions.resources') as $resource) {
            $permissions[] = Permission::create([
                'title' => ucfirst(Str::singular($resource)) . ' Manager',
                'description' => "The user with a role that contains this permission can manage {$resource}.",
            ]);

            foreach (['view any', 'view', 'create', 'update', 'delete'] as $ability) {
                $resource = Str::plural($resource);

                if ($ability === 'view any') {
                    $resource = Str::singular($resource);
                }

                $title = ucwords("{$ability} {$resource}");

                $description = "The user with a role that contains this permission can {$ability} {$resource}.";

                $permissions[] = Permission::create(compact('title', 'description'));
            }
        }

        $editorPermissions = Permission::where('slug', 'LIKE', '%post%')
                                       ->orWhere('slug', 'LIKE', '%access%')
                                       ->orWhere('slug', 'LIKE', '%categor%')
                                       ->orWhere('slug', 'LIKE', '%tags%')->get();

        Role::whereSlug('editor')
            ->first()
            ->permissions()
            ->saveMany(
                $editorPermissions
            )
        ;

        Role::whereSlug('admin')
            ->first()
            ->permissions()
            ->saveMany($permissions)
        ;
    }
}
