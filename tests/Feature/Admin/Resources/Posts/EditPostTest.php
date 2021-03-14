<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;

class EditPostTest extends TestCase
{
    /** @test */
    public function the_edit_post_screen_can_be_rendered()
    {
        $user = $this->authorUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->get(route('admin.posts.edit', $post))
            ->assertOk()
            ->assertViewIs('admin.posts.create-edit')
        ;
    }

    /** @test */
    public function a_user_without_permission_cannot_edit_posts()
    {
        $this->actingAs(
            $this->user()->assignPermissions('access')
        )->put(
            route('admin.posts.update', Post::factory()->create())
        )->assertForbidden();
    }
}
