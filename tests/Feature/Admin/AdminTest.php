<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_screen_can_be_rendered() {
        $this
            ->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
        ;
    }
}
