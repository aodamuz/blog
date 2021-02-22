<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Post;
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

    /** @test */
    public function a_user_has_many_posts()
    {
        // Create additional users to make sure that
        // the posts belong to the expected user.
        User::factory()->times(3)->create();

        $user = User::factory()->create();

        $posts = Post::factory()->times(5)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals(
            $posts->pluck('id')->toArray(),
            $user->posts->pluck('id')->toArray()
        );
    }
}
