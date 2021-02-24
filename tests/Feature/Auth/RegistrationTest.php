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

    /** @test */
    public function registration_screen_can_be_rendered()
    {
        $this->get(
            route('register')
        )->assertStatus(200);
    }

    /** @test */
    public function new_users_can_register()
    {
        $this->withoutExceptionHandling();
        config([ConfigKeys::AUTO_LOGIN => true]);

        $this->post(
            route('register'),
            $this->data()
        )->assertRedirect(
            RouteServiceProvider::HOME
        );

        $this->assertAuthenticated();
    }

    /** @test */
    public function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['first_name' => null]])
        )->assertSessionHasErrors('options.first_name');
    }

    /** @test */
    public function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['first_name' => 1234]])
        )->assertSessionHasErrors('options.first_name');
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_20_characters()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['first_name' => Str::random(21)]])
        )->assertSessionHasErrors('options.first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['first_name' => 'as']])
        )->assertSessionHasErrors('options.first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['first_name' => 'User2']])
        )->assertSessionHasErrors('options.first_name');

        $this->post(
            route('register'),
            $this->data(['options' => ['first_name' => 'User<>']])
        )->assertSessionHasErrors('options.first_name');
    }

    /** @test */
    public function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['last_name' => null]])
        )->assertSessionHasErrors('options.last_name');
    }

    /** @test */
    public function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['last_name' => 1234]])
        )->assertSessionHasErrors('options.last_name');
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_20_characters()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['last_name' => Str::random(21)]])
        )->assertSessionHasErrors('options.last_name');
    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['last_name' => 'as']])
        )->assertSessionHasErrors('options.last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->data(['options' => ['last_name' => 'User2']])
        )->assertSessionHasErrors('options.last_name');

        $this->post(
            route('register'),
            $this->data(['options' => ['last_name' => 'User<>']])
        )->assertSessionHasErrors('options.last_name');
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->post(route('register'), $this->data([
            'email' => ''
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function email_cannot_be_longer_than_255_characters()
    {
        $response = $this->post(route('register'), $this->data([
            'email' => Str::random(256)
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $user = User::factory()->create(['email' => 'email@test.com']);

        $response = $this->post(route('register'), $this->data([
            'email' => 'email@test.com'
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_valid()
    {
        $response = $this->post(route('register'), $this->data([
            'email' => 'TestAccount@'
        ]));

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->data(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->data(['password' => 1234])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_8_characters_long()
    {
        $this->post(
            route('register'),
            $this->data(['password' => 'asdfgaa'])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->data([
                'password'              => 'password',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    protected function data($overwrite = [])
    {
        return array_merge([
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'options' => [
                'first_name' => 'FIRST',
                'last_name' => 'LAST',
            ]
        ], $overwrite);
    }
}
