<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasSlug;
use App\Models\Permission;
use App\Traits\ConvertToModels;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase {
    use RefreshDatabase;

    /** @test  */
    public function roles_table_has_expected_columns()
    {
        $this->assertDatabaseHasColumns('roles', [
            'id',
            'title',
            'slug',
            'description',
            'removable',
            'created_at',
            'updated_at',
        ]);
    }

    /** @test */
    public function the_role_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertSubclassOf(Role::class, Base::class);
    }

    /** @test */
    public function the_role_model_must_use_the_convert_to_models_trait() {
        $this->assertClassUsesTrait(ConvertToModels::class, Role::class);
    }

    /** @test */
    public function the_role_model_must_use_the_has_slug_trait() {
        $this->assertClassUsesTrait(HasSlug::class, Role::class);
    }

    /** @test */
    public function the_casts_property_must_define_the_removable_column_as_a_boolean() {
        $value = $this->getClassProperty(new Role, 'casts');

        $this->assertTrue($value['removable'] == 'boolean');
    }

    /** @test */
    public function the_permissions_relation_must_be_preloaded() {
        $value = $this->getClassProperty(new Role, 'with');

        $this->assertTrue($value[0] == 'permissions');
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
