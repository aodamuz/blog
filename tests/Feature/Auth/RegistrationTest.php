<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
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
