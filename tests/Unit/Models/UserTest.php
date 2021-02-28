<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Traits\HasRole;
use App\Traits\HasCountry;
use App\Traits\HasOptions;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function users_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'email',
                'email_verified_at',
                'password',
                'remember_token',
                'options',
                'role_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }

    /** @test */
    public function the_user_model_must_be_an_authenticatable_user_subclass()
    {
        $this->assertTrue(
            is_subclass_of(User::class, Authenticatable::class)
        );
    }

    /** @test */
    public function the_user_model_must_use_the_email_verification_interface()
    {
        $this->assertClassUsesInterface(
            MustVerifyEmail::class,
            User::class
        );
    }

    /** @test */
    public function the_user_model_must_use_the_soft_deletes_trait()
    {
        $this->assertClassUsesTrait(SoftDeletes::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_cachable_trait()
    {
        $this->assertClassUsesTrait(Cachable::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_notifiable_trait()
    {
        $this->assertClassUsesTrait(Notifiable::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_has_country_trait()
    {
        $this->assertClassUsesTrait(HasCountry::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_has_role_trait()
    {
        $this->assertClassUsesTrait(HasRole::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_has_options_trait()
    {
        $this->assertClassUsesTrait(HasOptions::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_has_factory_trait()
    {
        $this->assertClassUsesTrait(HasFactory::class, User::class);
    }

    /** @test */
    public function a_user_must_return_their_full_name()
    {
        $user = User::factory()->create([
            'options' => [
                'first_name' => 'FIRST',
                'last_name' => 'LAST',
            ]
        ]);

        $this->assertEquals(
            "FIRST LAST",
            $user->name
        );

        $this->assertEquals(
            "{$user->option('first_name')} {$user->option('last_name')}",
            $user->name
        );
    }

    /** @test */
    public function a_user_must_belong_to_a_role() {
        $this->assertInstanceOf(Role::class, $this->user()->role);
    }

    /** @test */
    public function a_user_must_belong_to_a_country() {
        $country = Country::factory()->create();
        $user = $this->user(['country_id' => $country->id]);

        $this->assertEquals($country->id, $user->id);
        $this->assertInstanceOf(Country::class, $user->country);
    }

    /** @test */
    public function a_user_can_have_a_role() {
        $this->seed(RoleSeeder::class);

        $this->assertFalse(
            User::factory()
                ->create()
                ->assignRole('user')
                ->isAdmin()
        );

        $this->assertTrue(
            User::factory()
                ->create()
                ->assignRole('admin')
                ->isAdmin()
        );

        $this->assertTrue(
            User::factory()
                ->create()
                ->assignRole('global')
                ->isSuperAdmin()
        );
    }

    /** @test */
    public function a_user_can_have_permissions_through_their_role() {
        $user = $this->authorUser();

        $this->assertTrue(
            $user->hasPermission('view-posts')
        );
    }
}
