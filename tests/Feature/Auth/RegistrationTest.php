<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Support\Config\ConfigKeys;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /*
    |-------------------------------------------------------------------------
    | Common
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    /** @test */
    public function new_users_can_register()
    {
        config([ConfigKeys::AUTO_LOGIN => true]);

        $response = $this->post(route('register'), $this->credentials());

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /*
    |-------------------------------------------------------------------------
    | First Name
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['first_name' => null]])
        )->assertSessionHasErrors('option.first_name');
    }

    /** @test */
    public function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['first_name' => 1234]])
        )->assertSessionHasErrors('option.first_name');
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_20_characters()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['first_name' => Str::random(21)]])
        )->assertSessionHasErrors('option.first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['first_name' => 'as']])
        )->assertSessionHasErrors('option.first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['first_name' => 'User2']])
        )->assertSessionHasErrors('option.first_name');

        $this->post(
            route('register'),
            $this->credentials(['option' => ['first_name' => 'User<>']])
        )->assertSessionHasErrors('option.first_name');
    }

    // Last Name

    /** @test */
    public function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['last_name' => null]])
        )->assertSessionHasErrors('option.last_name');
    }

    /** @test */
    public function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['last_name' => 1234]])
        )->assertSessionHasErrors('option.last_name');
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_20_characters()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['last_name' => Str::random(21)]])
        )->assertSessionHasErrors('option.last_name');
    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['last_name' => 'as']])
        )->assertSessionHasErrors('option.last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->credentials(['option' => ['last_name' => 'User2']])
        )->assertSessionHasErrors('option.last_name');

        $this->post(
            route('register'),
            $this->credentials(['option' => ['last_name' => 'User<>']])
        )->assertSessionHasErrors('option.last_name');
    }

    /*
    |-------------------------------------------------------------------------
    | Email
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function email_is_required()
    {
        $response = $this->post(route('register'), $this->credentials([
            'email' => ''
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function email_cannot_be_longer_than_255_characters()
    {
        $response = $this->post(route('register'), $this->credentials([
            'email' => Str::random(256)
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $user = User::factory()->create(['email' => 'email@test.com']);

        $response = $this->post(route('register'), $this->credentials([
            'email' => 'email@test.com'
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_valid()
    {
        $response = $this->post(route('register'), $this->credentials([
            'email' => 'TestAccount@'
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /*
    |-------------------------------------------------------------------------
    | Password
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->credentials(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->credentials(['password' => 1234])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_8_characters_long()
    {
        $this->post(
            route('register'),
            $this->credentials(['password' => 'asdfgaa'])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->credentials([
                'password'              => 'password',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    protected function credentials($overwrite = [])
    {
        return array_merge([
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'option'                => [
                'first_name' => 'FIRST',
                'last_name'  => 'LAST',
            ]
        ], $overwrite);
    }
}
