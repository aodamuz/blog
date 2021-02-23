<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Role;
use App\Models\User;
use Tests\Assertion;
use App\Models\Permission;
use App\Traits\ConvertToModels;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase {
    use RefreshDatabase, Assertion;

    /** @test */
    public function the_role_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Role::class, Base::class));
    }

    /** @test */
    public function a_role_model_must_use_the_trait_convert_to_models() {
        $this->assertClassUsesTrait(ConvertToModels::class, Role::class);
    }

    /** @test */
    public function a_role_has_many_users() {
        $user = User::factory()
            ->forRole([
                'slug' => 'foo',
            ])
            ->create();

        $this->assertEquals($user->fresh()->role->slug, Role::first()->slug);
        $this->assertInstanceOf(User::class, Role::first()->users->first());
    }

    /** @test */
    public function a_role_belongs_to_many_permissions() {
        $role = Role::factory()
            ->hasPermissions()
            ->create();

        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    /** @test */
    public function a_non_removable_role_cannot_be_deleted() {
        $role = Role::factory()->create(['removable' => false]);

        $this->assertFalse($role->delete());
        $this->assertTrue($role->exists);
    }
}
