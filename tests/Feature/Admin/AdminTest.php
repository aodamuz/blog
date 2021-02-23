<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

	/** @test */
	public function a_guest_user_cannot_access_the_administration()
	{
		$this->get(route('admin.dashboard'))
			->assertRedirect(route('login'))
		;
	}

	/** @test */
	public function an_authenticated_user_without_access_cannot_see_the_admin_dashboard() {
		$this->seed(RoleSeeder::class);

		$user = User::factory()->create();

		$user->assignRole('user');

		$this->assertTrue($user->hasRole('user'));

		$this->actingAs($user);

		$this->assertAuthenticated();

		$this->get(route('admin.dashboard'))
			->assertStatus(Response::HTTP_FORBIDDEN)
		;
	}

    /** @test */
    public function a_authenticated_user_with_access_can_see_the_admin_dashboard()
    {
        $this
            ->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
        ;
    }
}
