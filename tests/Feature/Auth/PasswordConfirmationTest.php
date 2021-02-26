<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function confirm_password_screen_can_be_rendered()
    {
        $this->actingAs(
            User::factory()->create()
        )->get(
            route('password.confirm')
        )->assertOk();
    }

    /** @test */
    public function password_can_be_confirmed()
    {
        $this->actingAs(
            User::factory()->create()
        )->post(route('password.confirm'), [
            'password' => 'password',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_is_not_confirmed_with_invalid_password()
    {
        $this->actingAs(
            User::factory()->create()
        )->post(route('password.confirm'), [
            'password' => 'wrong-password',
        ])->assertSessionHasErrors();
    }
}
