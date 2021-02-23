<?php

namespace Tests\Feature\Admin\Posts;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /*
    |-------------------------------------------------------------------------
    | Common
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function the_edit_post_screen_can_be_rendered()
    {
        $this
            ->actingAs(
                $this->adminUser()
            )
            ->get(route('admin.posts.edit', Post::factory()->create()))
            ->assertStatus(200)
            ->assertViewIs('admin.posts.edit')
        ;
    }
}
