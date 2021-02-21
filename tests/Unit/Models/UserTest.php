<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Tests\Assertion;
use App\Traits\HasOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserTest extends TestCase
{
    use RefreshDatabase, Assertion;

    /** @test */
    public function the_user_model_must_be_an_authenticatable_user_subclass()
    {
        $this->assertTrue(is_subclass_of(User::class, Authenticatable::class));
    }

    /** @test */
    public function the_user_model_must_use_the_email_verification_interface()
    {
        $this->assertClassUsesInterface(MustVerifyEmail::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_soft_deletes_trait()
    {
        $this->assertClassUsesTrait(SoftDeletes::class, User::class);
    }

    /** @test */
    public function the_user_model_must_use_the_option_trait()
    {
        $this->assertClassUsesTrait(HasOptions::class, User::class);
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
    public function an_authenticated_user_must_return_their_full_name()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('options', [
            'optionable_id'   => $user->id,
            'optionable_type' => get_class($user),
        ]);

        $opt = $user->option;

        $this->assertEquals(
        	"{$opt->get('first_name')} {$opt->get('last_name')}",
        	$user->name
        );
    }
}
