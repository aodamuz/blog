<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
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
        $this->actingAs($this->user());

        $this->get(route('admin.dashboard'))
            ->assertForbidden()
        ;
    }

    /** @test */
    public function a_authenticated_user_with_access_can_see_the_admin_dashboard()
    {
        $this
            ->actingAs($this->authorUser())
            ->get(route('admin.dashboard'))
            ->assertOk()
        ;
    }
}
