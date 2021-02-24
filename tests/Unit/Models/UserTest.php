<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            "{$user->get('first_name')} {$user->get('last_name')}",
            $user->name
        );
    }
}
