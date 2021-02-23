<?php

namespace Tests\Feature\Admin\Posts;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
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
        $post = Post::factory()->create();

        $this
            ->actingAs(
                User::factory()->create()
            )
            ->get(route('admin.posts.edit', $post))
            ->assertStatus(200)
            ->assertViewIs('admin.posts.edit')
        ;
    }
}
