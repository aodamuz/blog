<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('demo');

        User::factory()->create([
            'email' => 'user@email.test',
            'password' => $password,
        ]);

        User::factory()->create([
            'email' => 'admin@email.test',
            'password' => $password,
        ])->assignRole('admin');

        User::factory()->create([
            'email' => 'global@email.test',
            'password' => $password,
        ])->assignRole('global');
    }
}
