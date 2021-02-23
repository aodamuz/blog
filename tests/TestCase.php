<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function newUser($role, array $attributes = [])
    {
		$this->seed(RoleSeeder::class);

		$user = User::factory()->create($attributes);

		return $user->assignRole($role);
    }

    public function user(array $attributes = [])
    {
    	return $this->newUser('user', $attributes);
    }

    public function globalUser(array $attributes = [])
    {
    	return $this->newUser('global', $attributes);
    }

    public function adminUser(array $attributes = [])
    {
    	return $this->newUser('admin', $attributes);
    }
}
