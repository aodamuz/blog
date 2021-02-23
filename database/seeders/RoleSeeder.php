<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
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
        foreach (config('permissions.roles') as $value) {
            Role::create($value);
        }

        $permissions[] = Permission::create([
            'slug'        => 'access',
            'title'       => 'Administration access',
            'description' => 'Users with a role that has this permission can access the administration.',
        ]);

        foreach (config('permissions.resources') as $value) {
            $permissions[] = Permission::create([
                'title'       => ucfirst($value) . ' Manager',
                'description' => "The user with a role that contains this permission can manage {$value}.",
            ]);
        }

        Role::whereSlug('admin')
            ->first()
            ->permissions()
            ->saveMany($permissions)
        ;
    }
}
