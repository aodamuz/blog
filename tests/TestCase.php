<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Assertion, CreatesApplication;

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

    public function authorUser(array $attributes = [])
    {
        return $this->newUser('author', $attributes);
    }

    public function newUser($role, array $attributes = [])
    {
        $this->seed(RoleSeeder::class);

        return User::factory()->create(
            $attributes
        )->assignRole($role);
    }
}
