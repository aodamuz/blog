<?php

namespace Tests\Feature\Admin\Resources\Posts;

class CreatePostTest extends TestCase
{
    /** @test */
    public function the_screen_for_creating_posts_can_be_rendered()
    {
        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.create'))
            ->assertOk()
            ->assertViewIs('admin.posts.create-edit')
        ;
    }

    /** @test */
    public function a_user_without_permission_cannot_create_posts() {
        $user = $this->user()->assignPermissions('access');

        $this->actingAs($user)->get(
            route('admin.posts.create')
        )->assertForbidden();
    }
}
