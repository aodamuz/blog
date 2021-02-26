<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered()
    {
        $this->get(route('login'))->assertOk();
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen()
    {
        $this->post(route('login'), [
            'email' => User::factory()->create()->email,
            'password' => 'password',
        ])->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticated();
    }

    /** @test */
    public function users_cannot_authenticate_with_an_invalid_password()
    {
        $this->post(route('login'), [
            'email' => User::factory()->create()->email,
            'password' => 'invalid-password',
        ]);

        $this->assertGuest();
    }
}
