<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Role;
use App\Traits\HasSlug;
use App\Models\Permission;
use App\Traits\ConvertToModels;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function the_permission_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Permission::class, Base::class));
    }

    /** @test */
    public function the_permission_model_must_use_the_has_slug_trait() {
        $this->assertClassUsesTrait(HasSlug::class, Permission::class);
    }

	/** @test */
	public function a_permission_belongs_to_many_roles() {
		$role = Role::factory()->create();
		$permission = Permission::factory()->create();

		$role->assignPermissions($permission);

		$this->assertInstanceOf(Role::class, $permission->roles->first());
	}
}
