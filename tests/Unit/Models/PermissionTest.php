<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Role;
use Tests\Assertion;
use App\Models\Permission;
use App\Traits\ConvertToModels;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase {
    use RefreshDatabase, Assertion;

    /** @test */
    public function the_permission_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Permission::class, Base::class));
    }

	/** @test */
	public function a_permission_model_must_use_the_trait_convert_to_models() {
		$this->assertClassUsesTrait(ConvertToModels::class, Permission::class);
	}

	/** @test */
	public function a_permission_belongs_to_many_roles() {
		$role       = Role::factory()->create();
		$permission = Permission::factory()->create();

		$role->assignPermissions($permission);

		$this->assertInstanceOf(Role::class, $permission->roles->first());
	}
}
